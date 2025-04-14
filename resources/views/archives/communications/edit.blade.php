@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="p-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Modifier le Document de Communication</h1>

                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <ul class="text-sm text-red-600">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ route('archives.communications.update', $communication) }}" 
                      method="POST" 
                      enctype="multipart/form-data"
                      class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Mêmes champs que create.blade.php mais avec les valeurs existantes -->
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700">Type de document</label>
                        <select name="type" id="type" class="mt-1 block w-full rounded-md border-gray-300" required>
                            @foreach($types as $key => $value)
                                <option value="{{ $key }}" {{ $communication->type === $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="titre" class="block text-sm font-medium text-gray-700">Titre</label>
                        <input type="text" name="titre" id="titre" 
                               value="{{ old('titre', $communication->titre) }}"
                               class="mt-1 block w-full rounded-md border-gray-300">
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="description" rows="4" 
                                  class="mt-1 block w-full rounded-md border-gray-300">{{ old('description', $communication->description) }}</textarea>
                    </div>

                    <div>
                        <label for="date_publication" class="block text-sm font-medium text-gray-700">Date de publication</label>
                        <input type="date" name="date_publication" id="date_publication"
                               value="{{ old('date_publication', $communication->date_publication->format('Y-m-d')) }}"
                               class="mt-1 block w-full rounded-md border-gray-300">
                    </div>

                    <div>
                        <label for="format_type" class="block text-sm font-medium text-gray-700">Format</label>
                        <select name="format_type" id="format_type" class="mt-1 block w-full rounded-md border-gray-300" required>
                            @foreach($formats as $key => $value)
                                <option value="{{ $key }}" {{ $communication->format_type === $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Fichier existant -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Fichier actuel</label>
                        <div class="mt-1">
                            <a href="{{ Storage::url($communication->fichier) }}" 
                               class="text-blue-600 hover:underline"
                               target="_blank">
                                {{ basename($communication->fichier) }}
                            </a>
                        </div>
                    </div>

                    <!-- Nouveau fichier -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nouveau fichier (optionnel)</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" 
                                          stroke-width="2" 
                                          stroke-linecap="round" 
                                          stroke-linejoin="round"/>
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="fichier" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500">
                                        <span>Téléverser un nouveau fichier</span>
                                        <input id="fichier" name="fichier" type="file" class="sr-only">
                                    </label>
                                </div>
                                <p class="text-xs text-gray-500">PDF, DOC, DOCX, JPG, PNG, MP4 jusqu'à 20MB</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('archives.communications.index') }}" 
                           class="px-4 py-2 text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                            Annuler
                        </a>
                        <button type="submit" 
                                class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">
                            Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection