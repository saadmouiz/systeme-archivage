@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Pointage des employés</h1>
                <p class="mt-2 text-sm text-gray-600">
                    Gestion des heures de présence pour le mois de 
                    {{ Carbon\Carbon::createFromDate($annee, $mois, 1)->locale('fr')->monthName }} {{ $annee }}
                </p>
            </div>
            <div class="flex space-x-4">
                <form method="GET" action="{{ route('archives.pointages.index') }}" class="flex items-center space-x-2">
                    <select name="mois" class="rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}" {{ $mois == $m ? 'selected' : '' }}>
                                {{ Carbon\Carbon::createFromDate(2023, $m, 1)->locale('fr')->monthName }}
                            </option>
                        @endforeach
                    </select>
                    <select name="annee" class="rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        @foreach(range(date('Y') - 2, date('Y') + 1) as $a)
                            <option value="{{ $a }}" {{ $annee == $a ? 'selected' : '' }}>{{ $a }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                        Filtrer
                    </button>
                </form>
                <a href="{{ route('archives.pointages.create') }}?date={{ Carbon\Carbon::now()->format('Y-m-d') }}" class="inline-flex items-center text-white bg-blue-600 rounded-xl p-2">
    Pointage du jour
</a>

<a href="{{ route('archives.pointages.export', ['mois' => $mois, 'annee' => $annee]) }}" class="btn btn-primary">
    Exporter en PDF
</a>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-4 px-4 py-3 bg-green-100 border border-green-200 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-md rounded-lg overflow-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="sticky left-0 z-10 bg-gray-50 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Employé
                        </th>
                        @foreach($joursDuMois as $jour)
                            <th scope="col" class="px-2 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider {{ $jour->isWeekend() ? 'bg-gray-100' : '' }}">
                                {{ $jour->format('d') }}
                                <span class="block text-xs font-normal">{{ $jour->locale('fr')->minDayName }}</span>
                            </th>
                        @endforeach
                        <th scope="col" class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Total jours
                        </th>  
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($employees as $employee)
                        <tr>
                            <td class="sticky left-0 z-10 bg-white px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($employee->photo)
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $employee->photo) }}" alt="">
                                        </div>
                                    @endif
                                    <div class="ml-4">
                                        <a href="{{ route('archives.pointages.show', $employee) }}?mois={{ $mois }}&annee={{ $annee }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">
                                            {{ $employee->prenom }} {{ $employee->nom }}
                                        </a>
                                        <div class="text-sm text-gray-500">{{ $employee->fonction }}</div>
                                    </div>
                                </div>
                            </td>
                            @foreach($joursDuMois as $jour)
                                @php
                                    $dateStr = $jour->format('Y-m-d');
                                    $pointage = $pointages[$employee->id][$dateStr] ?? null;
                                    $statutClass = '';
                                    $statutText = '';
                                    
                                    if ($jour->isWeekend()) {
                                        $statutClass = 'bg-gray-100';
                                        $statutText = 'WE';
                                    } elseif ($pointage) {
                                        switch($pointage->statut) {
                                            case 'present':
                                                $statutClass = 'bg-green-100 text-green-800';
                                                $statutText = 'P';
                                                break;
                                            case 'absent':
                                                $statutClass = 'bg-red-100 text-red-800';
                                                $statutText = 'A';
                                                break;
                                            case 'retard':
                                                $statutClass = 'bg-yellow-100 text-yellow-800';
                                                $statutText = 'R';
                                                break;
                                            case 'conge':
                                                $statutClass = 'bg-blue-100 text-blue-800';
                                                $statutText = 'C';
                                                break;
                                            case 'maladie':
                                                $statutClass = 'bg-purple-100 text-purple-800';
                                                $statutText = 'M';
                                                break;
                                        }
                                    }
                                @endphp
                                <td class="px-2 py-4 text-center {{ $statutClass }}">
                                    <div class="text-xs font-medium">{{ $statutText }}</div>
                                    @if($pointage && $pointage->statut === 'present')
                                        <div class="text-xs font-normal">
                                            {{ Carbon\Carbon::parse($pointage->heure_arrivee)->format('H:i') }}
                                            -
                                            {{ Carbon\Carbon::parse($pointage->heure_sortie)->format('H:i') }}
                                        </div>
                                    @endif
                                </td>
                            @endforeach
                            <td class="px-4 py-4 text-center text-sm font-medium">
                                @php
                                    $totalPresent = isset($pointages[$employee->id]) 
                                        ? collect($pointages[$employee->id])->where('statut', 'present')->count() 
                                        : 0;
                                    $totalAbsent = isset($pointages[$employee->id]) 
                                        ? collect($pointages[$employee->id])->where('statut', 'absent')->count() 
                                        : 0;
                                @endphp
                                <span class="px-2 py-1 rounded-full bg-green-100 text-green-800">{{ $totalPresent }} P</span>
                                <span class="px-2 py-1 rounded-full bg-red-100 text-red-800">{{ $totalAbsent }} A</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4 bg-white shadow-md rounded-lg p-4">
            <h2 class="text-lg font-semibold mb-2">Légende</h2>
            <div class="flex flex-wrap gap-4">
                <div class="flex items-center">
                    <span class="inline-block w-6 h-6 rounded-full bg-green-100 text-green-800 text-xs font-medium flex items-center justify-center mr-2">P</span>
                    <span class="text-sm">Présent</span>
                </div>
                <div class="flex items-center">
                    <span class="inline-block w-6 h-6 rounded-full bg-red-100 text-red-800 text-xs font-medium flex items-center justify-center mr-2">A</span>
                    <span class="text-sm">Absent</span>
                </div>
                <div class="flex items-center">
                    <span class="inline-block w-6 h-6 rounded-full bg-yellow-100 text-yellow-800 text-xs font-medium flex items-center justify-center mr-2">R</span>
                    <span class="text-sm">Retard</span>
                </div>
                <div class="flex items-center">
                    <span class="inline-block w-6 h-6 rounded-full bg-blue-100 text-blue-800 text-xs font-medium flex items-center justify-center mr-2">C</span>
                    <span class="text-sm">Congé</span>
                </div>
                <div class="flex items-center">
                    <span class="inline-block w-6 h-6 rounded-full bg-purple-100 text-purple-800 text-xs font-medium flex items-center justify-center mr-2">M</span>
                    <span class="text-sm">Maladie</span>
                </div>
                <div class="flex items-center">
                    <span class="inline-block w-6 h-6 rounded-full bg-gray-100 text-gray-800 text-xs font-medium flex items-center justify-center mr-2">WE</span>
                    <span class="text-sm">Weekend</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection