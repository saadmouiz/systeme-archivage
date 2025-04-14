<?php

namespace App\Http\Controllers;

use App\Models\Evenement;
use App\Models\EvenementMedia;
use App\Models\Temoignage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EvenementController extends Controller
{
    public function index()
    {
        $evenements = Evenement::latest()->paginate(10);
        return view('archives.evenements.index', compact('evenements'));
    }

    public function create()
    {
        return view('archives.evenements.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'titre' => 'required|max:255',
            'description' => 'required',
            'type' => 'required|in:interne,externe',
            'categorie' => 'required|in:collecte,conference,campagne,autre',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
            'lieu' => 'required',
            'nombre_participants' => 'nullable|integer',
            'budget' => 'nullable|numeric',
            'medias.*' => 'nullable|file|max:10240' // 10MB max
        ]);

        $evenement = Evenement::create($validatedData);

        if ($request->hasFile('medias')) {
            foreach ($request->file('medias') as $media) {
                $path = $media->store('evenements', 'public');
                EvenementMedia::create([
                    'evenement_id' => $evenement->id,
                    'type_media' => $media->getClientMimeType(),
                    'chemin_fichier' => $path,
                    'titre' => $media->getClientOriginalName()
                ]);
            }
        }

        return redirect()->route('archives.evenements.index')
            ->with('success', 'Événement créé avec succès.');
    }

    public function show(Evenement $evenement)
    {
        return view('archives.evenements.show', compact('evenement'));
    }

    public function edit(Evenement $evenement)
    {
        return view('archives.evenements.edit', compact('evenement'));
    }

    public function update(Request $request, Evenement $evenement)
    {
        $validatedData = $request->validate([
            'titre' => 'required|max:255',
            'description' => 'required',
            'type' => 'required|in:interne,externe',
            'categorie' => 'required|in:collecte,conference,campagne,autre',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
            'lieu' => 'required',
            'nombre_participants' => 'nullable|integer',
            'budget' => 'nullable|numeric',
            'statut' => 'required|in:planifie,en_cours,termine,annule'
        ]);

        $evenement->update($validatedData);

        return redirect()->route('archives.evenements.index')
            ->with('success', 'Événement mis à jour avec succès.');
    }

    public function destroy(Evenement $evenement)
    {
        foreach ($evenement->medias as $media) {
            Storage::disk('public')->delete($media->chemin_fichier);
        }
        
        $evenement->delete();

        return redirect()->route('archives.evenements.index')
            ->with('success', 'Événement supprimé avec succès.');
    }

    public function addTemoignage(Request $request, Evenement $evenement)
    {
        $validatedData = $request->validate([
            'nom_temoin' => 'required|max:255',
            'contenu' => 'required'
        ]);

        $evenement->temoignages()->create($validatedData);

        return back()->with('success', 'Témoignage ajouté avec succès.');
    }
}

