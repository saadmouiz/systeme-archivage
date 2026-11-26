<?php

namespace App\Http\Controllers;

use App\Models\Archive\Employee;
use App\Models\Pointage;
use App\Support\AuditLogger;
use App\Support\CdcSchemaEnsurer;
use App\Support\ExcelExport;
use App\Support\PeriodLock;
use App\Support\RecordLockService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class PointageController extends Controller
{
    /**
     * Définir les autorisations d'accès
     */
    public function __construct()
    {
        // Appliquer le middleware 'auth' pour s'assurer que l'utilisateur est connecté
        $this->middleware('auth');

        // Appliquer le middleware 'can' pour vérifier les permissions spécifiques
        $this->middleware('can:access-pointages');
    }

    /**
     * Affiche la liste des pointages pour un mois spécifique.
     */
    public function index(Request $request)
    {
        // Vérifier la permission avant de continuer
        if (!auth()->user()->can('view_pointages')) {
            abort(403, 'Accès interdit.');
        }

        CdcSchemaEnsurer::ensure();

        // Mois et année par défaut (mois en cours)
        $mois = $request->mois ?? Carbon::now()->month;
        $annee = $request->annee ?? Carbon::now()->year;
        $genre = $request->genre;

        // Récupérer seulement les employés actifs
        $employeesQuery = Employee::actif()->orderBy('nom');
        if ($request->filled('genre') && Schema::hasColumn('employees', 'genre')) {
            $employeesQuery->where('genre', $request->genre);
        }
        $employees = $employeesQuery->get();

        // Créer un tableau avec tous les jours du mois
        $debut = Carbon::createFromDate($annee, $mois, 1)->startOfMonth();
        $fin = Carbon::createFromDate($annee, $mois, 1)->endOfMonth();
        $joursDuMois = collect(CarbonPeriod::create($debut, $fin));

        // Récupérer tous les pointages pour ce mois
        $pointages = Pointage::whereBetween('date', [$debut, $fin])
            ->when($employees->isNotEmpty(), fn ($q) => $q->whereIn('employee_id', $employees->pluck('id')))
            ->get()
            ->groupBy(['employee_id', function ($item) {
                return $item->date->format('Y-m-d');
            }])
            ->map(function ($employeePointages) {
                return $employeePointages->map(function ($datePointages) {
                    // Si plusieurs pointages existent pour la même date, prenez le premier
                    return $datePointages instanceof \Illuminate\Support\Collection ? 
                           $datePointages->first() : $datePointages;
                });
            });

        return view('archives.pointages.index', compact('employees', 'pointages', 'joursDuMois', 'mois', 'annee', 'genre'));
    }

    /**
     * Affiche le formulaire de pointage journalier.
     */
    public function create()
    {
        // Vérifier la permission avant de continuer
        if (!auth()->user()->can('create_pointages')) {
            abort(403, 'Accès interdit.');
        }

        $date = request('date') ? Carbon::parse(request('date')) : Carbon::today();
        $employees = Employee::actif()->orderBy('nom')->get();

        // Vérifier si des pointages existent déjà pour cette date
        $pointagesExistants = Pointage::where('date', $date->format('Y-m-d'))
            ->get()
            ->keyBy('employee_id');

        return view('archives.pointages.create', compact('employees', 'date', 'pointagesExistants'));
    }

    /**
     * Enregistre les pointages pour plusieurs employés.
     */
    public function store(Request $request)
    {
        // Vérifier la permission avant de continuer
        if (!auth()->user()->can('store_pointages')) {
            abort(403, 'Accès interdit.');
        }

        $date = Carbon::parse($request->date);
        PeriodLock::assertOpen((int) $date->year, 'pointages');

        // Valider les données pour chaque employé
        $request->validate([
            'employees' => 'required|array',
            'employees.*.statut' => 'required|in:present,absent,retard,conge,maladie,jour_ferie',
            'employees.*.heure_arrivee' => 'nullable|date_format:H:i',
            'employees.*.heure_sortie' => 'nullable|date_format:H:i',
            'employees.*.commentaire' => 'nullable|string',
        ]);

        foreach ($request->employees as $employeeId => $data) {
            // Vérifier si un pointage existe déjà pour cet employé à cette date
            $pointage = Pointage::firstOrNew([
                'employee_id' => $employeeId,
                'date' => $date->format('Y-m-d'),
            ]);

            $pointage->statut = $data['statut'];
            $pointage->heure_arrivee = ($data['statut'] === 'present' || $data['statut'] === 'retard') ? $data['heure_arrivee'] : null;
            $pointage->heure_sortie = ($data['statut'] === 'present' || $data['statut'] === 'retard') ? $data['heure_sortie'] : null;
            $pointage->commentaire = $data['commentaire'] ?? null;

            $pointage->save();
        }

        return redirect()->route('archives.pointages.index', [
            'mois' => $date->month,
            'annee' => $date->year
        ])->with('success', 'Les pointages ont été enregistrés avec succès.');
    }

    /**
     * Affiche la fiche de pointage d'un employé pour un mois spécifique.
     */
    public function show(Employee $employee, Request $request)
    {
        // Vérifier la permission avant de continuer
        if (!auth()->user()->can('view_employee_pointages')) {
            abort(403, 'Accès interdit.');
        }

        $mois = $request->mois ?? Carbon::now()->month;
        $annee = $request->annee ?? Carbon::now()->year;

        // Créer les dates de début et fin du mois
        $debut = Carbon::createFromDate($annee, $mois, 1)->startOfMonth();
        $fin = Carbon::createFromDate($annee, $mois, 1)->endOfMonth();

        // Générer tous les jours du mois (weekends inclus)
        $joursDuMois = collect(CarbonPeriod::create($debut, $fin));

        // Récupérer les pointages de l'employé pour ce mois
        $pointages = $employee->pointages()
            ->whereBetween('date', [$debut, $fin])
            ->orderBy('date')
            ->get()
            ->keyBy(function ($item) {
                return $item->date->format('Y-m-d');
            });

        // Calculer les statistiques
        $statistiques = [
            'jours_travailles' => $pointages->where('statut', 'present')->count(),
            'absences' => $pointages->where('statut', 'absent')->count(),
            'retards' => $pointages->where('statut', 'retard')->count(),
            'conges' => $pointages->where('statut', 'conge')->count(),
            'maladies' => $pointages->where('statut', 'maladie')->count(),
            'total_heures' => $this->calculerTotalHeures($pointages)
        ];

        return view('archives.pointages.show', compact('employee', 'pointages', 'joursDuMois', 'mois', 'annee', 'statistiques'));
    }

    /**
     * Calcule le total des heures travaillées
     */
    private function calculerTotalHeures($pointages)
    {
        return $pointages->where('statut', 'present')->sum(function ($pointage) {
            if ($pointage->heure_arrivee && $pointage->heure_sortie) {
                $arrivee = Carbon::parse($pointage->heure_arrivee);
                $sortie = Carbon::parse($pointage->heure_sortie);
                return $sortie->diffInHours($arrivee) + ($sortie->diffInMinutes($arrivee) % 60) / 60;
            }
            return 0;
        });
    }

    /**
     * Affiche le formulaire d'édition d'un pointage.
     */
    public function edit(Pointage $pointage)
    {
        // Vérifier la permission avant de continuer
        if (!auth()->user()->can('edit_pointages')) {
            abort(403, 'Accès interdit.');
        }

        PeriodLock::assertOpen((int) $pointage->date->year, 'pointages');

        $lockService = app(RecordLockService::class);
        $editLock = $lockService->acquire($pointage, auth()->user());
        $employees = Employee::actif()->orderBy('nom')->get();
        $employee = $pointage->employee;

        return view('archives.pointages.edit', compact('pointage', 'employees', 'employee', 'editLock'));
    }

    public function heartbeatLock(Pointage $pointage)
    {
        $ok = app(RecordLockService::class)->heartbeat($pointage, auth()->user());
        return response()->json(['ok' => $ok]);
    }

    public function releaseLock(Pointage $pointage)
    {
        app(RecordLockService::class)->release($pointage, auth()->user());
        return response()->json(['ok' => true]);
    }

    /**
     * Met à jour un pointage existant.
     */
    public function update(Request $request, Pointage $pointage)
    {
        // Vérifier la permission avant de continuer
        if (!auth()->user()->can('update_pointages')) {
            abort(403, 'Accès interdit.');
        }

        PeriodLock::assertOpen((int) $pointage->date->year, 'pointages');

        $lockService = app(RecordLockService::class);
        $lockResult = $lockService->acquire($pointage, auth()->user());
        if (!$lockResult['acquired']) {
            return back()->withInput()->with('error', $lockResult['message']);
        }

        $request->validate([
            'statut' => 'required|in:present,absent,retard,conge,maladie,jour_ferie',
            'heure_arrivee' => 'nullable|date_format:H:i',
            'heure_sortie' => 'nullable|date_format:H:i',
            'commentaire' => 'nullable|string',
        ]);

        $before = $pointage->only(['statut', 'heure_arrivee', 'heure_sortie', 'commentaire']);

        $pointage->statut = $request->statut;
        $pointage->heure_arrivee = ($request->statut === 'present' || $request->statut === 'retard') ? $request->heure_arrivee : null;
        $pointage->heure_sortie = ($request->statut === 'present' || $request->statut === 'retard') ? $request->heure_sortie : null;
        $pointage->commentaire = $request->commentaire;

        $pointage->save();

        $changes = AuditLogger::diff($pointage, $before, $pointage->only(['statut', 'heure_arrivee', 'heure_sortie', 'commentaire']));
        if ($changes) {
            AuditLogger::log($pointage, 'updated', $changes);
        }
        $lockService->release($pointage, auth()->user());

        return redirect()->route('archives.pointages.show', [
            'employee' => $pointage->employee,
            'mois' => $pointage->date->month,
            'annee' => $pointage->date->year
        ])->with('success', 'Le pointage a été mis à jour avec succès.');
    }

    /**
     * Supprime un pointage.
     */
    public function destroy(Pointage $pointage)
    {
        // Vérifier la permission avant de continuer
        if (!auth()->user()->can('delete_pointages')) {
            abort(403, 'Accès interdit.');
        }

        PeriodLock::assertOpen((int) $pointage->date->year, 'pointages');

        $employee = $pointage->employee;
        $mois = $pointage->date->month;
        $annee = $pointage->date->year;

        AuditLogger::log($pointage, 'deleted', [
            'employee_id' => $pointage->employee_id,
            'date' => optional($pointage->date)->format('Y-m-d'),
            'statut' => $pointage->statut,
        ]);
        $pointage->delete();

        return redirect()->route('archives.pointages.show', [
            'employee' => $employee,
            'mois' => $mois,
            'annee' => $annee
        ])->with('success', 'Le pointage a été supprimé avec succès.');
    }

    /**
     * Exporte les données de pointage au format PDF.
     */
    public function exportPdf(Request $request)
    {
        try {
            // Récupérer le mois et l'année (par défaut le mois courant)
            $mois = $request->input('mois', Carbon::now()->month);
            $annee = $request->input('annee', Carbon::now()->year);
    
            // Définir les dates de début et de fin du mois
            $debut = Carbon::createFromDate($annee, $mois, 1)->startOfMonth();
            $fin = Carbon::createFromDate($annee, $mois, 1)->endOfMonth();
    
            // Récupérer les employés actifs (filtre genre EVO-08)
            CdcSchemaEnsurer::ensure();
            $employeesQuery = Employee::actif()->orderBy('nom');
            if ($request->filled('genre') && Schema::hasColumn('employees', 'genre')) {
                $employeesQuery->where('genre', $request->genre);
            }
            $employees = $employeesQuery->get();
            
            // Créer un tableau avec tous les jours du mois
            $joursDuMois = collect(CarbonPeriod::create($debut, $fin));
    
            // Récupérer tous les pointages pour ce mois
            $pointages = Pointage::whereBetween('date', [$debut, $fin])
                ->when($employees->isNotEmpty(), fn ($q) => $q->whereIn('employee_id', $employees->pluck('id')))
                ->with('employee')
                ->get()
                ->groupBy(['employee_id', function ($item) {
                    return $item->date->format('Y-m-d');
                }])
                ->map(function ($employeePointages) {
                    return $employeePointages->map(function ($datePointages) {
                        return $datePointages instanceof \Illuminate\Support\Collection ? 
                               $datePointages->first() : $datePointages;
                    });
                });
    
            // Générer le PDF
            $pdf = \PDF::loadView('archives.pointages.pdf_export', [
                'employees' => $employees,
                'joursDuMois' => $joursDuMois,
                'pointages' => $pointages,
                'mois' => $mois,
                'annee' => $annee,
                'debut' => $debut,
                'fin' => $fin
            ])->setPaper('a4', 'landscape');
    
            // Télécharger le PDF
            return $pdf->download("pointages_{$annee}_{$mois}.pdf");
        } catch (\Exception $e) {
            \Log::error('Erreur export PDF: ' . $e->getMessage());
            return back()->with('error', 'Erreur lors de l\'export PDF : ' . $e->getMessage());
        }
    }

    public function exportExcel(Request $request)
    {
        ExcelExport::assertAvailable();

        $mois = $request->input('mois', Carbon::now()->month);
        $annee = $request->input('annee', Carbon::now()->year);
        $debut = Carbon::createFromDate($annee, $mois, 1)->startOfMonth();
        $fin = Carbon::createFromDate($annee, $mois, 1)->endOfMonth();

        CdcSchemaEnsurer::ensure();
        $employeesQuery = Employee::actif()->orderBy('nom');
        if ($request->filled('genre') && Schema::hasColumn('employees', 'genre')) {
            $employeesQuery->where('genre', $request->genre);
        }
        $employees = $employeesQuery->get();
        $joursDuMois = collect(CarbonPeriod::create($debut, $fin));

        $pointages = Pointage::whereBetween('date', [$debut, $fin])
            ->whereIn('employee_id', $employees->pluck('id'))
            ->get()
            ->groupBy(['employee_id', function ($item) {
                return $item->date->format('Y-m-d');
            }]);

        $headers = ['Employé'];
        foreach ($joursDuMois as $jour) {
            $headers[] = $jour->format('d');
        }

        $rows = [];
        foreach ($employees as $employee) {
            $row = [$employee->nom . ' ' . $employee->prenom];
            foreach ($joursDuMois as $jour) {
                $key = $jour->format('Y-m-d');
                $p = data_get($pointages, $employee->id . '.' . $key);
                if ($p instanceof \Illuminate\Support\Collection) {
                    $p = $p->first();
                }
                $row[] = $p->statut ?? '-';
            }
            $rows[] = $row;
        }

        return ExcelExport::download(
            "pointages_{$annee}_{$mois}.xlsx",
            'Pointages',
            $headers,
            $rows
        );
    }

    public function printReport(Request $request)
    {
        $mois = $request->input('mois', Carbon::now()->month);
        $annee = $request->input('annee', Carbon::now()->year);
        $debut = Carbon::createFromDate($annee, $mois, 1)->startOfMonth();
        $fin = Carbon::createFromDate($annee, $mois, 1)->endOfMonth();
        $joursDuMois = collect(CarbonPeriod::create($debut, $fin));

        CdcSchemaEnsurer::ensure();
        $employeesQuery = Employee::actif()->orderBy('nom');
        if ($request->filled('genre') && Schema::hasColumn('employees', 'genre')) {
            $employeesQuery->where('genre', $request->genre);
        }
        $employees = $employeesQuery->get();

        $pointages = Pointage::whereBetween('date', [$debut, $fin])
            ->whereIn('employee_id', $employees->pluck('id'))
            ->get()
            ->groupBy(['employee_id', function ($item) {
                return $item->date->format('Y-m-d');
            }])
            ->map(function ($employeePointages) {
                return $employeePointages->map(function ($datePointages) {
                    return $datePointages instanceof \Illuminate\Support\Collection ?
                           $datePointages->first() : $datePointages;
                });
            });

        return view('archives.pointages.print', compact('employees', 'joursDuMois', 'pointages', 'mois', 'annee'));
    }

    /**
     * Méthode alternative pour afficher la fiche d'un employé
     */
    public function fiche(Employee $employee, Request $request)
    {
        $mois = $request->input('mois', now()->month);
        $annee = $request->input('annee', now()->year);

        // Récupérer les pointages de l'employé selon le mois et l'année
        $pointages = $employee->pointages()
            ->whereMonth('date', $mois)
            ->whereYear('date', $annee)
            ->get();

        return view('archives.pointages.show', compact('employee', 'mois', 'annee', 'pointages'));
    }
}