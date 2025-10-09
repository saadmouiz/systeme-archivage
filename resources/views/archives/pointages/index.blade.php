@extends('layouts.sidebar')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100">
    <!-- Header Section -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div class="mb-4 lg:mb-0">
                    <div class="flex items-center mb-2">
                        <div class="w-12 h-12 bg-[#FEE2E2] border border-red-300 rounded-2xl flex items-center justify-center mr-4 shadow-lg">
                            <svg class="w-6 h-6 text-red-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-4xl font-bold text-gray-900">Gestion des Pointages</h1>
                            <p class="text-gray-600 mt-1">Tableau de bord intelligent des présences</p>
                        </div>
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-3">
                    <form method="GET" action="{{ route('archives.pointages.index') }}" class="flex items-center gap-2">
                        <div class="relative">
                            <select name="mois" class="appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2 pr-8 text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-red-900 focus:border-transparent shadow-sm">
                                @foreach(range(1, 12) as $m)
                                    <option value="{{ $m }}" {{ (request('mois', date('n')) == $m) ? 'selected' : '' }}>
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
                                    <option value="{{ $a }}" {{ (request('annee', date('Y')) == $a) ? 'selected' : '' }}>{{ $a }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                        <button type="submit" class="bg-[#991B1B] border border-red-800 hover:bg-red-900 text-white px-4 py-2 rounded-lg font-medium transition-all duration-200 shadow-lg hover:shadow-xl">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.707A1 1 0 013 7V4z"/>
                            </svg>
                            Filtrer
                        </button>
                    </form>
                    <a href="{{ route('archives.pointages.create') }}" class="inline-flex items-center px-4 py-2 bg-[#991B1B] border border-red-800 hover:bg-red-900 text-white rounded-lg font-medium transition-all duration-200 shadow-lg hover:shadow-xl">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Nouveau Pointage
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

        @php
            $mois = request('mois', date('n'));
            $annee = request('annee', date('Y'));
        @endphp

        <!-- Global Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Employees -->
            <div class="bg-[#FEE2E2] rounded-2xl shadow-lg border border-red-300 p-6 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Total Employés</p>
                        <p class="text-3xl font-bold text-red-900">{{ $employees->count() }}</p>
                        <p class="text-sm text-gray-500">employés actifs</p>
                    </div>
                    <div class="w-12 h-12 bg-[#FEE2E2] rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Average Attendance -->
            <div class="bg-[#FEE2E2] rounded-2xl shadow-lg border border-red-300 p-6 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Présence Moyenne</p>
                        @php
                            $totalPresence = $employees->sum(function($emp) use ($mois, $annee) {
                                return $emp->pointages()->whereMonth('date', $mois)->whereYear('date', $annee)->where('statut', 'present')->count();
                            });
                            $totalWorkingDays = $employees->count() * (Carbon\Carbon::createFromDate($annee, $mois, 1)->daysInMonth - Carbon\Carbon::createFromDate($annee, $mois, 1)->copy()->endOfMonth()->diffInDaysFiltered(function($date) {
                                return $date->isWeekend();
                            }));
                            $avgPresence = $totalWorkingDays > 0 ? ($totalPresence / $totalWorkingDays) * 100 : 0;
                        @endphp
                        <p class="text-3xl font-bold text-red-900">{{ number_format($avgPresence, 1) }}%</p>
                        <p class="text-sm text-gray-500">taux de présence</p>
                    </div>
                    <div class="w-12 h-12 bg-[#FEE2E2] rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-red-900 h-2 rounded-full transition-all duration-500" style="width: {{ min($avgPresence, 100) }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Total Hours -->
            <div class="bg-[#FEE2E2] rounded-2xl shadow-lg border border-red-300 p-6 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Heures Total</p>
                        @php
                            $totalHours = $employees->sum(function($emp) use ($mois, $annee) {
                                return $emp->pointages()->whereMonth('date', $mois)->whereYear('date', $annee)->where('statut', 'present')->get()->sum(function($p) {
                                    if ($p->heure_arrivee && $p->heure_sortie) {
                                        $arrivee = Carbon\Carbon::parse($p->heure_arrivee);
                                        $sortie = Carbon\Carbon::parse($p->heure_sortie);
                                        return $sortie->diffInHours($arrivee) + ($sortie->diffInMinutes($arrivee) % 60) / 60;
                                    }
                                    return 0;
                                });
                            });
                        @endphp
                        <p class="text-3xl font-bold text-red-900">{{ number_format($totalHours, 0) }}</p>
                        <p class="text-sm text-gray-500">heures travaillées</p>
                    </div>
                    <div class="w-12 h-12 bg-[#FEE2E2] rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Absences -->
            <div class="bg-[#FEE2E2] rounded-2xl shadow-lg border border-red-300 p-6 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Absences</p>
                        @php
                            $totalAbsences = $employees->sum(function($emp) use ($mois, $annee) {
                                return $emp->pointages()->whereMonth('date', $mois)->whereYear('date', $annee)->where('statut', 'absent')->count();
                            });
                        @endphp
                        <p class="text-3xl font-bold text-red-600">{{ $totalAbsences }}</p>
                        <p class="text-sm text-gray-500">jours d'absence</p>
                    </div>
                    <div class="w-12 h-12 bg-[#FEE2E2] border border-red-300 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Employees List -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Liste des Employés</h3>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 bg-red-900 rounded-full"></div>
                            <span class="text-sm text-gray-600">Excellent</span>
                            <div class="w-3 h-3 bg-red-900 rounded-full ml-3"></div>
                            <span class="text-sm text-gray-600">Moyen</span>
                            <div class="w-3 h-3 bg-red-500 rounded-full ml-3"></div>
                            <span class="text-sm text-gray-600">À améliorer</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Employé
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Département
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Présence
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Heures
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Performance
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($employees as $employee)
                            @php
                                $pointages = $employee->pointages()->whereMonth('date', $mois)->whereYear('date', $annee)->get();
                                $joursTravailles = $pointages->where('statut', 'present')->count();
                                $absences = $pointages->where('statut', 'absent')->count();
                                $retards = $pointages->where('statut', 'retard')->count();
                                $totalHeures = $pointages->where('statut', 'present')->sum(function($p) {
                                    if ($p->heure_arrivee && $p->heure_sortie) {
                                        $arrivee = Carbon\Carbon::parse($p->heure_arrivee);
                                        $sortie = Carbon\Carbon::parse($p->heure_sortie);
                                        return $sortie->diffInHours($arrivee) + ($sortie->diffInMinutes($arrivee) % 60) / 60;
                                    }
                                    return 0;
                                });
                                
                                $joursOuvrables = Carbon\Carbon::createFromDate($annee, $mois, 1)->daysInMonth - 
                                    Carbon\Carbon::createFromDate($annee, $mois, 1)->copy()->endOfMonth()->diffInDaysFiltered(function($date) {
                                        return $date->isWeekend();
                                    });
                                
                                $pourcentagePresence = $joursOuvrables > 0 ? ($joursTravailles / $joursOuvrables) * 100 : 0;
                                $scorePerformance = 100 - ($absences * 10) - ($retards * 5);
                                $scorePerformance = max(0, min(100, $scorePerformance));
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if($employee->photo)
                                            <div class="flex-shrink-0 h-12 w-12 mr-4">
                                                <img class="h-12 w-12 rounded-xl object-cover border-2 border-gray-200" 
                                                     src="{{ asset('uploads/' . $employee->photo) }}" alt="{{ $employee->prenom }} {{ $employee->nom }}">
                                            </div>
                                        @else
                                            <div class="flex-shrink-0 h-12 w-12 mr-4 bg-gray-200 rounded-xl flex items-center justify-center">
                                                <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                </svg>
                                            </div>
                                        @endif
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $employee->prenom }} {{ $employee->nom }}</div>
                                            <div class="text-sm text-gray-500">{{ $employee->fonction }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $employee->departement ?: 'Non spécifié' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="text-sm font-medium text-gray-900">{{ $joursTravailles }}</div>
                                        <div class="text-sm text-gray-500 ml-1">/ {{ $joursOuvrables }}</div>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-1.5 mt-1">
                                        <div class="bg-red-900 h-1.5 rounded-full transition-all duration-500" style="width: {{ min($pourcentagePresence, 100) }}%"></div>
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">{{ number_format($pourcentagePresence, 1) }}%</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="font-mono font-medium text-gray-900">{{ number_format($totalHeures, 1) }}h</div>
                                    <div class="text-xs text-gray-500">{{ $absences }} absences</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="text-sm font-medium {{ $scorePerformance >= 80 ? 'text-red-900' : ($scorePerformance >= 60 ? 'text-red-900' : 'text-red-600') }}">
                                            {{ $scorePerformance }}%
                                        </div>
                                        <div class="ml-2 w-16 bg-gray-200 rounded-full h-1.5">
                                            <div class="{{ $scorePerformance >= 80 ? 'bg-red-900' : ($scorePerformance >= 60 ? 'bg-red-900' : 'bg-red-600') }} h-1.5 rounded-full transition-all duration-500" style="width: {{ $scorePerformance }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('archives.pointages.show', $employee) }}?mois={{ $mois }}&annee={{ $annee }}" class="inline-flex items-center px-3 py-1 border border-red-800 text-xs font-medium rounded-lg text-white bg-[#991B1B] hover:bg-red-900 transition-colors duration-200">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            Voir
                                        </a>
                                        <a href="{{ route('archives.pointages.create') }}?employee_id={{ $employee->id }}" class="inline-flex items-center px-3 py-1 border border-red-800 text-xs font-medium rounded-lg text-white bg-[#991B1B] hover:bg-red-900 transition-colors duration-200">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                            </svg>
                                            Ajouter
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-[#FEE2E2] rounded-2xl shadow-lg border border-red-300 p-6 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-[#FEE2E2] rounded-xl flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-red-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Export PDF</h3>
                        <p class="text-sm text-gray-500">Générer un rapport mensuel</p>
                    </div>
                </div>
            </div>

            <div class="bg-[#FEE2E2] rounded-2xl shadow-lg border border-red-300 p-6 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-[#FEE2E2] border border-red-300 rounded-xl flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-red-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Analytics</h3>
                        <p class="text-sm text-gray-500">Voir les tendances</p>
                    </div>
                </div>
            </div>

            <div class="bg-[#FEE2E2] rounded-2xl shadow-lg border border-red-300 p-6 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-[#FEE2E2] border border-red-300 rounded-xl flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-red-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Paramètres</h3>
                        <p class="text-sm text-gray-500">Configurer le système</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

