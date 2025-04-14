@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Pointage du {{ $date->format('d/m/Y') }}</h1>
                <p class="mt-2 text-sm text-gray-600">
                    Enregistrez la présence des employés pour cette journée
                </p>
            </div>
            <div>
                <a href="{{ route('archives.pointages.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-400 focus:ring ring-gray-200 disabled:opacity-25 transition ease-in-out duration-150">
                    Retour à la liste
                </a>
            </div>
        </div>

        @if($errors->any())
            <div class="mb-4 px-4 py-3 bg-red-100 border border-red-200 text-red-700 rounded">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <form method="POST" action="{{ route('archives.pointages.store') }}">
                @csrf
                <input type="hidden" name="date" value="{{ $date->format('Y-m-d') }}">
                
                <div class="p-6">
                    <div class="mb-4 flex items-center">
                        <div class="w-36 font-medium text-gray-700">Date:</div>
                        <div class="flex items-center">
                            <span class="mr-2">{{ $date->format('d/m/Y') }}</span>
                            <input type="date" name="date_alt" value="{{ $date->format('Y-m-d') }}" class="rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" onchange="window.location.href='{{ route('archives.pointages.create') }}?date=' + this.value">
                        </div>
                    </div>
                </div>
                
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Employé
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Statut
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Heure arrivée
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Heure sortie
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Commentaire
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($employees as $employee)
                            @php
                                $pointage = $pointagesExistants[$employee->id] ?? null;
                            @endphp
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if($employee->photo)
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $employee->photo) }}" alt="">
                                            </div>
                                        @endif
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $employee->prenom }} {{ $employee->nom }}</div>
                                            <div class="text-sm text-gray-500">{{ $employee->fonction }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <select name="employees[{{ $employee->id }}][statut]" class="rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full" onchange="toggleTimeFields(this, {{ $employee->id }})">
                                        <option value="present" {{ $pointage && $pointage->statut === 'present' ? 'selected' : '' }}>Présent</option>
                                        <option value="absent" {{ $pointage && $pointage->statut === 'absent' ? 'selected' : '' }}>Absent</option>
                                        <option value="retard" {{ $pointage && $pointage->statut === 'retard' ? 'selected' : '' }}>Retard</option>
                                        <option value="conge" {{ $pointage && $pointage->statut === 'conge' ? 'selected' : '' }}>Congé</option>
                                        <option value="maladie" {{ $pointage && $pointage->statut === 'maladie' ? 'selected' : '' }}>Maladie</option>
                                    </select>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="time" name="employees[{{ $employee->id }}][heure_arrivee]" value="{{ $pointage ? $pointage->heure_arrivee : '08:00' }}" class="rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 time-field-{{ $employee->id }}" {{ $pointage && $pointage->statut !== 'present' ? 'disabled' : '' }}>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="time" name="employees[{{ $employee->id }}][heure_sortie]" value="{{ $pointage ? $pointage->heure_sortie : '17:00' }}" class="rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 time-field-{{ $employee->id }}" {{ $pointage && $pointage->statut !== 'present' ? 'disabled' : '' }}>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="text" name="employees[{{ $employee->id }}][commentaire]" value="{{ $pointage ? $pointage->commentaire : '' }}" class="rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <div class="px-6 py-4 bg-gray-50 text-right">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Enregistrer les pointages
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleTimeFields(selectElement, employeeId) {
        const isPresent = selectElement.value === 'present';
        const timeFields = document.querySelectorAll('.time-field-' + employeeId);
        
        timeFields.forEach(field => {
            field.disabled = !isPresent;
        });
    }
    
    // Initialiser l'état des champs au chargement
    document.addEventListener('DOMContentLoaded', function() {
        const selects = document.querySelectorAll('select[name^="employees"]');
        selects.forEach(select => {
            const employeeId = select.name.match(/employees\[(\d+)\]/)[1];
            toggleTimeFields(select, employeeId);
        });
    });
</script>
@endsection