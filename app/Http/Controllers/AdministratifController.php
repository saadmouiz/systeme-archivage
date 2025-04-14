<?php

namespace App\Http\Controllers;

use App\Models\Administratif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\AdministratifRequest;

class AdministratifController extends Controller
{

    public function search(Request $request)
    {
        $query = $request->input('query');
        $documents = Document::where('titre', 'like', "%{$query}%")
                            ->orWhere('description', 'like', "%{$query}%")
                            ->paginate(10);
        
        return view('archives.administratifs.index', compact('documents'));
    }


    public function index()
    {
        $administratifs = Administratif::latest()->get()->groupBy('type');
        return view('archives.administratifs.index', compact('administratifs'));

    }

    public function create()
    {
        $types = [
            'Statuts association' => 'Statuts association',
            'Rapports Annuels' => 'Rapports Annuels',
            'Procès-verbaux' => 'Procès-verbaux',
            'Contrats et Accords' => 'Contrats et Accords',
            'Politiques et Règlements' => 'Politiques et Règlements',
           ' les accusés de reception' => 'les accusés de reception'
          
        ];
        return view('archives.administratifs.create', compact('types'));
    }

    public function store(AdministratifRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('fichier')) {
            $file = $request->file('fichier');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $data['fichier'] = $file->storeAs('administratifs', $fileName, 'public');
        }

        Administratif::create($data);

        return redirect()->route('archives.administratifs.index')
            ->with('success', 'Document administratif ajouté avec succès');
    }

    public function show(Administratif $administratif)
    {
        return view('archives.administratifs.show', compact('administratif'));
    }

    public function edit(Administratif $administratif)
    {
        $types = [
            'Statuts association' => 'Statuts association',
            'Rapports Annuels' => 'Rapports Annuels',
            'Procès-verbaux' => 'Procès-verbaux',
            'Contrats et Accords' => 'Contrats et Accords',
            'Politiques et Règlements' => 'Politiques et Règlements',
            ' les accusés de reception' => 'les accusés de reception'
        ];
        return view('archives.administratifs.edit', compact('administratif', 'types'));
    }

    public function update(AdministratifRequest $request, Administratif $administratif)
    {
        $data = $request->validated();

        if ($request->hasFile('fichier')) {
            // Supprimer l'ancien fichier
            if ($administratif->fichier) {
                Storage::disk('public')->delete($administratif->fichier);
            }
            
            $file = $request->file('fichier');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $data['fichier'] = $file->storeAs('administratifs', $fileName, 'public');
        }

        $administratif->update($data);

        return redirect()->route('archives.administratifs.index')
            ->with('success', 'Document administratif mis à jour avec succès');
    }

    public function destroy(Administratif $administratif)
    {
        if ($administratif->fichier) {
            Storage::disk('public')->delete($administratif->fichier);
        }
        
        $administratif->delete();

        return redirect()->route('archives.administratifs.index')
            ->with('success', 'Document administratif supprimé avec succès');
    }

    public function download(Administratif $administratif)
    {
        // Vérifier si le fichier existe
        if (!Storage::disk('public')->exists($administratif->fichier)) {                
            return back()->with('error', 'Le fichier n\'existe pas.');
        }

        // Obtenir le chemin complet du fichier
        $path = Storage::disk('public')->path($administratif->fichier);     
        
        // Obtenir le nom original du fichier
        $originalName = basename($administratif->fichier);

        // Renvoyer le fichier avec le bon type MIME
        return response()->download($path, $originalName);
    }

    /**
     * Rechercher des documents administratifs
     */
   
    /**
     * Filtrer les documents par type
     */
    public function filter($type)
    {
        $administratifs = Administratif::where('type', $type)
            ->latest()
            ->get()
            ->groupBy('type');

        return view('archives.administratifs.index', compact('administratifs'));
    }

}
