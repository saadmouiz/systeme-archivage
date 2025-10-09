@extends('layouts.sidebar')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- En-tête avec titre et boutons d'action -->
            <div class="p-6">
                <div class="flex justify-between items-start mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">{{ $administratif->titre }}</h1>
                    <div class="flex space-x-2">
                        <a href="{{ route('archives.administratifs.edit', $administratif) }}" 
                           class="inline-flex items-center px-4 py-2 bg-red-900 text-white rounded-md hover:bg-red-900">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Modifier
                        </a>
                        <form action="{{ route('archives.administratifs.destroy', $administratif) }}" 
                              method="POST" 
                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce document ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Informations du document -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Informations générales</h3>
                        <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                            <p><span class="font-medium">Type:</span> {{ $administratif->type }}</p>
                            <p><span class="font-medium">Créé le:</span> {{ $administratif->created_at->format('d/m/Y H:i') }}</p>
                            <p><span class="font-medium">Dernière modification:</span> {{ $administratif->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Document</h3>
                        <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                            <p class="break-all"><span class="font-medium">Nom du fichier:</span> {{ basename($administratif->fichier) }}</p>
                            <div class="flex space-x-2 mt-3">
                                
                                <a href="{{ route('archives.administratifs.download', $administratif) }}" 
                                   class="inline-flex items-center px-3 py-2 text-sm text-red-900 bg-red-900 rounded-md hover:bg-red-900">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                    </svg>
                                    Télécharger
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                @if($administratif->description)
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Description</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-700 whitespace-pre-line">{{ $administratif->description }}</p>
                        </div>
                    </div>
                @endif

                <!-- Bouton retour -->
                <div class="mt-6 flex justify-end">
                    <a href="{{ route('archives.administratifs.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Retour à la liste
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection