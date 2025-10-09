@extends('layouts.sidebar')

@section('title', 'Documents RH')

@section('content')
<div class="min-h-screen">
    <div class="container mx-auto">
        <!-- Header Section -->
        <div class="mb-12">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div class="mb-6 lg:mb-0">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-[#FEE2E2] border border-red-300 rounded-2xl flex items-center justify-center mr-4 shadow-lg">
                            <svg class="w-6 h-6 text-red-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-4xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">
                                Documents RH
                            </h1>
                            <p class="text-gray-600 mt-2">Gestion centralisée de vos archives ressources humaines</p>
                        </div>
                    </div>
                </div>
                <a href="{{ route('archives.rh.create') }}" 
                   class="group relative inline-flex items-center px-8 py-4 bg-[#7F1D1D] border border-red-900 text-white font-semibold rounded-2xl shadow-2xl hover:shadow-red-900/25 transition-all duration-300 hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-r from-red-900 to-red-700 rounded-2xl blur opacity-30 group-hover:opacity-50 transition duration-300"></div>
                    <svg class="w-5 h-5 mr-3 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span class="relative z-10">Nouveau Document</span>
                </a>
            </div>
        </div>

        <!-- Filtres Section -->
        <div class="mb-12">
            <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-8 shadow-xl border border-white/20">
                <!-- Barre de recherche -->
                <div class="mb-8">
                    <form action="{{ route('archives.rh.index') }}" method="GET" class="relative">
                        <div class="flex gap-4">
                            <div class="flex-1">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                    </div>
                                    <input type="text" 
                                           name="search" 
                                           placeholder="Rechercher un document..." 
                                           class="w-full pl-12 pr-4 py-4 text-lg border-2 border-gray-200 rounded-2xl shadow-sm focus:ring-4 focus:ring-red-900/20 focus:border-red-900 transition-all duration-300 bg-white/50 backdrop-blur-sm"
                                           value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                    <input type="text" 
                                           name="employe" 
                                           placeholder="Nom de l'employé..." 
                                           class="w-full pl-12 pr-4 py-4 text-lg border-2 border-gray-200 rounded-2xl shadow-sm focus:ring-4 focus:ring-red-900/20 focus:border-red-900 transition-all duration-300 bg-white/50 backdrop-blur-sm"
                                           value="{{ request('employe') }}">
                                </div>
                            </div>
                            <button type="submit" 
                                    class="px-8 py-4 bg-[#FEE2E2] border border-red-300 text-#871C1C rounded-2xl hover:from-red-800 hover:to-red-700 shadow-lg hover:shadow-xl transition-all duration-200 font-semibold">
                                <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                Rechercher
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Filtres -->
                <div class="space-y-6">
                    <!-- Types de documents -->
                    <div>
                        <h3 class="text-sm font-semibold text-gray-700 mb-4 uppercase tracking-wider">Types de documents</h3>
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route('archives.rh.index') }}" 
                               class="px-6 py-3 text-sm font-medium rounded-2xl transition-all duration-300 {{ !request('type') ? 'bg-[#FEE2E2] border border-red-300 text-#871C1C shadow-lg scale-105' : 'bg-white/60 text-gray-700 hover:bg-white hover:shadow-md border border-gray-200' }}">
                                Tous
                            </a>
                            @foreach(['Contrat', 'Fiche de paie', 'Registre du personnel'] as $type)
                                <a href="{{ route('archives.rh.index', ['type' => $type]) }}" 
                                   class="px-6 py-3 text-sm font-medium rounded-2xl transition-all duration-300 {{ request('type') == $type ? 'bg-[#FEE2E2] border border-red-300 text-#871C1C shadow-lg scale-105' : 'bg-white/60 text-gray-700 hover:bg-white hover:shadow-md border border-gray-200' }}">
                                    {{ $type }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-8 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-400 p-6 rounded-r-2xl shadow-lg">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                            <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Documents Section -->
        <div class="space-y-12">
            @forelse($documents as $type => $docs)
                <div class="group">
                    <!-- Section Header -->
                    <div class="mb-8">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-16 h-16 bg-[#FEE2E2] border border-red-300 rounded-2xl flex items-center justify-center mr-6 shadow-xl">
                                    <svg class="w-8 h-8 text-red-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-3xl font-bold text-gray-900 mb-2">{{ $type }}</h2>
                                    <div class="flex items-center space-x-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-700">
                                            <div class="w-2 h-2 bg-red-900 rounded-full mr-2"></div>
                                            {{ count($docs) }} document(s)
                                        </span>
                                        <span class="text-gray-500 text-sm">Dernière mise à jour: {{ now()->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="hidden group-hover:block transition-all duration-300">
                                <div class="flex items-center space-x-2 text-sm text-gray-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>Gestion des documents</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Documents Grid -->
                    <div class="bg-white/60 backdrop-blur-sm rounded-3xl p-8 shadow-xl border border-white/20">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="docs-{{ $loop->index }}">
                            @php
                                $docsArray = $docs->toArray();
                                $visibleDocs = array_slice($docsArray, 0, 6);
                                $hiddenDocs = array_slice($docsArray, 6);
                            @endphp
                            
                            @foreach($visibleDocs as $doc)
                                <div class="card-hover relative bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 hover:border-red-200 hover:-translate-y-2 cursor-pointer" 
                                     onclick="window.location.href='{{ route('archives.rh.show', $doc['id']) }}'">
                                    <!-- Card Header -->
                                    <div class="flex items-start justify-between mb-6">
                                        <div class="flex-1">
                                            <h3 class="font-bold text-gray-900 text-lg leading-tight mb-2 hover:text-red-900 transition-colors duration-200">{{ $doc['titre'] }}</h3>
                                            @if(isset($doc['employe_nom']) && $doc['employe_nom'])
                                                <p class="text-sm text-gray-600 mb-2 hover:text-red-800 transition-colors duration-200">
                                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                    </svg>
                                                    {{ $doc['employe_nom'] }}
                                                </p>
                                            @endif
                                            @if(isset($doc['reference']) && $doc['reference'])
                                                <p class="text-sm text-gray-500 font-mono bg-gray-50 px-3 py-1 rounded-lg inline-block hover:bg-red-50 hover:text-red-800 transition-all duration-200">
                                                    Réf: {{ $doc['reference'] }}
                                                </p>
                                            @endif
                                        </div>
                                        <!-- Statut -->
                                        <div class="flex items-center space-x-2">
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                                {{ $doc['statut'] === 'actif' ? 'bg-gradient-to-r from-green-100 to-green-200 text-green-800 border border-green-300' : 
                                                   ($doc['statut'] === 'archivé' ? 'bg-gradient-to-r from-gray-100 to-gray-200 text-gray-800 border border-gray-300' : 
                                                   'bg-gradient-to-r from-red-100 to-red-200 text-red-700 border border-red-300') }}">
                                                {{ ucfirst($doc['statut']) }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <!-- Card Content -->
                                    <div class="space-y-4 mb-6">
                                        <div class="flex items-center p-4 bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl hover:from-red-50 hover:to-red-100 transition-all duration-200">
                                            <svg class="w-5 h-5 mr-3 text-gray-400 hover:text-red-900 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            <span class="text-sm text-gray-600 font-medium hover:text-red-800 transition-colors duration-200">
                                                {{ \Carbon\Carbon::parse($doc['date_document'])->format('d/m/Y') }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Card Actions -->
                                    <div class="flex justify-between items-center pt-6 border-t border-gray-100">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('archives.rh.show', $doc['id']) }}" 
                                               class="group/btn inline-flex items-center justify-center w-10 h-10 text-red-900 hover:text-white hover:bg-red-900 rounded-xl transition-all duration-300 hover:scale-110 shadow-sm hover:shadow-lg"
                                               title="Voir le document"
                                               onclick="event.stopPropagation()">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>
                                            @if(isset($doc['fichier']) && $doc['fichier'])
                                                <a href="{{ route('archives.rh.download', $doc['id']) }}" 
                                                   class="group/btn inline-flex items-center justify-center w-10 h-10 text-green-600 hover:text-white hover:bg-green-600 rounded-xl transition-all duration-300 hover:scale-110 shadow-sm hover:shadow-lg"
                                                   title="Télécharger"
                                                   onclick="event.stopPropagation()">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                              d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                                    </svg>
                                                </a>
                                                <a href="{{ Storage::url($doc['fichier']) }}" 
                                                   class="group/btn inline-flex items-center justify-center w-10 h-10 text-green-600 hover:text-white hover:bg-green-600 rounded-xl transition-all duration-300 hover:scale-110 shadow-sm hover:shadow-lg"
                                                   target="_blank"
                                                   title="Ouvrir le fichier"
                                                   onclick="event.stopPropagation()">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                                    </svg>
                                                </a>
                                            @endif
                                            <a href="{{ route('archives.rh.edit', $doc['id']) }}" 
                                               class="group/btn inline-flex items-center justify-center w-10 h-10 text-yellow-600 hover:text-white hover:bg-yellow-600 rounded-xl transition-all duration-300 hover:scale-110 shadow-sm hover:shadow-lg"
                                               title="Modifier"
                                               onclick="event.stopPropagation()">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                        </div>
                                        <form action="{{ route('archives.rh.destroy', $doc['id']) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce document ?');"
                                              class="inline"
                                              onclick="event.stopPropagation()">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="group/btn inline-flex items-center justify-center w-10 h-10 text-red-600 hover:text-white hover:bg-red-600 rounded-xl transition-all duration-300 hover:scale-110 shadow-sm hover:shadow-lg"
                                                    title="Supprimer">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                            
                            <!-- Documents cachés -->
                            @if(count($hiddenDocs) > 0)
                                <div class="hidden-docs hidden" id="hidden-docs-{{ $loop->index }}">
                                    @foreach($hiddenDocs as $doc)
                                        <div class="card-hover relative bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 hover:border-red-200 hover:-translate-y-2 cursor-pointer" 
                                             onclick="window.location.href='{{ route('archives.rh.show', $doc['id']) }}'">
                                            <!-- Card Header -->
                                            <div class="flex items-start justify-between mb-6">
                                                <div class="flex-1">
                                                    <h3 class="font-bold text-gray-900 text-lg leading-tight mb-2 hover:text-red-900 transition-colors duration-200">{{ $doc['titre'] }}</h3>
                                                    @if(isset($doc['employe_nom']) && $doc['employe_nom'])
                                                        <p class="text-sm text-gray-600 mb-2 hover:text-red-800 transition-colors duration-200">
                                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                            </svg>
                                                            {{ $doc['employe_nom'] }}
                                                        </p>
                                                    @endif
                                                    @if(isset($doc['reference']) && $doc['reference'])
                                                        <p class="text-sm text-gray-500 font-mono bg-gray-50 px-3 py-1 rounded-lg inline-block hover:bg-red-50 hover:text-red-800 transition-all duration-200">
                                                            Réf: {{ $doc['reference'] }}
                                                        </p>
                                                    @endif
                                                </div>
                                                <!-- Statut -->
                                                <div class="flex items-center space-x-2">
                                                    <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                                        {{ $doc['statut'] === 'actif' ? 'bg-gradient-to-r from-green-100 to-green-200 text-green-800 border border-green-300' : 
                                                           ($doc['statut'] === 'archivé' ? 'bg-gradient-to-r from-gray-100 to-gray-200 text-gray-800 border border-gray-300' : 
                                                           'bg-gradient-to-r from-red-100 to-red-200 text-red-700 border border-red-300') }}">
                                                        {{ ucfirst($doc['statut']) }}
                                                    </span>
                                                </div>
                                            </div>
                                            
                                            <!-- Card Content -->
                                            <div class="space-y-4 mb-6">
                                                <div class="flex items-center p-4 bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl hover:from-red-50 hover:to-red-100 transition-all duration-200">
                                                    <svg class="w-5 h-5 mr-3 text-gray-400 hover:text-red-900 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                    <span class="text-sm text-gray-600 font-medium hover:text-red-800 transition-colors duration-200">
                                                        {{ \Carbon\Carbon::parse($doc['date_document'])->format('d/m/Y') }}
                                                    </span>
                                                </div>
                                            </div>

                                            <!-- Card Actions -->
                                            <div class="flex justify-between items-center pt-6 border-t border-gray-100">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('archives.rh.show', $doc['id']) }}" 
                                                       class="group/btn inline-flex items-center justify-center w-10 h-10 text-red-900 hover:text-white hover:bg-red-900 rounded-xl transition-all duration-300 hover:scale-110 shadow-sm hover:shadow-lg"
                                                       title="Voir le document"
                                                       onclick="event.stopPropagation()">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                        </svg>
                                                    </a>
                                                    @if(isset($doc['fichier']) && $doc['fichier'])
                                                        <a href="{{ route('archives.rh.download', $doc['id']) }}" 
                                                           class="group/btn inline-flex items-center justify-center w-10 h-10 text-green-600 hover:text-white hover:bg-green-600 rounded-xl transition-all duration-300 hover:scale-110 shadow-sm hover:shadow-lg"
                                                           title="Télécharger"
                                                           onclick="event.stopPropagation()">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                                      d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                                            </svg>
                                                        </a>
                                                        <a href="{{ Storage::url($doc['fichier']) }}" 
                                                           class="group/btn inline-flex items-center justify-center w-10 h-10 text-green-600 hover:text-white hover:bg-green-600 rounded-xl transition-all duration-300 hover:scale-110 shadow-sm hover:shadow-lg"
                                                           target="_blank"
                                                           title="Ouvrir le fichier"
                                                           onclick="event.stopPropagation()">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                                            </svg>
                                                        </a>
                                                    @endif
                                                    <a href="{{ route('archives.rh.edit', $doc['id']) }}" 
                                                       class="group/btn inline-flex items-center justify-center w-10 h-10 text-yellow-600 hover:text-white hover:bg-yellow-600 rounded-xl transition-all duration-300 hover:scale-110 shadow-sm hover:shadow-lg"
                                                       title="Modifier"
                                                       onclick="event.stopPropagation()">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                        </svg>
                                                    </a>
                                                </div>
                                                <form action="{{ route('archives.rh.destroy', $doc['id']) }}" 
                                                      method="POST" 
                                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce document ?');"
                                                      class="inline"
                                                      onclick="event.stopPropagation()">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="group/btn inline-flex items-center justify-center w-10 h-10 text-red-600 hover:text-white hover:bg-red-600 rounded-xl transition-all duration-300 hover:scale-110 shadow-sm hover:shadow-lg"
                                                            title="Supprimer">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        
                        <!-- Bouton More/Less -->
                        @if(count($hiddenDocs) > 0)
                            <div class="text-center mt-10">
                                <button onclick="toggleDocuments({{ $loop->index }})" 
                                        id="toggle-btn-{{ $loop->index }}"
                                        class="group relative inline-flex items-center px-8 py-4 bg-[#FEE2E2] border border-red-300 text-white font-semibold rounded-2xl shadow-2xl hover:shadow-red-900/25 transition-all duration-300 hover:scale-105">
                                    <div class="absolute inset-0 bg-gradient-to-r from-red-900 to-red-700 rounded-2xl blur opacity-30 group-hover:opacity-50 transition duration-300"></div>
                                    <span id="toggle-text-{{ $loop->index }}" class="relative z-10">Voir plus ({{ count($hiddenDocs) }})</span>
                                    <svg class="w-5 h-5 ml-3 relative z-10 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" id="toggle-icon-{{ $loop->index }}">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-20">
                    <div class="mx-auto w-32 h-32 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-8 shadow-xl">
                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Aucun document trouvé</h3>
                    <p class="text-gray-600 text-lg mb-8">Commencez par ajouter votre premier document RH pour organiser vos archives.</p>
                    <a href="{{ route('archives.rh.create') }}" 
                       class="inline-flex items-center px-8 py-4 bg-[#FEE2E2] border border-red-300 text-white font-semibold rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Créer le premier document
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div>

<script>
function toggleDocuments(typeIndex) {
    const hiddenDocs = document.getElementById('hidden-docs-' + typeIndex);
    const toggleBtn = document.getElementById('toggle-btn-' + typeIndex);
    const toggleText = document.getElementById('toggle-text-' + typeIndex);
    const toggleIcon = document.getElementById('toggle-icon-' + typeIndex);
    
    if (hiddenDocs.classList.contains('hidden')) {
        // Afficher plus de documents
        hiddenDocs.classList.remove('hidden');
        toggleText.textContent = 'Voir moins';
        toggleIcon.style.transform = 'rotate(180deg)';
    } else {
        // Masquer les documents supplémentaires
        hiddenDocs.classList.add('hidden');
        toggleText.textContent = 'Voir plus';
        toggleIcon.style.transform = 'rotate(0deg)';
    }
}
</script>
@endsection


