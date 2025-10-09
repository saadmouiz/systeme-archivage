@extends('layouts.sidebar')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Projets</h1>
                <p class="mt-2 text-sm text-gray-600">Gérez vos projets et leurs documents associés</p>
            </div>
            <a href="{{ route('archives.projets.create') }}" 
               class="w-full sm:w-auto bg-[#0d9488] hover:bg-[#0d9488]/90 text-white px-4 py-2 rounded-lg inline-flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nouveau Projet
            </a>
        </div>

        <!-- Filtres -->
        <div class="bg-white rounded-lg shadow p-4 mb-6">
            <!-- Barre de recherche -->
            <div class="mb-4">
                <form action="{{ route('archives.projets.index') }}" method="GET" class="flex flex-col sm:flex-row gap-2">
                    <input type="text" 
                           name="search" 
                           placeholder="Rechercher par nom, responsable..." 
                           class="flex-1 border-gray-300 rounded-lg shadow-sm focus:ring-[#0d9488] focus:border-[#0d9488]"
                           value="{{ request('search') }}">
                    <button type="submit" 
                            class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-[#0d9488] text-white rounded-lg hover:bg-[#0d9488]/90">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Rechercher
                    </button>
                </form>
            </div>

            <!-- Filtres -->
            <div class="space-y-4">
                <!-- Type de projet -->
                <div>
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Type de projet</h3>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('archives.projets.index') }}" 
                           class="px-4 py-2 rounded-full text-sm font-medium {{ !request('type') ? 'bg-[#0d9488] text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Tous
                        </a>
                        @foreach($types as $type)
                            <a href="{{ route('archives.projets.index', ['type' => $type]) }}" 
                               class="px-4 py-2 rounded-full text-sm font-medium {{ request('type') === $type ? 'bg-[#0d9488] text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                {{ $type }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Statuts -->
                <div>
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Statut</h3>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('archives.projets.index', ['type' => request('type')]) }}" 
                           class="px-4 py-2 rounded-full text-sm font-medium {{ !request('statut') ? 'bg-[#0d9488] text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Tous les statuts
                        </a>
                        @foreach($statuts as $value => $label)
                            <a href="{{ route('archives.projets.index', ['type' => request('type'), 'statut' => $value]) }}" 
                               class="px-4 py-2 rounded-full text-sm font-medium {{ request('statut') === $value ? 'bg-[#0d9488] text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                {{ $label }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

       <!-- Messages -->
       @if(session('success'))
            <div class="mb-6 bg-[#FEE2E2] border-l-4 border-red-300 text-red-900 p-4 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <!-- Liste des projets -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($projets as $projet)
                <div class="bg-white rounded-lg border shadow-sm hover:shadow-md transition-shadow p-4">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">{{ $projet->nom }}</h3>
                            @if($projet->responsable)
                                <p class="text-sm text-gray-500">Responsable: {{ $projet->responsable }}</p>
                            @endif
                        </div>
                        <div class="flex flex-col items-end space-y-2">
                            <span class="px-3 py-1 rounded-full text-xs font-medium
                                {{ $projet->statut === 'en cours' ? 'bg-red-100 text-red-900' : 
                                   ($projet->statut === 'terminé' ? 'bg-red-100 text-red-900' : 
                                   ($projet->statut === 'annulé' ? 'bg-red-100 text-red-800' : 
                                   'bg-red-100 text-red-900')) }}">
                                {{ $statuts[$projet->statut] }}
                            </span>
                            <span class="text-xs text-gray-500">{{ $projet->type }}</span>
                        </div>
                    </div>

                    @if($projet->date_debut || $projet->date_fin)
                        <div class="mb-4 text-sm text-gray-600">
                            @if($projet->date_debut)
                                <p>Début: {{ $projet->date_debut->format('d/m/Y') }}</p>
                            @endif
                            @if($projet->date_fin)
                                <p>Fin: {{ $projet->date_fin->format('d/m/Y') }}</p>
                            @endif
                        </div>
                    @endif

                    @if($projet->description)
                        <p class="text-sm text-gray-600 mb-4">{{ Str::limit($projet->description, 100) }}</p>
                    @endif

                    <div class="flex justify-between items-center">
                        <div class="flex space-x-2">
                            <a href="{{ route('archives.projets.show', $projet) }}" 
                               class="text-[#0d9488] hover:text-[#0d9488]/80"
                               title="Voir les détails">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                            <a href="{{ route('archives.projets.edit', $projet) }}" 
                               class="text-[#0d9488] hover:text-[#0d9488]/80"
                               title="Modifier">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            @if($projet->fichier)
                                <a href="{{ route('archives.projets.download', $projet) }}" 
                                   class="text-[#0d9488] hover:text-[#0d9488]/80"
                                   title="Télécharger">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                    </svg>
                                </a>
                            @endif
                        </div>
                        <form action="{{ route('archives.projets.destroy', $projet) }}" 
                              method="POST" 
                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?');"
                              class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="text-red-600 hover:text-red-800"
                                    title="Supprimer">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-3 bg-white rounded-lg shadow p-6 text-center">
                    <p class="text-gray-500">Aucun projet trouvé.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection