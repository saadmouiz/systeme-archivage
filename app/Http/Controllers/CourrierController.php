<?php

namespace App\Http\Controllers;

use App\Models\CourrierArrive;
use App\Models\CourrierSortant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CourrierController extends Controller
{
    // ===== COURRIERS ARRIVANTS =====
    
    public function indexArrivants(Request $request)
    {
        $query = CourrierArrive::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('numero_arrive', 'like', "%{$search}%")
                  ->orWhere('numero_document', 'like', "%{$search}%")
                  ->orWhere('expediteur', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('date_from')) {
            $query->where('date_arrive', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('date_arrive', '<=', $request->date_to);
        }

        $courriers = $query->latest('date_arrive')->paginate(50);
        
        return view('archives.courriers.arrivants.index', compact('courriers'));
    }

    public function createArrivant()
    {
        return view('archives.courriers.arrivants.create');
    }

    public function storeArrivant(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date_arrive' => 'required|date',
            'numero_document' => 'nullable|string|max:255',
            'date_document' => 'nullable|date',
            'expediteur' => 'required|string|max:255',
            'pieces_jointes' => 'nullable|in:1',
            'renvoi' => 'nullable|in:1',
            'signature_recu' => 'nullable|in:1',
            'fichier' => 'nullable|file|max:10240',
            'description' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();
        
        // Convert checkbox values to boolean
        $data['pieces_jointes'] = isset($data['pieces_jointes']) && $data['pieces_jointes'] == '1';
        $data['renvoi'] = isset($data['renvoi']) && $data['renvoi'] == '1';
        $data['signature_recu'] = isset($data['signature_recu']) && $data['signature_recu'] == '1';

        if ($request->hasFile('fichier')) {
            $file = $request->file('fichier');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $data['fichier'] = $file->storeAs('courriers/arrivants', $fileName, 'public');
        }

        CourrierArrive::create($data);

        return redirect()->route('archives.courriers.arrivants.index')
            ->with('success', 'Courrier arrivant ajouté avec succès.');
    }

    public function showArrivant(CourrierArrive $courrier)
    {
        return view('archives.courriers.arrivants.show', compact('courrier'));
    }

    public function editArrivant(CourrierArrive $courrier)
    {
        return view('archives.courriers.arrivants.edit', compact('courrier'));
    }

    public function updateArrivant(Request $request, CourrierArrive $courrier)
    {
        $validator = Validator::make($request->all(), [
            'numero_arrive' => 'required|string|max:255|unique:courrier_arrives,numero_arrive,' . $courrier->id,
            'date_arrive' => 'required|date',
            'numero_document' => 'nullable|string|max:255',
            'date_document' => 'nullable|date',
            'expediteur' => 'required|string|max:255',
            'pieces_jointes' => 'nullable|in:1',
            'renvoi' => 'nullable|in:1',
            'signature_recu' => 'nullable|in:1',
            'fichier' => 'nullable|file|max:10240',
            'description' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();
        
        // Convert checkbox values to boolean
        $data['pieces_jointes'] = isset($data['pieces_jointes']) && $data['pieces_jointes'] == '1';
        $data['renvoi'] = isset($data['renvoi']) && $data['renvoi'] == '1';
        $data['signature_recu'] = isset($data['signature_recu']) && $data['signature_recu'] == '1';

        if ($request->hasFile('fichier')) {
            if ($courrier->fichier) {
                Storage::disk('public')->delete($courrier->fichier);
            }
            
            $file = $request->file('fichier');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $data['fichier'] = $file->storeAs('courriers/arrivants', $fileName, 'public');
        }

        $courrier->update($data);

        return redirect()->route('archives.courriers.arrivants.index')
            ->with('success', 'Courrier arrivant mis à jour avec succès.');
    }

    public function destroyArrivant(CourrierArrive $courrier)
    {
        if ($courrier->fichier) {
            Storage::disk('public')->delete($courrier->fichier);
        }
        
        $courrier->delete();

        return redirect()->route('archives.courriers.arrivants.index')
            ->with('success', 'Courrier arrivant supprimé avec succès.');
    }

    public function downloadArrivant(CourrierArrive $courrier)
    {
        if (!Storage::disk('public')->exists($courrier->fichier)) {                
            return back()->with('error', 'Le fichier n\'existe pas.');
        }

        $path = Storage::disk('public')->path($courrier->fichier);     
        $originalName = basename($courrier->fichier);

        return response()->download($path, $originalName);
    }

    // ===== COURRIERS SORTANTS =====

    public function indexSortants(Request $request)
    {
        $query = CourrierSortant::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('numero_sortant', 'like', "%{$search}%")
                  ->orWhere('destinataire', 'like', "%{$search}%")
                  ->orWhere('sujet', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('date_from')) {
            $query->where('date_sortant', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('date_sortant', '<=', $request->date_to);
        }

        $courriers = $query->latest('date_sortant')->paginate(50);
        
        return view('archives.courriers.sortants.index', compact('courriers'));
    }

    public function createSortant()
    {
        return view('archives.courriers.sortants.create');
    }

    public function storeSortant(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date_sortant' => 'required|date',
            'destinataire' => 'required|string|max:255',
            'sujet' => 'required|string',
            'fichier' => 'nullable|file|max:10240',
            'description' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();

        if ($request->hasFile('fichier')) {
            $file = $request->file('fichier');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $data['fichier'] = $file->storeAs('courriers/sortants', $fileName, 'public');
        }

        CourrierSortant::create($data);

        return redirect()->route('archives.courriers.sortants.index')
            ->with('success', 'Courrier sortant ajouté avec succès.');
    }

    public function showSortant(CourrierSortant $courrier)
    {
        return view('archives.courriers.sortants.show', compact('courrier'));
    }

    public function editSortant(CourrierSortant $courrier)
    {
        return view('archives.courriers.sortants.edit', compact('courrier'));
    }

    public function updateSortant(Request $request, CourrierSortant $courrier)
    {
        $validator = Validator::make($request->all(), [
            'numero_sortant' => 'required|string|max:255|unique:courrier_sortants,numero_sortant,' . $courrier->id,
            'date_sortant' => 'required|date',
            'destinataire' => 'required|string|max:255',
            'sujet' => 'required|string',
            'fichier' => 'nullable|file|max:10240',
            'description' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();

        if ($request->hasFile('fichier')) {
            if ($courrier->fichier) {
                Storage::disk('public')->delete($courrier->fichier);
            }
            
            $file = $request->file('fichier');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $data['fichier'] = $file->storeAs('courriers/sortants', $fileName, 'public');
        }

        $courrier->update($data);

        return redirect()->route('archives.courriers.sortants.index')
            ->with('success', 'Courrier sortant mis à jour avec succès.');
    }

    public function destroySortant(CourrierSortant $courrier)
    {
        if ($courrier->fichier) {
            Storage::disk('public')->delete($courrier->fichier);
        }
        
        $courrier->delete();

        return redirect()->route('archives.courriers.sortants.index')
            ->with('success', 'Courrier sortant supprimé avec succès.');
    }

    public function downloadSortant(CourrierSortant $courrier)
    {
        if (!Storage::disk('public')->exists($courrier->fichier)) {                
            return back()->with('error', 'Le fichier n\'existe pas.');
        }

        $path = Storage::disk('public')->path($courrier->fichier);     
        $originalName = basename($courrier->fichier);

        return response()->download($path, $originalName);
    }
}

