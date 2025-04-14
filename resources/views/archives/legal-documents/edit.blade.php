@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-medium text-gray-900">
                    Modifier le document juridique
                </h2>
            </div>
            
            <form action="{{ route('archives.legal-documents.update', ['legal_document' => $document->id]) }}" method="POST" enctype="multipart/form-data" class="p-6">
    @csrf
    @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Informations de base -->
                    <div class="space-y-6">
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700">Type de document</label>
                            <select name="type" id="type"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0d9488] focus:ring-[#0d9488]">
                                <option value="permis" {{ $document->type === 'permis' ? 'selected' : '' }}>Permis</option>
                                <option value="licence" {{ $document->type === 'licence' ? 'selected' : '' }}>Licence</option>
                                <option value="litige" {{ $document->type === 'litige' ? 'selected' : '' }}>Litige</option>
                                <option value="propriete_intellectuelle" {{ $document->type === 'propriete_intellectuelle' ? 'selected' : '' }}>Propriété Intellectuelle</option>
                            </select>
                            @error('type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">Titre</label>
                            <input type="text" name="title" id="title" 
                                   value="{{ old('title', $document->title) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0d9488] focus:ring-[#0d9488]">
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="4"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0d9488] focus:ring-[#0d9488]">{{ old('description', $document->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Détails supplémentaires -->
                    <div class="space-y-6">
                        <div>
                            <label for="reference_number" class="block text-sm font-medium text-gray-700">Numéro de référence</label>
                            <input type="text" name="reference_number" id="reference_number" 
                                   value="{{ old('reference_number', $document->reference_number) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0d9488] focus:ring-[#0d9488]">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="date_emission" class="block text-sm font-medium text-gray-700">Date d'émission</label>
                                <input type="date" name="date_emission" id="date_emission" 
                                       value="{{ old('date_emission', $document->date_emission ? $document->date_emission->format('Y-m-d') : '') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0d9488] focus:ring-[#0d9488]">
                            </div>

                            <div>
                                <label for="date_expiration" class="block text-sm font-medium text-gray-700">Date d'expiration</label>
                                <input type="date" name="date_expiration" id="date_expiration" 
                                       value="{{ old('date_expiration', $document->date_expiration ? $document->date_expiration->format('Y-m-d') : '') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0d9488] focus:ring-[#0d9488]">
                            </div>
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Statut</label>
                            <select name="status" id="status"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0d9488] focus:ring-[#0d9488]">
                                <option value="actif" {{ $document->status === 'actif' ? 'selected' : '' }}>Actif</option>
                                <option value="expire" {{ $document->status === 'expire' ? 'selected' : '' }}>Expiré</option>
                                <option value="en_cours" {{ $document->status === 'en_cours' ? 'selected' : '' }}>En cours</option>
                                <option value="resolu" {{ $document->status === 'resolu' ? 'selected' : '' }}>Résolu</option>
                            </select>
                        </div>

                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                            <textarea name="notes" id="notes" rows="3"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0d9488] focus:ring-[#0d9488]">{{ old('notes', $document->notes) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Fichiers existants -->
                @if($document->files->count() > 0)
                <div class="mt-8 border-t pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Fichiers existants</h3>
                    <ul class="divide-y divide-gray-200">
                        @foreach($document->files as $file)
                        <li class="py-3 flex justify-between items-center">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                                <span class="ml-2 flex-1 w-0 truncate text-sm text-gray-500">
                                    {{ $file->filename }}
                                </span>
                            </div>
                            <div class="ml-4 flex-shrink-0 flex items-center space-x-3">
                                <a href="{{ $file->file_url }}" target="_blank"
                                   class="text-sm font-medium text-[#0d9488] hover:text-green-700">
                                    Voir
                                </a>
                                <form action="{{ route('legal-documents.files.delete', ['legal_document' => $document->id, 'file' => $file->id]) }}" method="POST">
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

                <!-- Nouveaux fichiers -->
                <div class="mt-8 border-t pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Ajouter des fichiers</h3>
                    <input type="file" name="files[]" multiple
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#0d9488] file:text-white hover:file:bg-green-700">
                    <p class="mt-2 text-sm text-gray-500">
                        Formats acceptés : PDF, Word, Images (max 10MB)
                    </p>
                </div>

                <div class="mt-8 border-t pt-6 flex justify-end space-x-4">
                    <a href="{{ route('legal-documents.show', $document) }}"
                       class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Annuler
                    </a>
                    <button type="submit"
                            class="bg-[#0d9488] py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-green-700">
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection