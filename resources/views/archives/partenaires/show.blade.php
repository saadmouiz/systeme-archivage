@extends('layouts.sidebar')

@section('content')
<div class="py-6 bg-gray-50">
    <div class="container mx-auto px-4">
        <!-- En-tête avec actions -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Détails du Partenaire</h1>
                <p class="mt-1 text-sm text-gray-600">Informations complètes sur le partenariat</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('archives.partenaires.edit', $partenaire) }}" 
                   class="inline-flex items-center px-4 py-2 bg-red-50 text-red-800 rounded-lg hover:bg-red-100">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Modifier
                </a>
                <form action="{{ route('archives.partenaires.destroy', $partenaire) }}" 
                      method="POST" 
                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce partenaire ?');"
                      class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-red-50 text-red-700 rounded-lg hover:bg-red-100">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Supprimer
                    </button>
                </form>
            </div>
        </div>

        <!-- Informations principales -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b border-gray-200">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">{{ $partenaire->nom }}</h2>
                        <div class="mt-2 flex flex-wrap gap-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                {{ $partenaire->type }}
                            </span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $partenaire->statut_partenariat === 'actif' ? 'bg-green-100 text-green-800' : 
                                   ($partenaire->statut_partenariat === 'inactif' ? 'bg-red-100 text-red-800' : 
                                   'bg-yellow-100 text-yellow-800') }}">
                                {{ ucfirst($partenaire->statut_partenariat) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
                <!-- Coordonnées -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Coordonnées</h3>
                    <div class="space-y-4">
                        @if($partenaire->responsable)
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-gray-400 mt-1 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Responsable</p>
                                    <p class="mt-1 text-gray-900">{{ $partenaire->responsable }}</p>
                                </div>
                            </div>
                        @endif

                        @if($partenaire->email)
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-gray-400 mt-1 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Email</p>
                                    <a href="mailto:{{ $partenaire->email }}" class="mt-1 text-red-900 hover:text-red-700">
                                        {{ $partenaire->email }}
                                    </a>
                                </div>
                            </div>
                        @endif

                        @if($partenaire->telephone)
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-gray-400 mt-1 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Téléphone</p>
                                    <a href="tel:{{ $partenaire->telephone }}" class="mt-1 text-red-900 hover:text-red-700">
                                        {{ $partenaire->telephone }}
                                    </a>
                                </div>
                            </div>
                        @endif

                        @if($partenaire->adresse)
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-gray-400 mt-1 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Adresse</p>
                                    <p class="mt-1 text-gray-900">{{ $partenaire->adresse }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Détails du partenariat -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Détails du partenariat</h3>
                    <div class="space-y-4">
                        @if($partenaire->description)
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-sm text-gray-700">{{ $partenaire->description }}</p>
                            </div>
                        @endif

                        @if($partenaire->date_de_convention)
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-gray-400 mt-1 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Date de convention</p>
                                    <p class="mt-1 text-gray-900">{{ $partenaire->date_de_convention->format('d/m/Y') }}</p>
                                </div>
                            </div>
                        @endif

                        <!-- Documents -->
                        @if($partenaire->fichier)
                            <div class="mt-6">
                                <h4 class="text-sm font-medium text-gray-900 mb-3">Documents associés</h4>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                            </svg>
                                            <span class="ml-2 text-sm text-gray-900">{{ basename($partenaire->fichier) }}</span>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                        <a href="{{ route('archives.partenaires.download', $partenaire->id) }}" class="btn btn-primary">
    Télécharger le fichier
</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Bouton Retour -->
            <div class="border-t border-gray-200 px-6 py-4">
                <a href="{{ route('archives.partenaires.index') }}" 
                   class="inline-flex items-center text-gray-600 hover:text-gray-900">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Retour à la liste
                </a>
            </div>
        </div>
    </div>
</div>
@endsection