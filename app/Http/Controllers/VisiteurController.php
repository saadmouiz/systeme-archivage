<?php

namespace App\Http\Controllers;

use App\Models\Visiteur;
use Illuminate\Http\Request;

class VisiteurController extends Controller
{
    /**
     * Affiche la liste des visiteurs.
     */
    public function index()
    {
        $visiteurs = Visiteur::all();
        return view('visiteurs.index', compact('visiteurs'));
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
}
