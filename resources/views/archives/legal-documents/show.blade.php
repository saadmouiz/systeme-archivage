@extends('layouts.sidebar')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $document->title }}</h1>
                        <div class="mt-2 flex items-center space-x-4">
                            <span class="px-3 py-1 rounded-full text-sm font-medium {{ $document->status_badge_class }}">
                                {{ ucfirst($document->status) }}
                            </span>
                            @if($document->reference_number)
                                <span class="text-sm text-gray-500">
                                    Réf: {{ $document->reference_number }}
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="flex space-x-3">
                        <!-- Lien pour modifier le document -->
                        <a href="{{ route('archives.legal-documents.edit', $document) }}"
                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                            Modifier
                        </a>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Informations principales -->
                <div class="md:col-span-2 space-y-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Description</h3>
                        <p class="mt-2 text-gray-600">{{ $document->description }}</p>
                    </div>

                    @if($document->notes)
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Notes</h3>
                        <div class="mt-2 prose prose-sm text-gray-600">
                            {{ $document->notes }}
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Informations complémentaires -->
                <div class="space-y-6">
                    <div class="bg-white rounded-lg border p-4">
                        <h4 class="text-sm font-medium text-gray-900">Informations</h4>
                        <dl class="mt-3 space-y-2">
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Type</dt>
                                <dd class="text-sm font-medium text-gray-900">
                                    {{ ucfirst($document->type) }}
                                </dd>
                            </div>
                            @if($document->date_emission)
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Date d'émission</dt>
                                <dd class="text-sm font-medium text-gray-900">
                                    {{ $document->date_emission->format('d/m/Y') }}
                                </dd>
                            </div>
                            @endif
                            @if($document->date_expiration)
                            <div class="flex justify-between">
                                <dt class="text-sm text-gray-500">Date d'expiration</dt>
                                <dd class="text-sm font-medium text-gray-900">
                                    {{ $document->date_expiration->format('d/m/Y') }}
                                </dd>
                            </div>
                            @endif
                        </dl>
                    </div>

                    <!-- Fichiers -->
                    @if($document->files->count() > 0)
                    <div class="bg-white rounded-lg border p-4">
                        <h4 class="text-sm font-medium text-gray-900">Documents</h4>
                        <ul class="mt-3 divide-y divide-gray-200">
                            @foreach($document->files as $file)
                            <li class="py-3 flex justify-between items-center">
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="ml-2 flex-1 w-0 truncate text-sm text-gray-500">
                                        {{ $file->filename }}
                                    </span>
                                </div>
                                <div class="ml-4 flex-shrink-0 flex items-center space-x-3">
                                    <a href="{{ $file->file_url }}" target="_blank"
                                       class="text-sm font-medium text-[#0d9488] hover:text-red-900">
                                        Télécharger
                                    </a>
                                    <form action="{{ route('archives.legal-documents.files.delete', [$document, $file]) }}" 
                                          method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce fichier ?')"
                                                class="text-sm font-medium text-red-600 hover:text-red-700">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Historique -->
        <div class="mt-8 bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="px-6 py-4">
                <h3 class="text-lg font-medium text-gray-900">Historique</h3>
                <div class="mt-4 flex items-center text-sm text-gray-500">
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Créé le {{ $document->created_at->format('d/m/Y à H:i') }}
                </div>
                @if($document->updated_at && $document->updated_at != $document->created_at)
                <div class="mt-2 flex items-center text-sm text-gray-500">
                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                    Dernière modification le {{ $document->updated_at->format('d/m/Y à H:i') }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
