<?php

namespace App\Http\Controllers;

use App\Models\AssociationPartenaire;
use App\Http\Controllers\Controller;
use App\Models\Beneficiaire;
use App\Models\BeneficiaireParcours;
use App\Support\AuditLogger;
use App\Support\CdcSchemaEnsurer;
use App\Support\PeriodLock;
use App\Support\RecordLockService;
use App\Support\SearchNormalizer;
use Illuminate\Validation\Rule;
use App\Models\ArchivePartenaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class BeneficiaireController extends Controller
{
    protected $types = [
        'Dossier individuel' => 'Dossier individuel',
        'Document éducatif' => 'Document éducatif',
        'Conflits d\'ordre juridique' => 'Conflits d\'ordre juridique'
    ];

    protected $niveaux = [
        '1ère année collège' => '1ère année collège',
        '2ème année collège' => '2ème année collège',
        '3ème année collège' => '3ème année collège',
        'Tronc Commun' => 'Tronc Commun',
        '1ère année bac' => '1ère année bac',
        '2ème année bac' => '2ème année bac',
        'Niveau Bac' => 'Niveau Bac',
        'Bac' => 'Bac',
        'Bac+2' => 'Bac+2',
        'Bac+3' => 'Bac+3'
    ];

    private function getEcolesForFilter()
    {
        return ArchivePartenaire::query()
            ->orderBy('nom')
            ->get();
    }

    private function normalizeBeneficiaireType(string $type): string
    {
        $normalized = mb_strtolower(trim($type));
        $normalized = str_replace(['é', 'è', 'ê', 'ë'], 'e', $normalized);

        if (str_contains($normalized, 'document') && str_contains($normalized, 'educatif')) {
            return 'Document éducatif';
        }

        if (str_contains($normalized, 'dossier') && str_contains($normalized, 'individuel')) {
            return 'Dossier individuel';
        }

        if (str_contains($normalized, 'conflits') && str_contains($normalized, 'juridique')) {
            return 'Conflits d\'ordre juridique';
        }

        return $type;
    }

    private function applySearchFilters(Builder $query, string $search): void
    {
        $terms = preg_split('/\s+/', trim($search)) ?: [];
        $terms = array_values(array_filter($terms, fn ($term) => $term !== ''));

        foreach ($terms as $term) {
            $normalized = SearchNormalizer::normalize($term);
            $like = '%' . $normalized . '%';

            $query->where(function ($q) use ($term, $like, $normalized) {
                $nomExpr = SearchNormalizer::sqlExpr('nom');
                $prenomExpr = SearchNormalizer::sqlExpr('prenom');
                $cinExpr = SearchNormalizer::sqlExpr('cin');
                $refExpr = SearchNormalizer::sqlExpr('reference');

                $q->whereRaw("{$nomExpr} LIKE ?", [$like])
                  ->orWhereRaw("{$prenomExpr} LIKE ?", [$like])
                  ->orWhereRaw("{$cinExpr} LIKE ?", [$like])
                  ->orWhereRaw("{$refExpr} LIKE ?", [$like])
                  ->orWhereHas('ecole', function ($ecoleQuery) use ($like) {
                      $ecoleExpr = SearchNormalizer::sqlExpr('nom');
                      $ecoleQuery->whereRaw("{$ecoleExpr} LIKE ?", [$like]);
                  });

                // Colonne ajoutée par migration : ignorer si absente en prod.
                if (Schema::hasColumn('beneficiaires', 'nom_association')) {
                    $assocExpr = SearchNormalizer::sqlExpr('nom_association');
                    $q->orWhereRaw("{$assocExpr} LIKE ?", [$like]);
                }

                // Année saisie seule: couvre explicitement XX/YYYY et XX-YYYY.
                if (preg_match('/^\d{4}$/', $normalized)) {
                    $q->orWhere('reference', 'like', "%/{$normalized}")
                      ->orWhere('reference', 'like', "%-{$normalized}")
                      ->orWhere('reference', 'like', "%/{$normalized}/%")
                      ->orWhere('reference', 'like', "%-{$normalized}-%");
                }
            });
        }
    }

    private function findDuplicateBeneficiaire(?string $cin, ?string $nom, ?string $prenom, $dateNaissance = null, ?int $ignoreId = null): ?Beneficiaire
    {
        if ($cin) {
            $cin = trim($cin);
            $query = Beneficiaire::query()->whereRaw(SearchNormalizer::sqlExpr('cin') . ' = ?', [SearchNormalizer::normalize($cin)]);
            if ($ignoreId) {
                $query->where('id', '!=', $ignoreId);
            }
            $byCin = $query->first();
            if ($byCin) {
                return $byCin;
            }
        }

        if ($nom && $prenom && $dateNaissance && Schema::hasColumn('beneficiaires', 'date_naissance')) {
            $query = Beneficiaire::query()
                ->whereRaw(SearchNormalizer::sqlExpr('nom') . ' = ?', [SearchNormalizer::normalize($nom)])
                ->whereRaw(SearchNormalizer::sqlExpr('prenom') . ' = ?', [SearchNormalizer::normalize($prenom)])
                ->whereDate('date_naissance', $dateNaissance);
            if ($ignoreId) {
                $query->where('id', '!=', $ignoreId);
            }
            return $query->first();
        }

        return null;
    }

    public function checkCin(Request $request)
    {
        $cin = trim((string) $request->query('cin', ''));
        $nom = trim((string) $request->query('nom', ''));
        $prenom = trim((string) $request->query('prenom', ''));
        $dateNaissance = $request->query('date_naissance');

        if ($cin === '' && ($nom === '' || $prenom === '' || !$dateNaissance)) {
            return response()->json(['exists' => false]);
        }

        $existing = $this->findDuplicateBeneficiaire(
            $cin !== '' ? $cin : null,
            $nom !== '' ? $nom : null,
            $prenom !== '' ? $prenom : null,
            $dateNaissance ?: null
        );

        if (!$existing) {
            return response()->json(['exists' => false]);
        }

        return response()->json([
            'exists' => true,
            'beneficiaire' => [
                'id' => $existing->id,
                'reference' => $existing->reference,
                'nom' => $existing->nom,
                'prenom' => $existing->prenom,
                'cin' => $existing->cin,
                'show_url' => route('archives.beneficiaires.show', $existing),
                'edit_url' => route('archives.beneficiaires.edit', $existing),
            ],
            'message' => sprintf(
                'Attention : Un bénéficiaire avec le CIN %s existe déjà dans le système (Réf: %s - %s %s).',
                $existing->cin ?: 'N/A',
                $existing->reference ?: 'N/A',
                $existing->nom,
                $existing->prenom
            ),
        ]);
    }

    /**
     * Filtre par année extraite de la référence (ex: 21/2019 → 2019).
     */
    private function applyReferenceYearFilter(Builder $query, string $annee): void
    {
        $annee = preg_replace('/\D/', '', $annee);
        if ($annee === '' || strlen($annee) !== 4) {
            return;
        }

        $query->where(function ($q) use ($annee) {
            $q->where('reference', 'like', "%/{$annee}")
              ->orWhere('reference', 'like', "%-{$annee}")
              ->orWhere('reference', 'like', "%/{$annee}/%")
              ->orWhere('reference', 'like', "%-{$annee}-%");
        });
    }

    private function getAvailableAnnees(Request $request, bool $refusedOnly = false): array
    {
        $query = Beneficiaire::query();

        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        if ($request->filled('ecole')) {
            $query->where('ecole_id', $request->ecole);
        }

        if ($refusedOnly) {
            $query->where('status', 'Refuser');
        } else {
            $query->where(function ($q) {
                $q->where('status', '!=', 'Refuser')
                  ->orWhereNull('status');
            });
        }

        $years = [];

        $references = (clone $query)
            ->whereNotNull('reference')
            ->where('reference', '!=', '')
            ->pluck('reference');

        foreach ($references as $reference) {
            // Priorité au format XX/YYYY ou XX-YYYY
            if (preg_match_all('/[\/\-]((?:19|20)\d{2})\b/', (string) $reference, $matches)) {
                foreach ($matches[1] as $year) {
                    $years[] = (int) $year;
                }
            } elseif (preg_match_all('/\b((?:19|20)\d{2})\b/', (string) $reference, $matches)) {
                foreach ($matches[1] as $year) {
                    $years[] = (int) $year;
                }
            }
        }

        $years = array_values(array_unique(array_filter($years, fn ($year) => $year >= 1900 && $year <= 2100)));
        rsort($years);

        return $years;
    }

    private function applyBeneficiaireListFilters(Builder $query, Request $request): void
    {
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('ecole')) {
            $query->where('ecole_id', $request->ecole);
        }

        if ($request->filled('annee')) {
            $this->applyReferenceYearFilter($query, (string) $request->annee);
        }

        if ($request->filled('situation_sociale') && Schema::hasColumn('beneficiaires', 'situation_sociale')) {
            $query->where('situation_sociale', $request->situation_sociale);
        }

        if ($request->filled('societe')) {
            $query->where('societe', 'like', '%' . $request->societe . '%');
        }

        if ($request->filled('type_intervention')) {
            $query->where('type_intervention', $request->type_intervention);
        }

        if ($request->filled('search')) {
            $this->applySearchFilters($query, trim($request->search));
        }
    }

    public function index(Request $request)
    {
        // Forcer la reconnexion à la base de données
        DB::purge();
        DB::reconnect();
        CdcSchemaEnsurer::ensure();
        
        $query = Beneficiaire::with('ecole');

        // Filtrage par type
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        // Filtrage par école
        if ($request->filled('ecole')) {
            $query->where('ecole_id', $request->ecole);
        }

        // Filtrage par année (basé sur la référence, ex: 21/2019 → 2019)
        if ($request->filled('annee')) {
            $this->applyReferenceYearFilter($query, (string) $request->annee);
        }

        if ($request->filled('situation_sociale') && Schema::hasColumn('beneficiaires', 'situation_sociale')) {
            $query->where('situation_sociale', $request->situation_sociale);
        }

        if ($request->filled('societe')) {
            $query->where('societe', 'like', '%' . $request->societe . '%');
        }

        if ($request->filled('type_intervention')) {
            $query->where('type_intervention', $request->type_intervention);
        }

        // Recherche
        if ($request->filled('search')) {
            $search = trim($request->search);
            $this->applySearchFilters($query, $search);
        }

        // Exclure les bénéficiaires refusés (status = 'Refuser')
        $query->where(function($q) {
            $q->where('status', '!=', 'Refuser')
              ->orWhereNull('status');
        });

        $beneficiaires = $query->orderBy('id', 'asc')->get()->groupBy('type');

        // Récupérer les écoles et centres pour le filtre
        $ecoles = $this->getEcolesForFilter();

        return view('archives.beneficiaires.index', [
            'beneficiaires' => $beneficiaires,
            'types' => array_values($this->types),
            'ecoles' => $ecoles,
            'annees' => $this->getAvailableAnnees($request, false),
            'situationsSociales' => Beneficiaire::SITUATIONS_SOCIALES,
        ]);
    }

    public function create()
    {
        $ecoles = $this->getEcolesForFilter();

        return view('archives.beneficiaires.create', [
            'types' => $this->types,
            'niveaux' => $this->niveaux,
            'ecoles' => $ecoles,
            'situationsSociales' => Beneficiaire::SITUATIONS_SOCIALES,
        ]);
    }
    public function store(Request $request)
    {
        // FIX: Vérifier et créer les colonnes si elles n'existent pas
        try {
            CdcSchemaEnsurer::ensure();
            // Log de la base de données utilisée
            $dbName = \DB::connection()->getDatabaseName();
            \Log::info('Base de données utilisée: ' . $dbName);
            
            // Vérifier et créer la colonne ville
            $columnExists = \DB::select("SHOW COLUMNS FROM beneficiaires WHERE Field = 'ville'");
            if (empty($columnExists)) {
                \DB::statement("ALTER TABLE beneficiaires ADD COLUMN ville VARCHAR(255) NULL AFTER prenom");
                \Log::info('Colonne ville ajoutée automatiquement à la table beneficiaires dans ' . $dbName);
            }
            
            // Vérifier et créer la colonne niveau_scolarite
            $columnExists = \DB::select("SHOW COLUMNS FROM beneficiaires WHERE Field = 'niveau_scolarite'");
            if (empty($columnExists)) {
                \DB::statement("ALTER TABLE beneficiaires ADD COLUMN niveau_scolarite VARCHAR(255) NULL");
                \Log::info('Colonne niveau_scolarite ajoutée automatiquement à la table beneficiaires dans ' . $dbName);
            }
            
            // Vérifier et créer la colonne services_offerts
            $columnExists = \DB::select("SHOW COLUMNS FROM beneficiaires WHERE Field = 'services_offerts'");
            if (empty($columnExists)) {
                \DB::statement("ALTER TABLE beneficiaires ADD COLUMN services_offerts VARCHAR(255) NULL");
                \Log::info('Colonne services_offerts ajoutée automatiquement à la table beneficiaires dans ' . $dbName);
            }
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la vérification des colonnes: ' . $e->getMessage());
        }
        
        $validated = $request->validate([
            'type' => 'required|string',
            'reference' => 'nullable|string|max:255',
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'ville' => 'required|string|max:255',
            'cin' => 'nullable|string',
            'age' => 'nullable|integer|min:1|max:120',
            'date_naissance' => 'nullable|date',
            'genre' => [
                'nullable',
                Rule::requiredIf(fn() => $request->type === 'Document éducatif'),
                'in:Homme,Femme'
            ],
            'situation_sociale' => 'required|string|in:' . implode(',', array_keys(Beneficiaire::SITUATIONS_SOCIALES)),
            'situation_sociale_precision' => [
                'nullable',
                Rule::requiredIf(fn() => $request->situation_sociale === 'autre'),
                'string',
                'max:255',
            ],
            'status' => [
                'nullable',
                Rule::requiredIf(fn() => $request->type === 'Document éducatif'),
                'in:Accepter,Refuser'
            ],
            'ass_eps' => [
                'nullable',
                Rule::requiredIf(fn() => $request->type === 'Document éducatif'),
                'in:Association,Eps'
            ],
            'nom_association' => 'nullable|string|max:255',
            'niveau' => [
                'nullable',
                Rule::requiredIf(fn() => $request->type === 'Dossier individuel'),
                'in:1ère année collège,2ème année collège,3ème année collège,Tronc Commun,1ère année bac,2ème année bac,Niveau Bac,Bac,Bac+2,Bac+3'
            ],
            'specialite' => [
                'nullable',
                Rule::requiredIf(fn() => $request->type === 'Dossier individuel'),
                'string',
                'max:255'
            ],
            'type_intervention' => [
                'nullable',
                'in:IP,AGR'
            ],
            'societe' => 'nullable|string|max:255',
            'niveau_scolarite' => [
                'nullable',
                'in:Analphabète,Primaire,Collège,Lycée,Baccalauréat,Bac+2,Bac+3,Bac+4,Bac+5,Supérieur'
            ],
            'services_offerts' => 'nullable|string|max:255',
            'description' => 'nullable|string',                
            'ecole_id' => [
                'nullable',
                Rule::requiredIf(fn() => $request->type === 'Document éducatif'),
                'exists:archive_partenaires,id'
            ],
            'filiere' => [
                'nullable',
                Rule::requiredIf(fn() => $request->type === 'Document éducatif'),
                'string',
                'max:255'
            ],
            'fichier' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240'
        ]);
        $validated['type'] = $this->normalizeBeneficiaireType($validated['type']);

        $duplicate = $this->findDuplicateBeneficiaire(
            $validated['cin'] ?? null,
            $validated['nom'] ?? null,
            $validated['prenom'] ?? null,
            $validated['date_naissance'] ?? null
        );
        if ($duplicate) {
            return back()
                ->withInput()
                ->with('duplicate_warning', sprintf(
                    'Attention : Un bénéficiaire avec le CIN %s existe déjà dans le système (Réf: %s - %s %s).',
                    $duplicate->cin ?: 'N/A',
                    $duplicate->reference ?: 'N/A',
                    $duplicate->nom,
                    $duplicate->prenom
                ))
                ->with('duplicate_id', $duplicate->id);
        }

        if (($validated['situation_sociale'] ?? null) !== 'autre') {
            $validated['situation_sociale_precision'] = null;
        }
    
        try {
            if ($request->hasFile('fichier')) {
                $file = $request->file('fichier');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $validated['fichier'] = $file->storeAs('beneficiaires', $fileName, 'public');
            }
    
            // Nettoyer les données selon le type de dossier
            if ($validated['type'] === 'Dossier individuel') {
                // Pour Dossier individuel, supprimer les champs éducatifs (garder genre)
                $validated['status'] = null;
                $validated['ass_eps'] = null;
                $validated['nom_association'] = null;
                $validated['ecole_id'] = null;
            } elseif ($validated['type'] === 'Document éducatif') {
                // Pour Document éducatif, supprimer les champs académiques et société
                $validated['niveau'] = null;
                $validated['specialite'] = null;
                $validated['type_intervention'] = null;
                $validated['societe'] = null;
                if (($validated['ass_eps'] ?? null) !== 'Association') {
                    $validated['nom_association'] = null;
                }
            } else {
                // Pour les autres types, supprimer tous les champs conditionnels
                $validated['genre'] = null;
                $validated['status'] = null;
                $validated['ass_eps'] = null;
                $validated['nom_association'] = null;
                $validated['ecole_id'] = null;
                $validated['niveau'] = null;
                $validated['specialite'] = null;
                $validated['type_intervention'] = null;
                $validated['societe'] = null;
            }
    
            $year = PeriodLock::yearFromReference($validated['reference'] ?? null)
                ?? PeriodLock::yearFromAcademique($validated['annee_academique'] ?? null);
            if ($year) {
                PeriodLock::assertOpen($year, 'beneficiaires');
            }

            $beneficiaire = Beneficiaire::create($validated);
            $this->ensureCurrentParcours($beneficiaire);
            AuditLogger::log($beneficiaire, 'created', ['fields' => array_keys($validated)]);
    
            return redirect()->route('archives.beneficiaires.index')
                ->with('success', 'Dossier bénéficiaire ajouté avec succès');
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la création du bénéficiaire:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $request->all()
            ]);
            return back()->withInput()->withErrors(['error' => 'Erreur lors de la création: ' . $e->getMessage()]);
        }
    }

    public function show(Beneficiaire $beneficiaire)
    {
        $this->ensureCurrentParcours($beneficiaire);
        $beneficiaire->load(['ecole', 'parcours.ecole', 'auditLogs']);
        return view('archives.beneficiaires.show', compact('beneficiaire'));
    }

    public function edit(Beneficiaire $beneficiaire)
    {
        $year = PeriodLock::yearFromReference($beneficiaire->reference)
            ?? PeriodLock::yearFromAcademique($beneficiaire->annee_academique);
        if ($year) {
            PeriodLock::assertOpen($year, 'beneficiaires');
        }

        $lockService = app(RecordLockService::class);
        $lockResult = $lockService->acquire($beneficiaire, auth()->user());

        // Récupérer les écoles et centres pour le formulaire
        $ecoles = $this->getEcolesForFilter()->pluck('nom', 'id');

        return view('archives.beneficiaires.edit', [
            'beneficiaire' => $beneficiaire,
            'types' => $this->types,
            'niveaux' => $this->niveaux,
            'ecoles' => $ecoles,
            'situationsSociales' => Beneficiaire::SITUATIONS_SOCIALES,
            'editLock' => $lockResult,
        ]);
    }

    public function heartbeatLock(Beneficiaire $beneficiaire)
    {
        $ok = app(RecordLockService::class)->heartbeat($beneficiaire, auth()->user());
        return response()->json(['ok' => $ok]);
    }

    public function releaseLock(Beneficiaire $beneficiaire)
    {
        app(RecordLockService::class)->release($beneficiaire, auth()->user());
        return response()->json(['ok' => true]);
    }

    public function reorientForm(Beneficiaire $beneficiaire)
    {
        $this->ensureCurrentParcours($beneficiaire);
        $beneficiaire->load(['ecole', 'parcoursActuel.ecole']);
        $ecoles = $this->getEcolesForFilter()->pluck('nom', 'id');

        return view('archives.beneficiaires.reorient', [
            'beneficiaire' => $beneficiaire,
            'ecoles' => $ecoles,
            'statutsFin' => BeneficiaireParcours::STATUTS_FIN,
        ]);
    }

    public function reorient(Request $request, Beneficiaire $beneficiaire)
    {
        $validated = $request->validate([
            'ecole_id' => 'required|exists:archive_partenaires,id',
            'filiere' => 'required|string|max:255',
            'niveau' => 'nullable|string|max:255',
            'annee_academique' => 'required|string|max:20',
            'statut_ancien' => 'required|in:Validé,Réorienté,Abandon',
            'notes' => 'nullable|string|max:1000',
        ]);

        $year = PeriodLock::yearFromAcademique($validated['annee_academique']);
        if ($year) {
            PeriodLock::assertOpen($year, 'beneficiaires');
        }

        DB::transaction(function () use ($beneficiaire, $validated) {
            $this->ensureCurrentParcours($beneficiaire);
            $current = $beneficiaire->parcours()->where('is_current', true)->first();

            if ($current) {
                $current->update([
                    'is_current' => false,
                    'statut' => $validated['statut_ancien'],
                    'ended_at' => now(),
                ]);
            } else {
                // Archive snapshot from fiche if somehow missing
                BeneficiaireParcours::create([
                    'beneficiaire_id' => $beneficiaire->id,
                    'ecole_id' => $beneficiaire->ecole_id,
                    'filiere' => $beneficiaire->filiere,
                    'niveau' => $beneficiaire->niveau,
                    'annee_academique' => $beneficiaire->annee_academique,
                    'statut' => $validated['statut_ancien'],
                    'is_current' => false,
                    'started_at' => $beneficiaire->created_at,
                    'ended_at' => now(),
                    'created_by' => auth()->id(),
                ]);
            }

            BeneficiaireParcours::create([
                'beneficiaire_id' => $beneficiaire->id,
                'ecole_id' => $validated['ecole_id'],
                'filiere' => $validated['filiere'],
                'niveau' => $validated['niveau'] ?? null,
                'annee_academique' => $validated['annee_academique'],
                'statut' => 'Actuel',
                'is_current' => true,
                'notes' => $validated['notes'] ?? null,
                'started_at' => now(),
                'created_by' => auth()->id(),
            ]);

            $beneficiaire->update([
                'ecole_id' => $validated['ecole_id'],
                'filiere' => $validated['filiere'],
                'niveau' => $validated['niveau'] ?? $beneficiaire->niveau,
                'annee_academique' => $validated['annee_academique'],
            ]);

            AuditLogger::log($beneficiaire, 'reorientation', [
                'ancien_statut' => $validated['statut_ancien'],
                'nouvelle_ecole_id' => $validated['ecole_id'],
                'nouvelle_filiere' => $validated['filiere'],
                'annee_academique' => $validated['annee_academique'],
            ]);
        });

        return redirect()
            ->route('archives.beneficiaires.show', $beneficiaire)
            ->with('success', 'Réorientation enregistrée. L\'historique du parcours a été conservé.');
    }

    private function ensureCurrentParcours(Beneficiaire $beneficiaire): void
    {
        if ($beneficiaire->parcours()->exists()) {
            return;
        }

        // Seed initial parcours from current fiche fields (document éducatif or any with ecole/filiere)
        if (!$beneficiaire->ecole_id && !$beneficiaire->filiere && !$beneficiaire->annee_academique) {
            return;
        }

        BeneficiaireParcours::create([
            'beneficiaire_id' => $beneficiaire->id,
            'ecole_id' => $beneficiaire->ecole_id,
            'filiere' => $beneficiaire->filiere,
            'niveau' => $beneficiaire->niveau,
            'annee_academique' => $beneficiaire->annee_academique
                ?? (PeriodLock::yearFromReference($beneficiaire->reference)
                    ? PeriodLock::yearFromReference($beneficiaire->reference) . '/' . (PeriodLock::yearFromReference($beneficiaire->reference) + 1)
                    : null),
            'statut' => 'Actuel',
            'is_current' => true,
            'started_at' => $beneficiaire->created_at ?? now(),
            'created_by' => auth()->id(),
        ]);
    }

    public function update(Request $request, Beneficiaire $beneficiaire)
    {
        $validated = $request->validate([
            'type' => 'required|string',
            'reference' => 'nullable|string|max:255',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'ville' => 'required|string|max:255',
            'cin' => 'nullable|string|max:20',
            'age' => 'nullable|integer|min:1|max:120',
            'date_naissance' => 'nullable|date',
            'genre' => [
                'nullable',
                'required_if:type,Document éducatif',
                'in:Homme,Femme'
            ],
            'situation_sociale' => 'required|string|in:' . implode(',', array_keys(Beneficiaire::SITUATIONS_SOCIALES)),
            'situation_sociale_precision' => [
                'nullable',
                Rule::requiredIf(fn() => $request->situation_sociale === 'autre'),
                'string',
                'max:255',
            ],
            'status' => [
                'nullable',
                'required_if:type,Document éducatif',
                'in:Accepter,Refuser'
            ],
            'ass_eps' => [
                'nullable',
                'required_if:type,Document éducatif',
                'in:Association,Eps'
            ],
            'nom_association' => 'nullable|string|max:255',
            'niveau' => [
                'nullable',
                'required_if:type,Dossier individuel',
                'in:1ère année collège,2ème année collège,3ème année collège,Tronc Commun,1ère année bac,2ème année bac,Niveau Bac,Bac,Bac+2,Bac+3'
            ],
            'specialite' => [
                'nullable',
                'required_if:type,Dossier individuel',
                'string',
                'max:255'
            ],
            'type_intervention' => [
                'nullable',
                'in:IP,AGR'
            ],
            'societe' => 'nullable|string|max:255',
            'niveau_scolarite' => [
                'nullable',
                'in:Analphabète,Primaire,Collège,Lycée,Baccalauréat,Bac+2,Bac+3,Bac+4,Bac+5,Supérieur'
            ],
            'services_offerts' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'ecole_id' => [
                'nullable',
                'required_if:type,Document éducatif',
                'exists:archive_partenaires,id'
            ],
            'fichier' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240'
        ]);
        $validated['type'] = $this->normalizeBeneficiaireType($validated['type']);

        $duplicate = $this->findDuplicateBeneficiaire(
            $validated['cin'] ?? null,
            $validated['nom'] ?? null,
            $validated['prenom'] ?? null,
            $validated['date_naissance'] ?? null,
            $beneficiaire->id
        );
        if ($duplicate) {
            return back()
                ->withInput()
                ->with('duplicate_warning', sprintf(
                    'Attention : Un bénéficiaire avec le CIN %s existe déjà dans le système (Réf: %s - %s %s).',
                    $duplicate->cin ?: 'N/A',
                    $duplicate->reference ?: 'N/A',
                    $duplicate->nom,
                    $duplicate->prenom
                ))
                ->with('duplicate_id', $duplicate->id);
        }

        if (($validated['situation_sociale'] ?? null) !== 'autre') {
            $validated['situation_sociale_precision'] = null;
        }

        if ($request->hasFile('fichier')) {
            if ($beneficiaire->fichier) {
                Storage::disk('public')->delete($beneficiaire->fichier);
            }
            
            $file = $request->file('fichier');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $validated['fichier'] = $file->storeAs('beneficiaires', $fileName, 'public');
        }

        // Nettoyer les données selon le type de dossier
        if ($validated['type'] === 'Dossier individuel') {
            // Pour Dossier individuel, supprimer les champs éducatifs (garder genre)
            $validated['status'] = null;
            $validated['ass_eps'] = null;
            $validated['nom_association'] = null;
            $validated['ecole_id'] = null;
        } elseif ($validated['type'] === 'Document éducatif') {
            // Pour Document éducatif, supprimer les champs académiques et société
            $validated['niveau'] = null;
            $validated['specialite'] = null;
            $validated['type_intervention'] = null;
            $validated['societe'] = null;
            if (($validated['ass_eps'] ?? null) !== 'Association') {
                $validated['nom_association'] = null;
            }
        } else {
            // Pour les autres types, supprimer tous les champs conditionnels
            $validated['genre'] = null;
            $validated['status'] = null;
            $validated['ass_eps'] = null;
            $validated['nom_association'] = null;
            $validated['ecole_id'] = null;
            $validated['niveau'] = null;
            $validated['specialite'] = null;
            $validated['type_intervention'] = null;
            $validated['societe'] = null;
        }

        $year = PeriodLock::yearFromReference($validated['reference'] ?? $beneficiaire->reference)
            ?? PeriodLock::yearFromAcademique($beneficiaire->annee_academique);
        if ($year) {
            PeriodLock::assertOpen($year, 'beneficiaires');
        }

        $lockService = app(RecordLockService::class);
        $lockResult = $lockService->acquire($beneficiaire, auth()->user());
        if (!$lockResult['acquired']) {
            return back()->withInput()->with('error', $lockResult['message']);
        }

        // Détecter le changement de statut de 'Accepter' à 'Refuser'
        $ancienStatus = $beneficiaire->status;
        $nouveauStatus = $validated['status'] ?? null;
        $before = $beneficiaire->only(array_keys($validated));
        
        $beneficiaire->update($validated);
        $changes = AuditLogger::diff($beneficiaire, $before, $beneficiaire->only(array_keys($validated)));
        if ($changes) {
            AuditLogger::log($beneficiaire, 'updated', $changes);
        }
        $this->ensureCurrentParcours($beneficiaire);
        $current = $beneficiaire->parcours()->where('is_current', true)->first();
        if ($current && $beneficiaire->type === 'Document éducatif') {
            $current->update([
                'ecole_id' => $beneficiaire->ecole_id,
                'filiere' => $beneficiaire->filiere,
                'niveau' => $beneficiaire->niveau,
                'annee_academique' => $beneficiaire->annee_academique,
            ]);
        }
        $lockService->release($beneficiaire, auth()->user());

        // Si le statut passe de 'Accepter' à 'Refuser', rediriger vers la page des refusés
        if ($ancienStatus === 'Accepter' && $nouveauStatus === 'Refuser') {
            return redirect()->route('archives.beneficiaires.refused')
                ->with('success', 'Le dossier a été marqué comme refusé et déplacé vers la liste des bénéficiaires refusés.');
        }

        return redirect()->route('archives.beneficiaires.show', $beneficiaire)
            ->with('success', 'Dossier bénéficiaire mis à jour avec succès');
    }

    public function destroy(Beneficiaire $beneficiaire)
    {
        $year = PeriodLock::yearFromReference($beneficiaire->reference)
            ?? PeriodLock::yearFromAcademique($beneficiaire->annee_academique);
        if ($year) {
            PeriodLock::assertOpen($year, 'beneficiaires');
        }

        if ($beneficiaire->fichier) {
            Storage::disk('public')->delete($beneficiaire->fichier);
        }

        AuditLogger::log($beneficiaire, 'deleted', [
            'nom' => $beneficiaire->nom,
            'prenom' => $beneficiaire->prenom,
            'cin' => $beneficiaire->cin,
            'reference' => $beneficiaire->reference,
        ]);
        
        $beneficiaire->delete();

        return redirect()->route('archives.beneficiaires.index')
            ->with('success', 'Dossier bénéficiaire supprimé avec succès');
    }

    public function download($id)
{
    $beneficiaire = Beneficiaire::findOrFail($id);

    if ($beneficiaire->fichier) {
        // Utiliser le chemin stocké dans la base de données
        $filePath = $beneficiaire->fichier;

        // Utiliser le disque public de Laravel
        if (Storage::disk('public')->exists($filePath)) {
            return Storage::disk('public')->download(
                $filePath, 
                $this->sanitizeFileName($beneficiaire->nom . '_' . $beneficiaire->prenom . '_document', $filePath)
            );
        }
    }

    return redirect()->back()->with('error', 'Fichier non trouvé.');
}

// Méthode utilitaire pour nettoyer les noms de fichiers
private function sanitizeFileName($baseFileName, $filePath)
{
    // Supprimer les caractères spéciaux et les espaces
    $baseFileName = preg_replace('/[^a-zA-Z0-9_-]/', '', $baseFileName);
    
    // Obtenir l'extension à partir du chemin du fichier
    $extension = pathinfo($filePath, PATHINFO_EXTENSION);
    
    return $baseFileName . '.' . $extension;
}

    public function liste(Request $request)
    {
        $baseQuery = Beneficiaire::query();
        $this->applyBeneficiaireListFilters($baseQuery, $request);

        $total = (clone $baseQuery)->count();
        $totalFilles = (clone $baseQuery)->where('genre', 'Femme')->count();
        $totalGarcons = (clone $baseQuery)->where('genre', 'Homme')->count();
        
        $beneficiaires = $this->getBeneficiairesListData($request, true);
        $annees = $this->getAvailableAnnees($request, false);

        return view('archives.beneficiaires.liste', compact(
            'beneficiaires',
            'total',
            'totalFilles',
            'totalGarcons',
            'annees'
        ));
    }

    public function exportListePdf(Request $request)
    {
        $beneficiaires = $this->getBeneficiairesListData($request, false);

        $baseQuery = Beneficiaire::query();
        $this->applyBeneficiaireListFilters($baseQuery, $request);

        $total = (clone $baseQuery)->count();
        $totalFilles = (clone $baseQuery)->where('genre', 'Femme')->count();
        $totalGarcons = (clone $baseQuery)->where('genre', 'Homme')->count();
        $annee = $request->filled('annee') ? $request->annee : null;

        $pdf = \PDF::loadView('archives.beneficiaires.liste-pdf', compact(
            'beneficiaires',
            'total',
            'totalFilles',
            'totalGarcons',
            'annee'
        ));

        $filename = $annee
            ? "liste_beneficiaires_{$annee}_" . date('Y-m-d') . '.pdf'
            : 'liste_beneficiaires_' . date('Y-m-d') . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Méthode utilitaire pour récupérer les données des bénéficiaires
     * Utilisée par liste() et exportListePdf() pour garantir la cohérence
     */
    private function getBeneficiairesListData(Request $request, $paginated = true)
    {
        $query = Beneficiaire::with('ecole')->orderBy('id', 'asc');
        $this->applyBeneficiaireListFilters($query, $request);
        
        if ($paginated) {
            $beneficiairesPaginated = $query->paginate(15)->appends($request->query());
            return $beneficiairesPaginated->through(function ($beneficiaire) {
                return $this->mapBeneficiaireData($beneficiaire);
            });
        }

        return $query->get()->map(function ($beneficiaire) {
            return $this->mapBeneficiaireData($beneficiaire);
        });
    }

    /**
     * Mapper les données d'un bénéficiaire
     * Logique centralisée pour liste() et exportListePdf()
     */
    private function mapBeneficiaireData($beneficiaire)
    {
        $type = '-';
        $filiere = '-';
        $domaine = '-';
        
        if ($beneficiaire->type === 'Dossier individuel') {
            $type = 'Employé';
            $domaine = $beneficiaire->specialite ?? '-'; // Domaine pour les employés
            // Filière reste vide (-) pour les employés
        } elseif ($beneficiaire->type === 'Document éducatif') {
            $type = 'Étudiant';
            $filiere = $beneficiaire->filiere ?? '-'; // Filière pour les étudiants
            // Domaine reste vide (-) pour les étudiants
        }
        
        return [
            'id' => $beneficiaire->id,
            'nom_complet' => $beneficiaire->nom . ' ' . $beneficiaire->prenom,
            'type' => $type,
            'ville' => $beneficiaire->ville ?? '-',
            'filiere' => $filiere,
            'ecole' => $beneficiaire->ecole->nom ?? '-',
            'domaine' => $domaine,
            'genre' => $beneficiaire->genre ?? '-',
        ];
    }

    /**
     * Affiche la liste des bénéficiaires refusés
     */
    public function refused(Request $request)
    {
        // Forcer la reconnexion à la base de données
        DB::purge();
        DB::reconnect();
        
        $query = Beneficiaire::with('ecole')
            ->where('status', 'Refuser');

        // Filtrage par type
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        // Filtrage par école
        if ($request->filled('ecole')) {
            $query->where('ecole_id', $request->ecole);
        }

        // Filtrage par année (référence)
        if ($request->filled('annee')) {
            $this->applyReferenceYearFilter($query, (string) $request->annee);
        }

        // Recherche
        if ($request->filled('search')) {
            $search = trim($request->search);
            $this->applySearchFilters($query, $search);
        }

        $beneficiaires = $query->orderBy('id', 'desc')->get()->groupBy('type');

        // Récupérer les écoles et centres pour le filtre
        $ecoles = $this->getEcolesForFilter();

        return view('archives.beneficiaires.refused', [
            'beneficiaires' => $beneficiaires,
            'types' => array_values($this->types),
            'ecoles' => $ecoles,
            'annees' => $this->getAvailableAnnees($request, true),
        ]);
    }
}