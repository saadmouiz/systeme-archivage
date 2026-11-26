<?php

namespace App\Http\Controllers;

use App\Models\Visiteur;
use App\Support\CdcSchemaEnsurer;
use App\Support\ExcelExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\StreamedResponse;

class VisiteurController extends Controller
{
    private function applyFilters($query, Request $request)
    {
        if ($request->filled('annee')) {
            $query->whereYear('heure_arrivee', (int) $request->annee);
        }
        if ($request->filled('mois')) {
            $query->whereMonth('heure_arrivee', (int) $request->mois);
        }
        if ($request->filled('genre') && Schema::hasColumn('visiteurs', 'genre')) {
            $query->where('genre', $request->genre);
        }
        return $query;
    }

    public function index(Request $request)
    {
        CdcSchemaEnsurer::ensure();
        $query = $this->applyFilters(Visiteur::query(), $request);
        $visiteurs = $query->orderByDesc('heure_arrivee')->get();
        $annees = $this->getAvailableAnnees();

        return view('visiteurs.index', compact('visiteurs', 'annees'));
    }

    public function create()
    {
        CdcSchemaEnsurer::ensure();
        return view('visiteurs.create');
    }

    public function store(Request $request)
    {
        CdcSchemaEnsurer::ensure();
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'genre' => 'nullable|in:Homme,Femme',
            'heure_arrivee' => 'required|date',
        ]);

        Visiteur::create($request->all());
        return redirect()->route('visiteurs.index')->with('success', 'Visiteur ajouté avec succès.');
    }

    public function show(Visiteur $visiteur)
    {
        return view('visiteurs.show', compact('visiteur'));
    }

    public function edit(Visiteur $visiteur)
    {
        return view('visiteurs.edit', compact('visiteur'));
    }

    public function update(Request $request, Visiteur $visiteur)
    {
        CdcSchemaEnsurer::ensure();
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'genre' => 'nullable|in:Homme,Femme',
            'heure_arrivee' => 'required|date',
        ]);

        $visiteur->update($request->all());
        return redirect()->route('visiteurs.index')->with('success', 'Visiteur mis à jour avec succès.');
    }

    public function destroy(Visiteur $visiteur)
    {
        $visiteur->delete();
        return redirect()->route('visiteurs.index')->with('success', 'Visiteur supprimé avec succès.');
    }

    public function exportExcel(Request $request): StreamedResponse
    {
        CdcSchemaEnsurer::ensure();
        $visiteurs = $this->applyFilters(Visiteur::query(), $request)->orderBy('heure_arrivee')->get();
        $annee = $request->filled('annee') ? (string) $request->annee : 'toutes';

        $rows = $visiteurs->map(function ($visiteur) {
            return [
                $visiteur->nom,
                $visiteur->prenom,
                $visiteur->cin,
                $visiteur->genre,
                optional($visiteur->heure_arrivee)->format('d/m/Y'),
                optional($visiteur->heure_arrivee)->format('H:i'),
            ];
        })->all();

        return ExcelExport::download(
            "visiteurs_{$annee}_" . date('Y-m-d') . '.xlsx',
            'Visiteurs',
            ['Nom', 'Prénom', 'CIN', 'Genre', "Date d'arrivée", "Heure d'arrivée"],
            $rows
        );
    }

    public function exportPdf(Request $request)
    {
        CdcSchemaEnsurer::ensure();
        $visiteurs = $this->applyFilters(Visiteur::query(), $request)->orderBy('heure_arrivee')->get();
        $annee = $request->annee;
        $mois = $request->mois;
        $genre = $request->genre;

        $pdf = \PDF::loadView('visiteurs.export-pdf', compact('visiteurs', 'annee', 'mois', 'genre'));
        $suffix = $annee ?: 'toutes';
        return $pdf->download("visiteurs_{$suffix}_" . date('Y-m-d') . '.pdf');
    }

    public function printReport(Request $request)
    {
        CdcSchemaEnsurer::ensure();
        $visiteurs = $this->applyFilters(Visiteur::query(), $request)->orderBy('heure_arrivee')->get();
        $annee = $request->annee;
        $mois = $request->mois;
        $genre = $request->genre;

        return view('visiteurs.print', compact('visiteurs', 'annee', 'mois', 'genre'));
    }

    private function getAvailableAnnees(): array
    {
        return Visiteur::query()
            ->whereNotNull('heure_arrivee')
            ->selectRaw('DISTINCT YEAR(heure_arrivee) as year')
            ->orderByDesc('year')
            ->pluck('year')
            ->filter()
            ->map(fn ($year) => (int) $year)
            ->values()
            ->toArray();
    }
}
