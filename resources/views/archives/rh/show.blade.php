@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="p-6">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">{{ $rh->titre }}</h1>
                        <div class="mt-2 flex items-center space-x-2">
                            <span class="px-3 py-1 rounded-full text-sm font-medium
                                {{ $rh->statut === 'actif' ? 'bg-green-100 text-green-800' : 
                                   ($rh->statut === 'en cours' ? 'bg-blue-100 text-blue-800' : 
                                   'bg-gray-100 text-gray-800') }}">
                                {{ ucfirst($rh->statut) }}
                            </span>
                            <span class="text-sm text-gray-500">{{ $rh->type }}</span>
                        </div>
                    </div>
                    
                    <div class="flex space-x-2">
                        <a href="{{ route('archives.rh.edit', $rh) }}" 
                           class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Modifier
                        </a>
                        <form action="{{ route('archives.rh.destroy', $rh) }}" 
                              method="POST" 
                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce document ?');"
                              class="inline">
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

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Informations générales</h3>
                        <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                            @if($rh->employe_nom)
                                <p><span class="font-medium">Employé:</span> {{ $rh->employe_nom }}</p>
                            @endif
                            @if($rh->reference)
                                <p><span class="font-medium">Référence:</span> {{ $rh->reference }}</p>
                            @endif
                            <p><span class="font-medium">Date du document:</span> {{ $rh->date_document->format('d/m/Y') }}</p>
                            @if($rh->date_debut)
                                <p><span class="font-medium">Date de début:</span> {{ $rh->date_debut->format('d/m/Y') }}</p>
                            @endif
                            @if($rh->date_fin)
                                <p><span class="font-medium">Date de fin:</span> {{ $rh->date_fin->format('d/m/Y') }}</p>
                            @endif
                            <p><span class="font-medium">Type:</span> {{ $rh->type }}</p>
                            <p><span class="font-medium">Statut:</span> {{ ucfirst($rh->statut) }}</p>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Document</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center space-x-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                                <div>
                                    <p class="text-sm text-gray-600">{{ basename($rh->fichier) }}</p>
                                    <div class="flex space-x-3 mt-2">
                                        
                                    <a href="{{ route('archives.rh.download', ['rh' => $rh->id]) }}" class="btn btn-primary">
    Télécharger
</a>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if($rh->description)
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Description</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-700 whitespace-pre-line">{{ $rh->description }}</p>
                        </div>
                    </div>
                @endif

                <div class="flex justify-end">
                    <a href="{{ route('archives.rh.index') }}" 
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