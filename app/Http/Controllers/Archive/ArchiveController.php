<?php

namespace App\Http\Controllers\Archive;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Archive\Archive;  
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ArchiveController extends Controller            
{
    /**
     * Affiche la page d'index des archives
     */
    public function index()
    {
        $user = Auth::user();
        $accessibleCategories = [];
        
       
$accessibleCategories = [];

if (auth()->user()->hasRole('admin1') ){
    $accessibleCategories = array_merge($accessibleCategories, ['administratifs', 'employes' , 'financiers', 'rh']);
}

if (auth()->user()->hasRole('admin3') ) {
    $accessibleCategories = array_merge($accessibleCategories, ['pointages', 'beneficiaires', 'visiteurs']);
}

if (auth()->user()->hasRole('admin2') ) {
    $accessibleCategories = array_merge($accessibleCategories, ['communication', 'evenements', 'beneficiaires']);
}

if (auth()->user()->hasRole('superadmin')) {
    $accessibleCategories = array_merge($accessibleCategories, ['administratifs', 'employes' , 'financiers', 'rh', 'partenaires', 'communication', 'evenements', 'beneficiaires','pointages', 'visiteurs']);
}
        
        // Récupérer les archives pour les catégories accessibles
        // Si l'utilisateur n'a pas de rôle spécifique, il verra la page mais sans archives
        $archives = !empty($accessibleCategories) 
            ? Archive::whereIn('category', $accessibleCategories)->orderBy('created_at', 'desc')->get()
            : collect(); // Collection vide si aucune catégorie accessible
            
        return view('archives.index', [
            'archives' => $archives,
            'accessibleCategories' => $accessibleCategories
        ]);
    }
    
    /**
     * Stocke une nouvelle archive
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'sub_category' => 'nullable|string',
            'files.*' => 'nullable|file|max:10240', // Max 10MB par fichier
        ]);
        
        // Vérifier que l'utilisateur a accès à cette catégorie
        $category = $validated['category'];
        if (!Gate::allows('access-' . $category)) {
            abort(403, 'Vous n\'avez pas l\'autorisation de créer une archive dans cette catégorie.');
        }
        
        $archive = new Archive();
        $archive->title = $validated['title'];
        $archive->description = $validated['description'] ?? null;
        $archive->category = $category;
        $archive->sub_category = $validated['sub_category'] ?? null;
        
        // Traitement des fichiers
        if ($request->hasFile('files')) {
            $filesPaths = [];
            foreach ($request->file('files') as $file) {
                $path = $file->store('archives/' . $category, 'public');
                $filesPaths[] = $path;
            }
            $archive->files = $filesPaths;
        }
        
        $archive->save();
        
        return redirect()->back()->with('success', 'Archive créée avec succès');
    }
}