<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Communication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CommunicationController extends Controller
{
    public function index()
    {
        $communications = Communication::latest()
            ->get()
            ->groupBy('type');
            
        return view('archives.communications.index', compact('communications'));
    }

    public function create()
    {
        $types = [
            'Médias et Publications' => 'Médias et Publications',
            'Campagnes de sensibilisation' => 'Campagnes de sensibilisation',
            'Rapports d\'activités' => 'Rapports d\'activités'
        ];
        
        $formats = [
            'video' => 'Vidéo',
            'image' => 'Image',
            'article' => 'Article',
            'pdf' => 'Document PDF'
        ];
        
        return view('archives.communications.create', compact('types', 'formats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string',
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_publication' => 'required|date',
            'fichier' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png,mp4,mov',
            'format_type' => 'required|string',
            'metadata' => 'nullable|array'
        ]);

        if ($request->hasFile('fichier')) {
            $file = $request->file('fichier');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $validated['fichier'] = $file->storeAs('communications', $fileName, 'public');
        }

        Communication::create($validated);

        return redirect()->route('archives.communications.index')
            ->with('success', 'Document de communication ajouté avec succès');
    }

    public function show(Communication $communication)
    {
        return view('archives.communications.show', compact('communication'));
    }

    public function edit(Communication $communication)
    {
        $types = [
            'Médias et Publications' => 'Médias et Publications',
            'Campagnes de sensibilisation' => 'Campagnes de sensibilisation',
            'Rapports d\'activités' => 'Rapports d\'activités'
        ];
        
        $formats = [
            'video' => 'Vidéo',
            'image' => 'Image',
            'article' => 'Article',
            'pdf' => 'Document PDF'
        ];
        
        return view('archives.communications.edit', compact('communication', 'types', 'formats'));
    }

    public function update(Request $request, Communication $communication)
    {
        $validated = $request->validate([
            'type' => 'required|string',
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_publication' => 'required|date',
            'fichier' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,mp4,mov|max:20480',
            'format_type' => 'required|string',
            'metadata' => 'nullable|array'
        ]);

        if ($request->hasFile('fichier')) {
            if ($communication->fichier) {
                Storage::disk('public')->delete($communication->fichier);
            }
            
            $file = $request->file('fichier');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $validated['fichier'] = $file->storeAs('communications', $fileName, 'public');
        }

        $communication->update($validated);

        return redirect()->route('archives.communications.index')
            ->with('success', 'Document de communication mis à jour avec succès');
    }

    public function destroy(Communication $communication)
    {
        if ($communication->fichier) {
            Storage::disk('public')->delete($communication->fichier);
        }
        
        $communication->delete();

        return redirect()->route('archives.communications.index')
            ->with('success', 'Document de communication supprimé avec succès');
    }

    public function download(Communication $communication)
    {
        return Storage::disk('public')->download($communication->fichier);
    }
}