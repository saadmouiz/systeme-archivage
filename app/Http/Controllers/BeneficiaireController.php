<?php

namespace App\Http\Controllers;

use App\Models\AssociationPartenaire;
use App\Http\Controllers\Controller;
use App\Models\Beneficiaire;
use Illuminate\Validation\Rule;
use App\Models\ArchivePartenaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class BeneficiaireController extends Controller
{
    protected $types = [
        'Dossier individuel' => 'Dossier individuel',
        'Document éducatif' => 'Document éducatif'
    ];

    protected $niveaux = [
        '1ère année collège' => '1ère année collège',
        '2ème année collège' => '2ème année collège',
        '3ème année collège' => '3ème année collège',
        'Tronc Commun' => 'Tronc Commun',
        '1ère année bac' => '1ère année bac',
        '2ème année bac' => '2ème année bac',
        'Niveau Bac' => 'Niveau Bac',
        'Bac' => 'Bac',
        'Bac+2' => 'Bac+2',
        'Bac+3' => 'Bac+3'
    ];

    public function index(Request $request)
    {
        // Forcer la reconnexion à la base de données
        DB::purge();
        DB::reconnect();
        
        $query = Beneficiaire::with('ecole');

        // Filtrage par type
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        // Filtrage par école
        if ($request->filled('ecole')) {
            $query->where('ecole_id', $request->ecole);
        }

        // Recherche
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%")
                  ->orWhere('cin', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $beneficiaires = $query->orderBy('id', 'asc')->get()->groupBy('type');

        // Récupérer les écoles et centres pour le filtre
        $ecoles = ArchivePartenaire::whereIn('type', ['école', 'Centre', 'centre'])
            ->orderBy('nom')
            ->get();

        // Debug: Logger le nombre de bénéficiaires
        \Log::info('Bénéficiaires trouvés: ' . $beneficiaires->count());
        \Log::info('Types: ' . $beneficiaires->keys()->implode(', '));
        
        // Debug avancé
        foreach ($beneficiaires as $type => $items) {
            \Log::info("Type '$type': " . $items->count() . " éléments");
        }

        return view('archives.beneficiaires.index', [
            'beneficiaires' => $beneficiaires,
            'types' => array_values($this->types),
            'ecoles' => $ecoles
        ]);
    }

    public function create()
{
    // Récupérer les écoles ET les centres pour le dropdown
    $ecoles = ArchivePartenaire::whereIn('type', ['école', 'Centre', 'centre'])
        ->orderBy('nom')
        ->get(); // Récupère une collection d'objets

    return view('archives.beneficiaires.create', [
        'types' => $this->types,
        'niveaux' => $this->niveaux,
        'ecoles' => $ecoles
    ]);
}
    public function store(Request $request)
    {
        // FIX: Vérifier et créer la colonne ville si elle n'existe pas
        try {
            // Log de la base de données utilisée
            $dbName = \DB::connection()->getDatabaseName();
            \Log::info('Base de données utilisée: ' . $dbName);
            
            $columnExists = \DB::select("SHOW COLUMNS FROM beneficiaires WHERE Field = 'ville'");
            if (empty($columnExists)) {
                \DB::statement("ALTER TABLE beneficiaires ADD COLUMN ville VARCHAR(255) NULL AFTER prenom");
                \Log::info('Colonne ville ajoutée automatiquement à la table beneficiaires dans ' . $dbName);
            } else {
                \Log::info('Colonne ville existe déjà dans ' . $dbName);
            }
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la vérification de la colonne ville: ' . $e->getMessage());
        }
        
        $validated = $request->validate([
            'type' => 'required|string',
            'reference' => 'nullable|string|max:255',
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'ville' => 'required|string|max:255',
            'cin' => 'nullable|string',
            'age' => 'nullable|integer|min:1|max:120',
            'genre' => [
                'nullable',
                Rule::requiredIf(fn() => $request->type === 'Document éducatif'),
                'in:Homme,Femme'
            ],
            'status' => [
                'nullable',
                Rule::requiredIf(fn() => $request->type === 'Document éducatif'),
                'in:Accepter,Refuser'
            ],
            'ass_eps' => [
                'nullable',
                Rule::requiredIf(fn() => $request->type === 'Document éducatif'),
                'in:Association,Eps'
            ],
            'niveau' => [
                'nullable',
                Rule::requiredIf(fn() => $request->type === 'Dossier individuel'),
                'in:1ère année collège,2ème année collège,3ème année collège,Tronc Commun,1ère année bac,2ème année bac,Niveau Bac,Bac,Bac+2,Bac+3'
            ],
            'specialite' => [
                'nullable',
                Rule::requiredIf(fn() => $request->type === 'Dossier individuel'),
                'string',
                'max:255'
            ],
            'type_intervention' => [
                'nullable',
                'in:IP,AGR'
            ],
            'societe' => 'nullable|string|max:255',
            'description' => 'nullable|string',                
            'ecole_id' => [
                'nullable',
                Rule::requiredIf(fn() => $request->type === 'Document éducatif'),
                'exists:archive_partenaires,id'
            ],
            'filiere' => [
                'nullable',
                Rule::requiredIf(fn() => $request->type === 'Document éducatif'),
                'string',
                'max:255'
            ],
            'fichier' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240'
        ]);
    
        try {
            if ($request->hasFile('fichier')) {
                $file = $request->file('fichier');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $validated['fichier'] = $file->storeAs('beneficiaires', $fileName, 'public');
            }
    
            // Nettoyer les données selon le type de dossier
            if ($validated['type'] === 'Dossier individuel') {
                // Pour Dossier individuel, supprimer les champs éducatifs (garder genre)
                $validated['status'] = null;
                $validated['ass_eps'] = null;
                $validated['ecole_id'] = null;
            } elseif ($validated['type'] === 'Document éducatif') {
                // Pour Document éducatif, supprimer les champs académiques et société
                $validated['niveau'] = null;
                $validated['specialite'] = null;
                $validated['type_intervention'] = null;
                $validated['societe'] = null;
            } else {
                // Pour les autres types, supprimer tous les champs conditionnels
                $validated['genre'] = null;
                $validated['status'] = null;
                $validated['ass_eps'] = null;
                $validated['ecole_id'] = null;
                $validated['niveau'] = null;
                $validated['specialite'] = null;
                $validated['type_intervention'] = null;
                $validated['societe'] = null;
            }
    
            Beneficiaire::create($validated);
    
            return redirect()->route('archives.beneficiaires.index')
                ->with('success', 'Dossier bénéficiaire ajouté avec succès');
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la création du bénéficiaire:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $request->all()
            ]);
            return back()->withInput()->withErrors(['error' => 'Erreur lors de la création: ' . $e->getMessage()]);
        }
    }

    public function show(Beneficiaire $beneficiaire)
    {
        $beneficiaire->load('ecole');
        return view('archives.beneficiaires.show', compact('beneficiaire'));
    }

    public function edit(Beneficiaire $beneficiaire)
    {
        // Récupérer les écoles et centres pour le formulaire
        $ecoles = ArchivePartenaire::whereIn('type', ['école', 'Centre', 'centre'])
            ->orderBy('nom')
            ->pluck('nom', 'id');

        return view('archives.beneficiaires.edit', [
            'beneficiaire' => $beneficiaire,
            'types' => $this->types,
            'niveaux' => $this->niveaux,
            'ecoles' => $ecoles
        ]);
    }

    public function update(Request $request, Beneficiaire $beneficiaire)
    {
        $validated = $request->validate([
            'type' => 'required|string',
            'reference' => 'nullable|string|max:255',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'ville' => 'required|string|max:255',
            'cin' => 'nullable|string|max:20',
            'age' => 'nullable|integer|min:1|max:120',
            'genre' => [
                'nullable',
                'required_if:type,Document éducatif',
                'in:Homme,Femme'
            ],
            'status' => [
                'nullable',
                'required_if:type,Document éducatif',
                'in:Accepter,Refuser'
            ],
            'ass_eps' => [
                'nullable',
                'required_if:type,Document éducatif',
                'in:Association,Eps'
            ],
            'niveau' => [
                'nullable',
                'required_if:type,Dossier individuel',
                'in:1ère année collège,2ème année collège,3ème année collège,Tronc Commun,1ère année bac,2ème année bac,Niveau Bac,Bac,Bac+2,Bac+3'
            ],
            'specialite' => [
                'nullable',
                'required_if:type,Dossier individuel',
                'string',
                'max:255'
            ],
            'type_intervention' => [
                'nullable',
                'in:IP,AGR'
            ],
            'societe' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'ecole_id' => [
                'nullable',
                'required_if:type,Document éducatif',
                'exists:archive_partenaires,id'
            ],
            'fichier' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240'
        ]);

        if ($request->hasFile('fichier')) {
            if ($beneficiaire->fichier) {
                Storage::disk('public')->delete($beneficiaire->fichier);
            }
            
            $file = $request->file('fichier');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $validated['fichier'] = $file->storeAs('beneficiaires', $fileName, 'public');
        }

        // Nettoyer les données selon le type de dossier
        if ($validated['type'] === 'Dossier individuel') {
            // Pour Dossier individuel, supprimer les champs éducatifs (garder genre)
            $validated['status'] = null;
            $validated['ass_eps'] = null;
            $validated['ecole_id'] = null;
        } elseif ($validated['type'] === 'Document éducatif') {
            // Pour Document éducatif, supprimer les champs académiques et société
            $validated['niveau'] = null;
            $validated['specialite'] = null;
            $validated['type_intervention'] = null;
            $validated['societe'] = null;
        } else {
            // Pour les autres types, supprimer tous les champs conditionnels
            $validated['genre'] = null;
            $validated['status'] = null;
            $validated['ass_eps'] = null;
            $validated['ecole_id'] = null;
            $validated['niveau'] = null;
            $validated['specialite'] = null;
            $validated['type_intervention'] = null;
            $validated['societe'] = null;
        }

        $beneficiaire->update($validated);

        return redirect()->route('archives.beneficiaires.index')
            ->with('success', 'Dossier bénéficiaire mis à jour avec succès');
    }

    public function destroy(Beneficiaire $beneficiaire)
    {
        if ($beneficiaire->fichier) {
            Storage::disk('public')->delete($beneficiaire->fichier);
        }
        
        $beneficiaire->delete();

        return redirect()->route('archives.beneficiaires.index')
            ->with('success', 'Dossier bénéficiaire supprimé avec succès');
    }

    public function download($id)
{
    $beneficiaire = Beneficiaire::findOrFail($id);

    if ($beneficiaire->fichier) {
        // Utiliser le chemin stocké dans la base de données
        $filePath = $beneficiaire->fichier;

        // Utiliser le disque public de Laravel
        if (Storage::disk('public')->exists($filePath)) {
            return Storage::disk('public')->download(
                $filePath, 
                $this->sanitizeFileName($beneficiaire->nom . '_' . $beneficiaire->prenom . '_document', $filePath)
            );
        }
    }

    return redirect()->back()->with('error', 'Fichier non trouvé.');
}

// Méthode utilitaire pour nettoyer les noms de fichiers
private function sanitizeFileName($baseFileName, $filePath)
{
    // Supprimer les caractères spéciaux et les espaces
    $baseFileName = preg_replace('/[^a-zA-Z0-9_-]/', '', $baseFileName);
    
    // Obtenir l'extension à partir du chemin du fichier
    $extension = pathinfo($filePath, PATHINFO_EXTENSION);
    
    return $baseFileName . '.' . $extension;
}

    public function liste()
    {
        // Statistiques globales (avant pagination)
        $total = Beneficiaire::count();
        $totalFilles = Beneficiaire::where('genre', 'Femme')->count();
        $totalGarcons = Beneficiaire::where('genre', 'Homme')->count();
        
        // Utiliser la méthode utilitaire (avec pagination)
        $beneficiaires = $this->getBeneficiairesListData(true);

        return view('archives.beneficiaires.liste', compact('beneficiaires', 'total', 'totalFilles', 'totalGarcons'));
    }

    public function exportListePdf()
    {
        // Utiliser exactement la même logique que la méthode liste() (SANS pagination pour PDF)
        $beneficiaires = $this->getBeneficiairesListData(false);
        
        // Statistiques (MÊME LOGIQUE QUE liste())
        $total = Beneficiaire::count();
        $totalFilles = Beneficiaire::where('genre', 'Femme')->count();
        $totalGarcons = Beneficiaire::where('genre', 'Homme')->count();

        $pdf = \PDF::loadView('archives.beneficiaires.liste-pdf', compact('beneficiaires', 'total', 'totalFilles', 'totalGarcons'));
        
        return $pdf->download('liste_beneficiaires_' . date('Y-m-d') . '.pdf');
    }

    /**
     * Méthode utilitaire pour récupérer les données des bénéficiaires
     * Utilisée par liste() et exportListePdf() pour garantir la cohérence
     */
    private function getBeneficiairesListData($paginated = true)
    {
        $query = Beneficiaire::with('ecole')->orderBy('id', 'asc');
        
        if ($paginated) {
            $beneficiairesPaginated = $query->paginate(15);
            $beneficiaires = $beneficiairesPaginated->through(function ($beneficiaire) {
                return $this->mapBeneficiaireData($beneficiaire);
            });
            return $beneficiaires;
        } else {
            return $query->get()->map(function ($beneficiaire) {
                return $this->mapBeneficiaireData($beneficiaire);
            });
        }
    }

    /**
     * Mapper les données d'un bénéficiaire
     * Logique centralisée pour liste() et exportListePdf()
     */
    private function mapBeneficiaireData($beneficiaire)
    {
        $type = '-';
        $filiere = '-';
        $domaine = '-';
        
        if ($beneficiaire->type === 'Dossier individuel') {
            $type = 'Employé';
            $domaine = $beneficiaire->specialite ?? '-'; // Domaine pour les employés
            // Filière reste vide (-) pour les employés
        } elseif ($beneficiaire->type === 'Document éducatif') {
            $type = 'Étudiant';
            $filiere = $beneficiaire->filiere ?? '-'; // Filière pour les étudiants
            // Domaine reste vide (-) pour les étudiants
        }
        
        return [
            'id' => $beneficiaire->id,
            'nom_complet' => $beneficiaire->nom . ' ' . $beneficiaire->prenom,
            'type' => $type,
            'ville' => $beneficiaire->ville ?? '-',
            'filiere' => $filiere,
            'ecole' => $beneficiaire->ecole->nom ?? '-',
            'domaine' => $domaine,
            'genre' => $beneficiaire->genre ?? '-',
        ];
    }
}