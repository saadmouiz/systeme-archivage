<?php

namespace App\Http\Controllers\Archive;

use App\Http\Controllers\Controller;
use App\Models\ArchiveFinancier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FinancierController extends Controller
{
    public function index(Request $request)
    {
        $query = ArchiveFinancier::query();

        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        if ($request->has('annee') && $request->annee) {
            $query->where('annee_financiere', $request->annee);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('titre', 'like', "%{$search}%")
                  ->orWhere('reference', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $documents = $query->latest()->get()->groupBy('type');
        
        return view('archives.financiers.index', [
            'documents' => $documents,
            'types' => [
                'Budget prévisionnel',
                'Bilan financier annuel',
                'Rapport commissaire',
                'Relevé bancaire',
                'Facture/Justificatif',
                'Registre dons/subventions'
            ],
            'statuts' => [
                'payé' => 'Payé',
                'en attente' => 'En attente',
                'validé' => 'Validé',
                'rejeté' => 'Rejeté'
            ],
            'annees' => range(2018, now()->year + 1)
        ]);
    }

    public function create()
    {
        return view('archives.financiers.create', [
            'types' => [
                'Budget prévisionnel',
                'Bilan financier annuel',
                'Rapport commissaire',
                'Relevé bancaire',
                'Facture/Justificatif',
                'Registre dons/subventions'
            ],
            'statuts' => [
                'payé' => 'Payé',
                'en attente' => 'En attente',
                'validé' => 'Validé',
                'rejeté' => 'Rejeté'
            ],
            'annees' => range(2020, now()->year + 1)
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'type' => 'required|string',
            'reference' => 'nullable|string|max:50',
            'montant' => 'nullable|numeric|min:0',
            'date_document' => 'required|date',
            'description' => 'nullable|string',
            'fichier' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'annee_financiere' => 'required|integer|min:2020|max:' . (now()->year + 1),
            'statut' => 'required|string'
        ]);

        if ($request->hasFile('fichier')) {
            $file = $request->file('fichier');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $validated['fichier'] = $file->storeAs('financiers', $fileName, 'public');
        }

        ArchiveFinancier::create($validated);

        return redirect()->route('archives.financiers.index')
            ->with('success', 'Document financier ajouté avec succès.');
    }

    public function show(ArchiveFinancier $financier)
    {
        return view('archives.financiers.show', compact('financier'));
    }

    public function edit(ArchiveFinancier $financier)
    {
        return view('archives.financiers.edit', [
            'financier' => $financier,
            'types' => [
                'Budget prévisionnel',
                'Bilan financier annuel',
                'Rapport commissaire',
                'Relevé bancaire',
                'Facture/Justificatif',
                'Registre dons/subventions'
            ],
            'statuts' => [
                'payé' => 'Payé',
                'en attente' => 'En attente',
                'validé' => 'Validé',
                'rejeté' => 'Rejeté'
            ],
            'annees' => range(2020, now()->year + 1)
        ]);
    }

    public function update(Request $request, ArchiveFinancier $financier)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'type' => 'required|string',
            'reference' => 'nullable|string|max:50',
            'montant' => 'nullable|numeric|min:0',
            'date_document' => 'required|date',
            'description' => 'nullable|string',
            'fichier' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
            'annee_financiere' => 'required|integer|min:2020|max:' . (now()->year + 1),
            'statut' => 'required|string'
        ]);

        if ($request->hasFile('fichier')) {
            if ($financier->fichier) {
                Storage::disk('public')->delete($financier->fichier);
            }
            
            $file = $request->file('fichier');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $validated['fichier'] = $file->storeAs('financiers', $fileName, 'public');
        }

        $financier->update($validated);

        return redirect()->route('archives.financiers.index')
            ->with('success', 'Document financier mis à jour avec succès.');
    }

    public function destroy(ArchiveFinancier $financier)
    {
        if ($financier->fichier) {
            Storage::disk('public')->delete($financier->fichier);
        }
        
        $financier->delete();

        return redirect()->route('archives.financiers.index')
            ->with('success', 'Document financier supprimé avec succès.');
    }

    public function download(ArchiveFinancier $financier)
    {
        // Vérifier si le fichier existe
        if (!Storage::disk('public')->exists($financier->fichier)) {                
            return back()->with('error', 'Le fichier n\'existe pas.');
        }

        // Obtenir le chemin complet du fichier
        $path = Storage::disk('public')->path($financier->fichier);     
        
        // Obtenir le nom original du fichier
        $originalName = basename($financier->fichier);

        // Renvoyer le fichier avec le bon type MIME
        return response()->download($path, $originalName);
    }

}