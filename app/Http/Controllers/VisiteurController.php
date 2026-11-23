<?php

namespace App\Http\Controllers;

use App\Models\Visiteur;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
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
        if ($request->filled('genre')) {
            $query->where('genre', $request->genre);
        }
        return $query;
    }

    public function index(Request $request)
    {
        $query = $this->applyFilters(Visiteur::query(), $request);
        $visiteurs = $query->orderByDesc('heure_arrivee')->get();
        $annees = $this->getAvailableAnnees();

        return view('visiteurs.index', compact('visiteurs', 'annees'));
    }

    public function create()
    {
        return view('visiteurs.create');
    }

    public function store(Request $request)
    {
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
        $visiteurs = $this->applyFilters(Visiteur::query(), $request)->orderBy('heure_arrivee')->get();
        $annee = $request->filled('annee') ? (string) $request->annee : 'toutes';

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Visiteurs');

        $headers = ['Nom', 'Prénom', 'CIN', 'Genre', "Date d'arrivée", "Heure d'arrivée"];
        foreach ($headers as $index => $header) {
            $sheet->setCellValueByColumnAndRow($index + 1, 1, $header);
        }

        $row = 2;
        foreach ($visiteurs as $visiteur) {
            $sheet->setCellValueByColumnAndRow(1, $row, $visiteur->nom);
            $sheet->setCellValueByColumnAndRow(2, $row, $visiteur->prenom);
            $sheet->setCellValueByColumnAndRow(3, $row, $visiteur->cin);
            $sheet->setCellValueByColumnAndRow(4, $row, $visiteur->genre);
            $sheet->setCellValueByColumnAndRow(5, $row, optional($visiteur->heure_arrivee)->format('d/m/Y'));
            $sheet->setCellValueByColumnAndRow(6, $row, optional($visiteur->heure_arrivee)->format('H:i'));
            $row++;
        }

        foreach (range(1, 6) as $col) {
            $sheet->getColumnDimensionByColumn($col)->setAutoSize(true);
        }

        $filename = "visiteurs_{$annee}_" . date('Y-m-d') . '.xlsx';

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    public function exportPdf(Request $request)
    {
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
