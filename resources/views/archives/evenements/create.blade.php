@extends('layouts.sidebar')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Créer un nouvel événement</h1>

            <form action="{{ route('archives.evenements.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="space-y-6">
                    <div>
                        <label for="titre" class="block text-sm font-medium text-gray-700">Titre</label>
                        <input type="text" name="titre" id="titre" value="{{ old('titre') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0d9488] focus:ring-[#0d9488]">
                        @error('titre')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="description" rows="4"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0d9488] focus:ring-[#0d9488]">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                            <select name="type" id="type"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0d9488] focus:ring-[#0d9488]">
                                <option value="interne" {{ old('type') === 'interne' ? 'selected' : '' }}>Interne</option>
                                <option value="externe" {{ old('type') === 'externe' ? 'selected' : '' }}>Externe</option>
                            </select>
                        </div>

                        <div>
                            <label for="categorie" class="block text-sm font-medium text-gray-700">Catégorie</label>
                            <select name="categorie" id="categorie"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0d9488] focus:ring-[#0d9488]">
                                <option value="collecte">Collecte de fonds</option>
                                <option value="conference">Conférence</option>
                                <option value="campagne">Campagne</option>
                                <option value="autre">Autre</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="date_debut" class="block text-sm font-medium text-gray-700">Date de début</label>
                            <input type="datetime-local" name="date_debut" id="date_debut"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0d9488] focus:ring-[#0d9488]">
                        </div>

                        <div>
                            <label for="date_fin" class="block text-sm font-medium text-gray-700">Date de fin</label>
                            <input type="datetime-local" name="date_fin" id="date_fin"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0d9488] focus:ring-[#0d9488]">
                        </div>
                    </div>

                    <div>
                        <label for="lieu" class="block text-sm font-medium text-gray-700">Lieu</label>
                        <input type="text" name="lieu" id="lieu"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0d9488] focus:ring-[#0d9488]">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="nombre_participants" class="block text-sm font-medium text-gray-700">Nombre de participants</label>
                            <input type="number" name="nombre_participants" id="nombre_participants"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0d9488] focus:ring-[#0d9488]">
                        </div>

                        <div>
                            <label for="budget" class="block text-sm font-medium text-gray-700">Budget</label>
                            <input type="number" step="0.01" name="budget" id="budget"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0d9488] focus:ring-[#0d9488]">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Médias</label>
                        <input type="file" name="medias[]" multiple
                               class="mt-1 block w-full text-sm text-gray-500
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-full file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-[#0d9488] file:text-white
                                      hover:file:bg-red-900">
                        <p class="mt-1 text-sm text-gray-500">Vous pouvez sélectionner plusieurs fichiers</p>
                    </div>

                    <div class="flex justify-end pt-5">
                        <button type="button" onclick="window.history.back()"
                                class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0d9488]">
                            Annuler
                        </button>
                        <button type="submit"
                                class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-900 hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0d9488]">
                            Créer l'événement
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection