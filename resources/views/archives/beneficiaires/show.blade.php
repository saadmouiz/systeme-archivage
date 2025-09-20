@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="p-6">
                <div class="flex justify-between items-start mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">{{ $beneficiaire->nom_complet }}</h1>
                    <div class="flex space-x-2">
                        <a href="{{ route('archives.beneficiaires.edit', $beneficiaire) }}" 
                           class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Modifier
                        </a>
                        <form action="{{ route('archives.beneficiaires.destroy', $beneficiaire) }}" 
                              method="POST" 
                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce dossier ?');">
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
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Informations personnelles</h3>
                        <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                            <p><span class="font-medium">CIN:</span> {{ $beneficiaire->cin ?? 'Non renseigné' }}</p>
                            @if($beneficiaire->age)
                                <p><span class="font-medium">Age:</span> {{ $beneficiaire->age }} ans</p>
                            @endif
                            @if($beneficiaire->societe)
                                <p><span class="font-medium">Société:</span> {{ $beneficiaire->societe }}</p>
                            @endif
                            <p><span class="font-medium">Type de document:</span> {{ $beneficiaire->type }}</p>
                            
                            @if($beneficiaire->type === 'Document éducatif')
                                @if($beneficiaire->genre)
                                    <p><span class="font-medium">Genre:</span> {{ $beneficiaire->genre }}</p>
                                @endif
                                @if($beneficiaire->status)
                                    <p><span class="font-medium">Status:</span> 
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($beneficiaire->status === 'Accepter') bg-green-100 text-green-800
                                            @elseif($beneficiaire->status === 'Refuser') bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ $beneficiaire->status }}
                                        </span>
                                    </p>
                                @endif
                                @if($beneficiaire->ass_eps)
                                    <p><span class="font-medium">Ass/Eps:</span> 
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($beneficiaire->ass_eps === 'Association') bg-blue-100 text-blue-800
                                            @elseif($beneficiaire->ass_eps === 'Eps') bg-purple-100 text-purple-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ $beneficiaire->ass_eps }}
                                        </span>
                                    </p>
                                @endif
                                @if($beneficiaire->ecole)
                                    <p><span class="font-medium">École:</span> {{ $beneficiaire->ecole->nom }}</p>
                                @endif
                            @endif

                            @if($beneficiaire->type === 'Dossier individuel')
                                <p><span class="font-medium">Genre:</span> 
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        @if($beneficiaire->genre === 'Homme') bg-blue-100 text-blue-800
                                        @elseif($beneficiaire->genre === 'Femme') bg-pink-100 text-pink-800
                                        @else bg-gray-100 text-gray-600
                                        @endif">
                                        @if($beneficiaire->genre === 'Homme') 👨 {{ $beneficiaire->genre }}
                                        @elseif($beneficiaire->genre === 'Femme') 👩 {{ $beneficiaire->genre }}
                                        @else Non spécifié
                                        @endif
                                    </span>
                                </p>
                                @if($beneficiaire->niveau)
                                    <p><span class="font-medium">Niveau:</span> 
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                            {{ $beneficiaire->niveau }}
                                        </span>
                                    </p>
                                @endif
                                @if($beneficiaire->specialite)
                                    <p><span class="font-medium">Spécialité:</span> 
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-teal-100 text-teal-800">
                                            {{ $beneficiaire->specialite }}
                                        </span>
                                    </p>
                                @endif
                                @if($beneficiaire->type_intervention)
                                    <p><span class="font-medium">Type d'intervention:</span> 
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            @if($beneficiaire->type_intervention === 'IP') bg-blue-100 text-blue-800
                                            @elseif($beneficiaire->type_intervention === 'AGR') bg-green-100 text-green-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ $beneficiaire->type_intervention }}
                                        </span>
                                    </p>
                                @endif
                            @endif
                            
                            <p><span class="font-medium">Date d'ajout:</span> {{ $beneficiaire->created_at->format('d/m/Y') }}</p>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Document</h3>
                        <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                            <p class="break-all"><span class="font-medium">Nom du fichier:</span> {{ basename($beneficiaire->fichier) }}</p>
                            <div class="flex space-x-2">
                                
                                <a href="{{ route('archives.beneficiaires.download', $beneficiaire) }}" 
                                   class="inline-flex items-center px-3 py-2 text-sm text-green-600 bg-green-100 rounded-md hover:bg-green-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                    </svg>
                                    Télécharger
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                @if($beneficiaire->description)
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Description</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-700 whitespace-pre-line">{{ $beneficiaire->description }}</p>
                        </div>
                    </div>
                @endif

                <div class="mt-6 flex justify-end">
                    <a href="{{ route('archives.beneficiaires.index') }}" 
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