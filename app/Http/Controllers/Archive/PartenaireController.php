<?php

namespace App\Http\Controllers\Archive;

use App\Http\Controllers\Controller;
use App\Models\ArchivePartenaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartenaireController extends Controller
{                          
    protected $types = [
        'Association partenaire' => 'Association partenaire',
        'Entreprise et Sponsor' => 'Entreprise et Sponsor',
        'école' => 'école',
        'Centre' => 'Centre'
    ];
                           
    protected $statuts = [
        'actif' => 'Actif',
        'inactif' => 'Inactif',
        'en attente' => 'En attente'
    ];

    public function index(Request $request)
    {
        $query = ArchivePartenaire::query();

        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        if ($request->has('statut') && $request->statut) {
            $query->where('statut_partenariat', $request->statut);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('responsable', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $partenaires = $query->latest()->get()->groupBy('type');

        return view('archives.partenaires.index', [
            'partenaires' => $partenaires,
            'types' => array_values($this->types),
            'statuts' => $this->statuts
        ]);
    }

    public function create()
    {
        return view('archives.partenaires.create', [
            'types' => $this->types,
            'statuts' => $this->statuts
        ]);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'type' => 'required|string',
            'description' => 'nullable|string',
            'date_debut_partenariat' => 'nullable|date', // Changé de date_partenariat
            'contact_principal' => 'nullable|string',
            'email' => 'nullable|email',
            'telephone' => 'nullable|string',
            'adresse' => 'nullable|string',
            'fichier' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:10240',
            'statut_partenariat' => 'required|string' // Changé de statut
        ]);
    
        if ($request->hasFile('fichier')) {
            $file = $request->file('fichier');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $validated['fichier'] = $file->storeAs('partenaires', $fileName, 'public');
        }
    
        ArchivePartenaire::create($validated);
    
        return redirect()->route('archives.partenaires.index')
            ->with('success', 'Partenaire ajouté avec succès.');
    }

    public function show(ArchivePartenaire $partenaire)
    {
        return view('archives.partenaires.show', [
            'partenaire' => $partenaire,
            'statuts' => $this->statuts
        ]);
    }

    public function edit(ArchivePartenaire $partenaire)
    {
        return view('archives.partenaires.edit', [
            'partenaire' => $partenaire,
            'types' => $this->types,
            'statuts' => $this->statuts
        ]);
    }

    

    public function update(Request $request, ArchivePartenaire $partenaire)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'type' => 'required|string',
            'email' => 'nullable|email|max:255',
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string|max:255',
            'responsable' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'date_de_convention' => 'nullable|date',
            'statut_partenariat' => 'required|string|max:50',
            'fichier' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'contributions' => 'nullable|array',
        ]);

        if ($request->hasFile('fichier')) {
            if ($partenaire->fichier) {
                Storage::disk('public')->delete($partenaire->fichier);
            }
            
            $file = $request->file('fichier');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $validated['fichier'] = $file->storeAs('partenaires', $fileName, 'public');
        }

        $partenaire->update($validated);

        return redirect()->route('archives.partenaires.index')
            ->with('success', 'Partenaire mis à jour avec succès.');
    }

    public function destroy(ArchivePartenaire $partenaire)
    {
        if ($partenaire->fichier) {
            Storage::disk('public')->delete($partenaire->fichier);
        }
        
        $partenaire->delete();

        return redirect()->route('archives.partenaires.index')
            ->with('success', 'Partenaire supprimé avec succès.');
    }

    public function download(ArchivePartenaire $partenaire)
    {
        // Vérifier si le fichier existe
        if (!Storage::disk('public')->exists($partenaire->fichier)) {                
            return back()->with('error', 'Le fichier n\'existe pas.');
        }

        // Obtenir le chemin complet du fichier
        $path = Storage::disk('public')->path($partenaire->fichier);     
        
        // Obtenir le nom original du fichier
        $originalName = basename($partenaire->fichier);

        // Renvoyer le fichier avec le bon type MIME
        return response()->download($path, $originalName);
    }

}