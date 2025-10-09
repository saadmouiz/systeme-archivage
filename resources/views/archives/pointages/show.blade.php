@extends('layouts.sidebar')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100">
    <!-- Header Section -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div class="mb-4 lg:mb-0">
                    <div class="flex items-center mb-2">
                        <div class="w-10 h-10 bg-gradient-to-r from-red-900 to-indigo-600 rounded-xl flex items-center justify-center mr-3 shadow-lg">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Analytics de Pointage</h1>
                            <p class="text-gray-600 mt-1">Tableau de bord intelligent des présences</p>
                        </div>
                    </div>
                    <div class="mt-3">
                        <h2 class="text-xl font-semibold text-gray-800">{{ $employee->prenom }} {{ $employee->nom }}</h2>
                        <p class="text-gray-600">{{ Carbon\Carbon::createFromDate($annee, $mois, 1)->locale('fr')->monthName }} {{ $annee }}</p>
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-3">
                    <form method="GET" action="{{ route('archives.pointages.show', $employee) }}" class="flex items-center gap-2">
                        <div class="relative">
                            <select name="mois" class="appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2 pr-8 text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-red-900 focus:border-transparent shadow-sm">
                                @foreach(range(1, 12) as $m)
                                    <option value="{{ $m }}" {{ $mois == $m ? 'selected' : '' }}>
                                        {{ Carbon\Carbon::createFromDate(2023, $m, 1)->locale('fr')->monthName }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                        <div class="relative">
                            <select name="annee" class="appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2 pr-8 text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-red-900 focus:border-transparent shadow-sm">
                                @foreach(range(date('Y') - 2, date('Y') + 1) as $a)
                                    <option value="{{ $a }}" {{ $annee == $a ? 'selected' : '' }}>{{ $a }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                        <button type="submit" class="bg-gradient-to-r from-red-900 to-indigo-600 hover:from-red-800 hover:to-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition-all duration-200 shadow-lg hover:shadow-xl">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.707A1 1 0 013 7V4z"/>
                            </svg>
                            Filtrer
                        </button>
                    </form>
                    <a href="{{ route('archives.pointages.index') }}?mois={{ $mois }}&annee={{ $annee }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-red-900 transition-all duration-200 shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Retour à la liste
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(session('success'))
            <div class="mb-6 bg-[#FEE2E2] border border-red-300 rounded-xl p-4 shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-900" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-red-900">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Employee Profile Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 mb-8 overflow-hidden">
            <div class="bg-gradient-to-r from-red-900 to-indigo-600 p-6">
                <div class="flex items-center">
                    @if($employee->photo)
                        <div class="flex-shrink-0 h-20 w-20 mr-6">
                            <img class="h-20 w-20 rounded-2xl object-cover border-4 border-white shadow-lg" 
                                 src="{{ asset('uploads/' . $employee->photo) }}" alt="{{ $employee->prenom }} {{ $employee->nom }}">
                        </div>
                    @else
                        <div class="flex-shrink-0 h-20 w-20 mr-6 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                    @endif
                    <div class="text-white">
                        <h2 class="text-2xl font-bold">{{ $employee->prenom }} {{ $employee->nom }}</h2>
                        <p class="text-red-900 text-lg">{{ $employee->fonction }}</p>
                        <p class="text-red-900">{{ $employee->email }}</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-[#FEE2E2] flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-red-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Date d'embauche</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $employee->date_embauche->format('d/m/Y') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-[#FEE2E2] flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-red-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Département</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $employee->departement ?: 'Non spécifié' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Analytics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Jours Travaillés -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Jours Travaillés</p>
                        <p class="text-3xl font-bold text-red-900">{{ $statistiques['jours_travailles'] }}</p>
                        <p class="text-sm text-gray-500">sur {{ $joursDuMois->count() - $joursDuMois->filter(fn($jour) => $jour->isWeekend())->count() }} jours ouvrables</p>
                    </div>
                    <div class="w-12 h-12 bg-[#FEE2E2] rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    @php
                        $pourcentage = $joursDuMois->count() - $joursDuMois->filter(fn($jour) => $jour->isWeekend())->count() > 0 
                            ? ($statistiques['jours_travailles'] / ($joursDuMois->count() - $joursDuMois->filter(fn($jour) => $jour->isWeekend())->count())) * 100 
                            : 0;
                    @endphp
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-red-900 h-2 rounded-full transition-all duration-500" style="width: {{ min($pourcentage, 100) }}%"></div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">{{ number_format($pourcentage, 1) }}% de présence</p>
                </div>
            </div>

            <!-- Heures de Travail -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Heures Total</p>
                        <p class="text-3xl font-bold text-red-900">{{ number_format($statistiques['total_heures'], 2) }}</p>
                        <p class="text-sm text-gray-500">heures travaillées</p>
                    </div>
                    <div class="w-12 h-12 bg-[#FEE2E2] rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    @php
                        $heuresMoyennes = $statistiques['jours_travailles'] > 0 ? $statistiques['total_heures'] / $statistiques['jours_travailles'] : 0;
                    @endphp
                    <p class="text-xs text-gray-500">{{ number_format($heuresMoyennes, 1) }}h en moyenne/jour</p>
                </div>
            </div>

            <!-- Absences -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Absences</p>
                        <p class="text-3xl font-bold text-red-600">{{ $statistiques['absences'] }}</p>
                        <p class="text-sm text-gray-500">jours d'absence</p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="grid grid-cols-2 gap-2 text-xs">
                        <div class="text-center">
                            <p class="font-semibold text-red-900">{{ $statistiques['retards'] }}</p>
                            <p class="text-gray-500">Retards</p>
                        </div>
                        <div class="text-center">
                            <p class="font-semibold text-red-900">{{ $statistiques['conges'] }}</p>
                            <p class="text-gray-500">Congés</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Performance -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Performance</p>
                        @php
                            $scorePerformance = 100 - ($statistiques['absences'] * 10) - ($statistiques['retards'] * 5);
                            $scorePerformance = max(0, min(100, $scorePerformance));
                        @endphp
                        <p class="text-3xl font-bold {{ $scorePerformance >= 80 ? 'text-red-900' : ($scorePerformance >= 60 ? 'text-red-900' : 'text-red-600') }}">
                            {{ $scorePerformance }}%
                        </p>
                        <p class="text-sm text-gray-500">score global</p>
                    </div>
                    <div class="w-12 h-12 {{ $scorePerformance >= 80 ? 'bg-[#FEE2E2] flex items-center justify-center">
                        <svg class="w-6 h-6 {{ $scorePerformance >= 80 ? 'text-red-900' : ($scorePerformance >= 60 ? 'text-red-900' : 'text-red-600') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="{{ $scorePerformance >= 80 ? 'bg-red-900' : ($scorePerformance >= 60 ? 'bg-red-900' : 'bg-red-600') }} h-2 rounded-full transition-all duration-500" style="width: {{ $scorePerformance }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Timesheet Table -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Détail des Pointages</h3>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-red-900 rounded-full"></div>
                        <span class="text-sm text-gray-600">Présent</span>
                        <div class="w-3 h-3 bg-red-500 rounded-full ml-3"></div>
                        <span class="text-sm text-gray-600">Absent</span>
                        <div class="w-3 h-3 bg-red-900 rounded-full ml-3"></div>
                        <span class="text-sm text-gray-600">Retard</span>
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Date
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Jour
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Statut
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Arrivée
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Sortie
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Durée
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Commentaire
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
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
                                } elseif ($jour->isToday()) {
                                    $rowClass = 'bg-[#FEE2E2] border-l-4 border-red-300';
                                }
                            @endphp
                            <tr class="{{ $rowClass }} hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="text-sm font-medium {{ $jour->isToday() ? 'text-red-900 font-bold' : 'text-gray-900' }}">
                                            {{ $jour->format('d/m/Y') }}
                                        </div>
                                        @if($jour->isToday())
                                            <span class="ml-2 inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-900">
                                                Aujourd'hui
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $jour->locale('fr')->dayName }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($jour->isWeekend())
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            <div class="w-2 h-2 bg-gray-400 rounded-full mr-2"></div>
                                            Weekend
                                        </span>
                                    @elseif($pointage)
                                        @php
                                            $statusConfig = [
                                                'present' => ['bg-red-100 text-red-900', 'bg-red-900', 'Présent'],
                                                'absent' => ['bg-red-100 text-red-800', 'bg-red-500', 'Absent'],
                                                'retard' => ['bg-red-100 text-red-900', 'bg-red-900', 'Retard'],
                                                'conge' => ['bg-red-100 text-red-900', 'bg-red-900', 'Congé'],
                                                'maladie' => ['bg-red-100 text-red-900', 'bg-red-900', 'Maladie'],
                                            ][$pointage->statut];
                                        @endphp
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $statusConfig[0] }}">
                                            <div class="w-2 h-2 {{ $statusConfig[1] }} rounded-full mr-2"></div>
                                            {{ $statusConfig[2] }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            <div class="w-2 h-2 bg-gray-400 rounded-full mr-2"></div>
                                            Non renseigné
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if($pointage && $pointage->heure_arrivee)
                                        <span class="font-mono">{{ Carbon\Carbon::parse($pointage->heure_arrivee)->format('H:i') }}</span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if($pointage && $pointage->heure_sortie)
                                        <span class="font-mono">{{ Carbon\Carbon::parse($pointage->heure_sortie)->format('H:i') }}</span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if($pointage && $pointage->heure_arrivee && $pointage->heure_sortie)
                                        @php
                                            $arrivee = Carbon\Carbon::parse($pointage->heure_arrivee);
                                            $sortie = Carbon\Carbon::parse($pointage->heure_sortie);
                                            $duree = $sortie->diffInHours($arrivee) + ($sortie->diffInMinutes($arrivee) % 60) / 60;
                                        @endphp
                                        <span class="font-mono font-medium {{ $duree >= 8 ? 'text-red-900' : ($duree >= 6 ? 'text-red-900' : 'text-red-600') }}">
                                            {{ number_format($duree, 2) }}h
                                        </span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">
                                    {{ $pointage ? $pointage->commentaire : '' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    @if(!$jour->isWeekend() && !$jour->isFuture())
                                        @if($pointage)
                                            <a href="{{ route('archives.pointages.edit', $pointage) }}" class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded-lg text-red-900 bg-red-900 hover:bg-red-800 transition-colors duration-200">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                                Modifier
                                            </a>
                                        @else
                                            <a href="{{ route('archives.pointages.create') }}?date={{ $jour->format('Y-m-d') }}&employee_id={{ $employee->id }}" class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded-lg text-red-900 bg-red-900 hover:bg-red-800 transition-colors duration-200">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                                </svg>
                                                Ajouter
                                            </a>
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
</div>
@endsection

