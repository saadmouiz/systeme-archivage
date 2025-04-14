<?php

namespace App\Http\Controllers;

use App\Models\ArchiveProjet;
use App\Models\Partenaire;
use App\Models\Beneficiaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ArchiveProjetController extends Controller
{
    public function index(Request $request)
    {
        $query = ArchiveProjet::with(['fichiers', 'partenaires', 'beneficiaires'])
            ->orderBy('created_at', 'desc');

        // Filtres optionnels
        if ($request->has('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->has('type_projet')) {
            $query->where('type_projet', $request->type_projet);
        }

        $archives = $query->paginate(10);
        
        return view('archives.projets.index', compact('archives'));
    }

    public function create()
    {
        $partenaires = Partenaire::all();
        $beneficiaires = Beneficiaire::all();
        
        return view('archives.projets.create', compact('partenaires', 'beneficiaires'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'titre' => 'required|string|max:255',
            'reference' => 'required|unique:archives_projets,reference',
            'description' => 'nullable|string',
            'date_debut' => 'required|date',
            'date_fin_prevue' => 'nullable|date|after:date_debut',
            'statut' => 'required|in:planning,en_cours,termine,suspendu',
            'type_projet' => 'required|string|max:100',
            'budget_total' => 'nullable|numeric|min:0',
            'responsable' => 'nullable|string|max:100',
            'localisation' => 'nullable|string|max:255',
            'objectifs' => 'nullable|string',
            'commentaires' => 'nullable|string',
            'partenaires' => 'nullable|array',
            'beneficiaires' => 'nullable|array',
            'fichiers.*' => 'nullable|file|max:10240' // 10MB max par fichier
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            // Créer l'archive de projet
            $archive = ArchiveProjet::create($validator->validated());

            // Attacher les partenaires
            if ($request->has('partenaires')) {
                $archive->partenaires()->sync($request->partenaires);
            }

            // Attacher les bénéficiaires
            if ($request->has('beneficiaires')) {
                $archive->beneficiaires()->sync($request->beneficiaires);
            }

            // Gestion des fichiers
            if ($request->hasFile('fichiers')) {
                foreach ($request->file('fichiers') as $fichier) {
                    $path = $fichier->store('archives/projets', 'public');
                    $archive->fichiers()->create([
                        'nom_fichier' => $fichier->getClientOriginalName(),
                        'chemin' => $path,
                        'type' => $fichier->getClientMimeType()
                    ]);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Erreur lors de la création de l\'archive: ' . $e->getMessage())
                ->withInput();
        }

        return redirect()->route('archives.projets.show', $archive)
            ->with('success', 'Archive de projet créée avec succès');
    }

    public function show(ArchiveProjet $archive)
    {
        $archive->load([
            'fichiers', 
            'partenaires', 
            'beneficiaires', 
            'taches' => function($query) {
                $query->orderBy('date_echeance');
            }
        ]);
        
        return view('archives.projets.show', compact('archive'));
    }

    public function edit(ArchiveProjet $archive)
    {
        $partenaires = Partenaire::all();
        $beneficiaires = Beneficiaire::all();
        
        $archive->load('partenaires', 'beneficiaires');
        
        return view('archives.projets.edit', compact('archive', 'partenaires', 'beneficiaires'));
    }

    public function update(Request $request, ArchiveProjet $archive)
    {
        $validator = Validator::make($request->all(), [
            'titre' => 'sometimes|required|string|max:255',
            'reference' => 'sometimes|required|unique:archives_projets,reference,' . $archive->id,
            'description' => 'nullable|string',
            'date_debut' => 'sometimes|required|date',
            'date_fin_prevue' => 'nullable|date|after:date_debut',
            'statut' => 'sometimes|required|in:planning,en_cours,termine,suspendu',
            'type_projet' => 'sometimes|required|string|max:100',
            'budget_total' => 'nullable|numeric|min:0',
            'responsable' => 'nullable|string|max:100',
            'localisation' => 'nullable|string|max:255',
            'objectifs' => 'nullable|string',
            'commentaires' => 'nullable|string',
            'partenaires' => 'nullable|array',
            'beneficiaires' => 'nullable|array',
            'fichiers.*' => 'nullable|file|max:10240'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            // Mettre à jour l'archive de projet
            $archive->update($validator->validated());

            // Mettre à jour les partenaires
            if ($request->has('partenaires')) {
                $archive->partenaires()->sync($request->partenaires);
            }

            // Mettre à jour les bénéficiaires
            if ($request->has('beneficiaires')) {
                $archive->beneficiaires()->sync($request->beneficiaires);
            }

            // Gestion des fichiers
            if ($request->hasFile('fichiers')) {
                foreach ($request->file('fichiers') as $fichier) {
                    $path = $fichier->store('archives/projets', 'public');
                    $archive->fichiers()->create([
                        'nom_fichier' => $fichier->getClientOriginalName(),
                        'chemin' => $path,
                        'type' => $fichier->getClientMimeType()
                    ]);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Erreur lors de la mise à jour de l\'archive: ' . $e->getMessage())
                ->withInput();
        }

        return redirect()->route('archives.projets.show', $archive)
            ->with('success', 'Archive de projet mise à jour avec succès');
    }

    public function destroy(ArchiveProjet $archive)
    {
        // Suppression avec gestion des relations
        DB::beginTransaction();
        try {
            // Détacher les partenaires et bénéficiaires
            $archive->partenaires()->detach();
            $archive->beneficiaires()->detach();

            // Supprimer les fichiers associés
            $archive->fichiers()->delete();

            // Supprimer l'archive
            $archive->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Erreur lors de la suppression de l\'archive: ' . $e->getMessage());
        }

        return redirect()->route('archives.projets.index')
            ->with('success', 'Archive de projet supprimée avec succès');
    }
}