<?php

namespace App\Http\Controllers\Archive;

use App\Http\Controllers\Controller;
use App\Models\ArchiveRh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RhController extends Controller
{
    public function index()
    {
        $documents = ArchiveRh::latest()->get()->groupBy('type');
        return view('archives.rh.index', compact('documents'));
    }

    public function create()
    {
        $types = [
            'Contrat' => 'Contrat',
            'Fiche de paie' => 'Fiche de paie',
            'Registre du personnel' => 'Registre du personnel',
            'Dossier juridique' => 'Dossier juridique',
            'Rapport d\'activité' => 'Rapport d\'activité',
        ];

        $statuts = [
            'active' => 'Actif',
            'inactive' => 'Inactif',
            'pending' => 'En attente'
        ];

        return view('archives.rh.create', compact('types', 'statuts'));
    }

    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'titre' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'date_document' => 'required|date',
            'statut' => 'required|string|max:255',
            
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Get validated data
        $data = $validator->validated();

        // Handle file upload
        if ($request->hasFile('fichier')) {
            $file = $request->file('fichier');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $data['fichier'] = $file->storeAs('rh', $fileName, 'public');
        }

        // Create the record
        ArchiveRh::create($data);

        return redirect()->route('archives.rh.index')
            ->with('success', 'Document RH ajouté avec succès.');
    }

    public function show(ArchiveRh $rh)
    {
        return view('archives.rh.show', compact('rh'));
    }

    public function edit(ArchiveRh $rh)
    {
        $types = [
            'Contrat' => 'Contrat',
            'Fiche de paie' => 'Fiche de paie',
            'Registre du personnel' => 'Registre du personnel',
            'Document de formation' => 'Document de formation',
            'Dossier juridique' => 'Dossier juridique',
            'Rapport d\'activité' => 'Rapport d\'activité',
        ];

        $statuts = [
            'active' => 'Actif',
            'inactive' => 'Inactif',
            'pending' => 'En attente'
        ];

        return view('archives.rh.edit', compact('rh', 'types', 'statuts'));
    }

    public function update(Request $request, ArchiveRh $rh)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'type' => 'required|string|max:255',
            'statut' => 'required|string|max:255',
            'description' => 'nullable|string',
            'fichier' => 'nullable|file|max:10240', // 10MB max
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Get validated data
        $data = $validator->validated();

        // Handle file upload
        if ($request->hasFile('fichier')) {
            // Delete old file if exists
            if ($rh->fichier) {
                Storage::disk('public')->delete($rh->fichier);
            }
            
            $file = $request->file('fichier');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $data['fichier'] = $file->storeAs('rh', $fileName, 'public');
        }

        // Update the record
        $rh->update($data);

        return redirect()->route('archives.rh.index')
            ->with('success', 'Document RH mis à jour avec succès.');
    }

    public function destroy(ArchiveRh $rh)
    {
        if ($rh->fichier) {
            Storage::disk('public')->delete($rh->fichier);
        }
        
        $rh->delete();

        return redirect()->route('archives.rh.index')
            ->with('success', 'Document RH supprimé avec succès.');
    }

    public function download(ArchiveRh $rh)
    {
        // Vérifier si le fichier existe
        if (!Storage::disk('public')->exists($rh->fichier)) {                
            return back()->with('error', 'Le fichier n\'existe pas.');
        }

        // Obtenir le chemin complet du fichier
        $path = Storage::disk('public')->path($rh->fichier);     
        
        // Obtenir le nom original du fichier
        $originalName = basename($rh->fichier);

        // Renvoyer le fichier avec le bon type MIME
        return response()->download($path, $originalName);
    } 

    /**
 * Exporte les données de pointage au format PDF.
 */
public function exportPdf(Request $request)
{
    try {
        // Récupérer le mois et l'année (par défaut le mois courant)
        $mois = $request->mois ?? Carbon::now()->month;
        $annee = $request->annee ?? Carbon::now()->year;

        // Définir les dates de début et de fin du mois
        $debut = Carbon::createFromDate($annee, $mois, 1)->startOfMonth();
        $fin = Carbon::createFromDate($annee, $mois, 1)->endOfMonth();

        // Récupérer tous les pointages pour ce mois
        $pointages = Pointage::whereBetween('date', [$debut, $fin])
            ->with('employee') // Charger la relation employee
            ->orderBy('date')
            ->get();

        // Générer le PDF
        $pdf = \PDF::loadView('archives.pointages.pdf_export', [
            'pointages' => $pointages,
            'mois' => $mois,
            'annee' => $annee
        ]);

        // Télécharger le PDF
        return $pdf->download("pointages_{$annee}_{$mois}.pdf");
    } catch (\Exception $e) {
        \Log::error('Erreur export PDF: ' . $e->getMessage());
        return back()->with('error', 'Erreur lors de l\'export PDF : ' . $e->getMessage());
    }
}
}