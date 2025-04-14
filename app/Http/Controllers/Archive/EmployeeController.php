<?php

namespace App\Http\Controllers\Archive;

use App\Http\Controllers\Controller;
use App\Models\Archive\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        return view('archives.employees.index', compact('employees'));
    }

    public function create()
    {
        return view('archives.employees.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'photo' => 'nullable|image|max:2048',
            'fonction' => 'required|string|max:255',
            'type_contrat' => 'required|in:CDI,CDD,Stage,Autre',
            'actif' => 'required|boolean',
            'date_embauche' => 'nullable|date',
            'date_fin_contrat' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('employees', 'public');
            $validated['photo'] = $path;
        }

        Employee::create($validated);

        return redirect()->route('archives.employees.index')
            ->with('success', 'Employé ajouté avec succès.');
    }

    public function show(Employee $employee)
    {
        return view('archives.employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        return view('archives.employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'photo' => 'nullable|image|max:2048',
            'fonction' => 'required|string|max:255',
            'type_contrat' => 'required|in:CDI,CDD,Stage,Autre',
            'actif' => 'required|boolean',
            'date_embauche' => 'nullable|date',
            'date_fin_contrat' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne photo si elle existe
            if ($employee->photo) {
                Storage::disk('public')->delete($employee->photo);
            }
            
            $path = $request->file('photo')->store('employees', 'public');
            $validated['photo'] = $path;
        }

        $employee->update($validated);

        return redirect()->route('archives.employees.index')
            ->with('success', 'Informations de l\'employé mises à jour avec succès.');
    }

    public function destroy(Employee $employee)
    {
        // Supprimer la photo si elle existe
        if ($employee->photo) {
            Storage::disk('public')->delete($employee->photo);
        }
        
        $employee->delete();

        return redirect()->route('archives.employees.index')
            ->with('success', 'Employé supprimé avec succès.');
    }
}
