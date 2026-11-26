<?php

namespace App\Http\Controllers;

use App\Models\AnneeCloturee;
use App\Support\CdcSchemaEnsurer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AnneeClotureController extends Controller
{
    public function index()
    {
        $this->authorizeAdmin();
        CdcSchemaEnsurer::ensure();

        $clotures = AnneeCloturee::query()->orderByDesc('annee')->orderBy('module')->get();
        $currentYear = (int) date('Y');
        $annees = range($currentYear, $currentYear - 10);

        return view('archives.clotures.index', compact('clotures', 'annees'));
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'annee' => 'required|integer|min:2000|max:2100',
            'module' => 'required|in:beneficiaires,pointages,all',
            'notes' => 'nullable|string|max:1000',
        ]);

        $user = auth()->user();

        AnneeCloturee::updateOrCreate(
            ['annee' => $validated['annee'], 'module' => $validated['module']],
            [
                'closed_by' => $user->id,
                'closed_by_name' => $user->name,
                'closed_at' => now(),
                'notes' => $validated['notes'] ?? null,
            ]
        );

        return back()->with('success', "Exercice {$validated['annee']} clôturé ({$validated['module']}).");
    }

    public function destroy(AnneeCloturee $cloture)
    {
        $this->authorizeAdmin();
        $cloture->delete();

        return back()->with('success', "Clôture de l'exercice {$cloture->annee} annulée.");
    }

    private function authorizeAdmin(): void
    {
        if (!Gate::allows('access-admin1-sections')) {
            abort(403, 'Seul un administrateur peut clôturer un exercice.');
        }
    }
}
