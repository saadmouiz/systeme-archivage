<?php

namespace App\Http\Controllers;

use App\Models\Visiteur;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class VisiteurController extends Controller
{
    /**
     * Affiche la liste des visiteurs.
     */
    public function index(Request $request)
    {
        $query = Visiteur::query();

        if ($request->filled('annee')) {
            $query->whereYear('heure_arrivee', (int) $request->annee);
        }

        $visiteurs = $query->orderByDesc('heure_arrivee')->get();
        $annees = $this->getAvailableAnnees();

        return view('visiteurs.index', compact('visiteurs', 'annees'));
    }

    /**
     * Affiche le formulaire de création d'un nouveau visiteur.
     */
    public function create()
    {
        return view('visiteurs.create');
    }

    /**
     * Enregistre un nouveau visiteur.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'heure_arrivee' => 'required|date',
        ]);

        Visiteur::create($request->all());
        return redirect()->route('visiteurs.index')->with('success', 'Visiteur ajouté avec succès.');
    }

    /**
     * Affiche les détails d'un visiteur.
     */
    public function show(Visiteur $visiteur)
    {
        return view('visiteurs.show', compact('visiteur'));
    }

    /**
     * Affiche le formulaire de modification d'un visiteur.
     */
    public function edit(Visiteur $visiteur)
    {
        return view('visiteurs.edit', compact('visiteur'));
    }

    /**
     * Met à jour un visiteur.
     */
    public function update(Request $request, Visiteur $visiteur)
    {
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'heure_arrivee' => 'required|date',
        ]);

        $visiteur->update($request->all());
        return redirect()->route('visiteurs.index')->with('success', 'Visiteur mis à jour avec succès.');
    }

    /**
     * Supprime un visiteur.
     */
    public function destroy(Visiteur $visiteur)
    {
        $visiteur->delete();
        return redirect()->route('visiteurs.index')->with('success', 'Visiteur supprimé avec succès.');
    }

    /**
     * Export Excel des visiteurs, filtrable par année (année de heure_arrivee).
     */
    public function exportExcel(Request $request): StreamedResponse
    {
        $query = Visiteur::query();

        if ($request->filled('annee')) {
            $query->whereYear('heure_arrivee', (int) $request->annee);
        }

        $visiteurs = $query->orderBy('heure_arrivee')->get();
        $annee = $request->filled('annee') ? (string) $request->annee : 'toutes';

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Visiteurs');

        $headers = ['Nom', 'Prénom', 'CIN', "Date d'arrivée", "Heure d'arrivée"];
        foreach ($headers as $index => $header) {
            $sheet->setCellValueByColumnAndRow($index + 1, 1, $header);
        }

        $row = 2;
        foreach ($visiteurs as $visiteur) {
            $sheet->setCellValueByColumnAndRow(1, $row, $visiteur->nom);
            $sheet->setCellValueByColumnAndRow(2, $row, $visiteur->prenom);
            $sheet->setCellValueByColumnAndRow(3, $row, $visiteur->cin);
            $sheet->setCellValueByColumnAndRow(4, $row, optional($visiteur->heure_arrivee)->format('d/m/Y'));
            $sheet->setCellValueByColumnAndRow(5, $row, optional($visiteur->heure_arrivee)->format('H:i'));
            $row++;
        }

        foreach (range(1, 5) as $col) {
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
