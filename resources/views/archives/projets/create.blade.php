@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-medium text-gray-900">Nouveau Projet</h2>
            </div>

            <form action="{{ route('archives.projets.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf

                <!-- Type de projet -->
                <div class="mb-6">
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Type de projet</label>
                    <select name="type" id="type" 
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-[#0d9488] focus:border-[#0d9488]">
                        <option value="">Sélectionnez un type</option>
                        @foreach($types as $type)
                            <option value="{{ $type }}" {{ old('type') === $type ? 'selected' : '' }}>
                                {{ $type }}
                            </option>
                        @endforeach
                    </select>
                    @error('type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nom -->
                <div class="mb-6">
                    <label for="nom" class="block text-sm font-medium text-gray-700 mb-2">Nom du projet</label>
                    <input type="text" name="nom" id="nom" value="{{ old('nom') }}"
                           class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-[#0d9488] focus:border-[#0d9488]">
                    @error('nom')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Responsable -->
                <div class="mb-6">
                    <label for="responsable" class="block text-sm font-medium text-gray-700 mb-2">Responsable</label>
                    <input type="text" name="responsable" id="responsable" value="{{ old('responsable') }}"
                           class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-[#0d9488] focus:border-[#0d9488]">
                    @error('responsable')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Date début -->
                    <div>
                        <label for="date_debut" class="block text-sm font-medium text-gray-700 mb-2">Date de début</label>
                        <input type="date" name="date_debut" id="date_debut" value="{{ old('date_debut') }}"
                               class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-[#0d9488] focus:border-[#0d9488]">
                        @error('date_debut')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date fin -->
                    <div>
                        <label for="date_fin" class="block text-sm font-medium text-gray-700 mb-2">Date de fin</label>
                        <input type="date" name="date_fin" id="date_fin" value="{{ old('date_fin') }}"
                               class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-[#0d9488] focus:border-[#0d9488]">
                        @error('date_fin')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Statut -->
                <div class="mb-6">
                    <label for="statut" class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                    <select name="statut" id="statut" 
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-[#0d9488] focus:border-[#0d9488]">
                        @foreach($statuts as $value => $label)
                            <option value="{{ $value }}" {{ old('statut') === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('statut')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="description" id="description" rows="4"
                              class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-[#0d9488] focus:border-[#0d9488]">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Fichier -->
                <div class="mb-6">
                    <label for="fichier" class="block text-sm font-medium text-gray-700 mb-2">Document</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="fichier"
                                    class="relative cursor-pointer bg-white rounded-md font-medium text-[#0d9488] hover:text-[#0d9488]/90">
                                    <span>Téléverser un fichier</span>
                                    <input id="fichier" name="fichier" type="file" class="sr-only">
                                </label>
                                <p class="pl-1">ou glisser-déposer</p>
                            </div>
                            <p class="text-xs text-gray-500">PDF, DOC, DOCX, JPG, JPEG, PNG jusqu'à 10MB</p>
                        </div>
                    </div>
                    @error('fichier')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('archives.projets.index') }}"
                       class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Annuler
                    </a>
                    <button type="submit"
                            class="px-4 py-2 bg-[#0d9488] hover:bg-[#0d9488]/90 text-white rounded-lg text-sm font-medium">
                        Créer le projet
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection