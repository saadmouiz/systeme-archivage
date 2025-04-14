@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Fiche de pointage</h1>
                <p class="mt-2 text-sm text-gray-600">
                    {{ $employee->prenom }} {{ $employee->nom }} - {{ Carbon\Carbon::createFromDate($annee, $mois, 1)->locale('fr')->monthName }} {{ $annee }}
                </p>
            </div>
            <div class="flex space-x-4">
                <form method="GET" action="{{ route('archives.pointages.show', $employee) }}" class="flex items-center space-x-2">
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
                <a href="{{ route('archives.pointages.index') }}?mois={{ $mois }}&annee={{ $annee }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-400 focus:ring ring-gray-200 disabled:opacity-25 transition ease-in-out duration-150">
                    Retour à la liste
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-4 px-4 py-3 bg-green-100 border border-green-200 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div class="bg-white shadow-md rounded-lg p-6">
                <div class="flex items-center mb-4">
                    @if($employee->photo)
                        <div class="flex-shrink-0 h-20 w-20 mr-4">
                            <img class="h-20 w-20 rounded-full object-cover" src="{{ asset('storage/' . $employee->photo) }}" alt="">
                        </div>
                    @endif
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">{{ $employee->prenom }} {{ $employee->nom }}</h2>
                        <p class="text-gray-600">{{ $employee->fonction }}</p>
                        <p class="text-gray-600">{{ $employee->email }}</p>
                    </div>
                </div>
                <div class="border-t pt-4">
                    <div class="text-sm text-gray-600">Date d'embauche: {{ $employee->date_embauche->format('d/m/Y') }}</div>
                    <div class="text-sm text-gray-600">Département: {{ $employee->departement }}</div>
                </div>
            </div>
        
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Jours travaillés</h2>
                <div class="text-3xl font-bold text-blue-600 mb-2">{{ $statistiques['jours_travailles'] }}</div>
                <div class="text-sm text-gray-600">sur {{ $joursDuMois->count() - $joursDuMois->filter(fn($jour) => $jour->isWeekend())->count() }} jours ouvrables</div>
            </div>
        
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Absences</h2>
                <div class="flex space-x-4">
                    <div>
                        <div class="text-xl font-bold text-red-600">{{ $statistiques['absences'] }}</div>
                        <div class="text-xs text-gray-600">Absences</div>
                    </div>
                    <div>
                        <div class="text-xl font-bold text-yellow-600">{{ $statistiques['retards'] }}</div>
                        <div class="text-xs text-gray-600">Retards</div>
                    </div>
                    <div>
                        <div class="text-xl font-bold text-blue-600">{{ $statistiques['conges'] }}</div>
                        <div class="text-xs text-gray-600">Congés</div>
                    </div>
                    <div>
                        <div class="text-xl font-bold text-purple-600">{{ $statistiques['maladies'] }}</div>
                        <div class="text-xs text-gray-600">Maladies</div>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Heures de travail</h2>
                <div class="text-3xl font-bold text-green-600 mb-2">{{ number_format($statistiques['total_heures'], 2) }}</div>
                <div class="text-sm text-gray-600">heures totales</div>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Jour
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Statut
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Arrivée
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Sortie
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Durée
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Commentaire
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($joursDuMois as $jour)
                        @php
                            $dateStr = $jour->format('Y-m-d');
                            $pointage = $pointages[$dateStr] ?? null;
                            $rowClass = '';
                            
                            if ($jour->isWeekend()) {
                                $rowClass = 'bg-gray-50';
                            }
                        @endphp
                        <tr class="{{ $rowClass }}">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium {{ $jour->isToday() ? 'text-blue-600 font-bold' : 'text-gray-900' }}">
                                {{ $jour->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $jour->locale('fr')->dayName }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($jour->isWeekend())
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Weekend
                                    </span>
                                @elseif($pointage)
                                    @php
                                        $statusColor = [
                                            'present' => 'bg-green-100 text-green-800',
                                            'absent' => 'bg-red-100 text-red-800',
                                            'retard' => 'bg-yellow-100 text-yellow-800',
                                            'conge' => 'bg-blue-100 text-blue-800',
                                            'maladie' => 'bg-purple-100 text-purple-800',
                                        ][$pointage->statut];
                                        
                                        $statusText = [
                                            'present' => 'Présent',
                                            'absent' => 'Absent',
                                            'retard' => 'Retard',
                                            'conge' => 'Congé',
                                            'maladie' => 'Maladie',
                                        ][$pointage->statut];
                                    @endphp
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColor }}">
                                        {{ $statusText }}
                                    </span>
                                @else
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        Non renseigné
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $pointage && $pointage->heure_arrivee ? Carbon\Carbon::parse($pointage->heure_arrivee)->format('H:i') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $pointage && $pointage->heure_sortie ? Carbon\Carbon::parse($pointage->heure_sortie)->format('H:i') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($pointage && $pointage->heure_arrivee && $pointage->heure_sortie)
                                    @php
                                        $arrivee = Carbon\Carbon::parse($pointage->heure_arrivee);
                                        $sortie = Carbon\Carbon::parse($pointage->heure_sortie);
                                        $duree = $sortie->diffInHours($arrivee) + ($sortie->diffInMinutes($arrivee) % 60) / 60;
                                    @endphp
                                    {{ number_format($duree, 2) }} h
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $pointage ? $pointage->commentaire : '' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                @if(!$jour->isWeekend() && !$jour->isFuture())
                                    @if($pointage)
                                        <a href="{{ route('pointages.edit', $pointage) }}" class="text-blue-600 hover:text-blue-900">Modifier</a>
                                    @else
                                        <a href="{{ route('pointages.create') }}?date={{ $jour->format('Y-m-d') }}" class="text-blue-600 hover:text-blue-900">Ajouter</a>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection