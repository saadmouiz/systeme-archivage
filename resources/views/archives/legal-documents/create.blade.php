@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-medium text-gray-900">
                    Nouveau Document Juridique
                </h2>
            </div>
            
            <form action="{{ route('archives.legal-documents.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Informations de base -->
                    <div class="space-y-6">
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700">Type de document</label>
                            <select name="type" id="type"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0d9488] focus:ring-[#0d9488]">
                                <option value="permis">Permis</option>
                                <option value="licence">Licence</option>
                                <option value="litige">Litige</option>
                                <option value="propriete_intellectuelle">Propriété Intellectuelle</option>
                            </select>
                            @error('type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">Titre</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0d9488] focus:ring-[#0d9488]">
                            @error('title')
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
                    </div>

                    <!-- Détails supplémentaires -->
                    <div class="space-y-6">
                        <div>
                            <label for="reference_number" class="block text-sm font-medium text-gray-700">Numéro de référence</label>
                            <input type="text" name="reference_number" id="reference_number" value="{{ old('reference_number') }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0d9488] focus:ring-[#0d9488]">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="date_emission" class="block text-sm font-medium text-gray-700">Date d'émission</label>
                                <input type="date" name="date_emission" id="date_emission" value="{{ old('date_emission') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0d9488] focus:ring-[#0d9488]">
                            </div>

                            <div>
                                <label for="date_expiration" class="block text-sm font-medium text-gray-700">Date d'expiration</label>
                                <input type="date" name="date_expiration" id="date_expiration" value="{{ old('date_expiration') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0d9488] focus:ring-[#0d9488]">
                            </div>
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Statut</label>
                            <select name="status" id="status"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0d9488] focus:ring-[#0d9488]">
                                <option value="actif">Actif</option>
                                <option value="expire">Expiré</option>
                                <option value="en_cours">En cours</option>
                                <option value="resolu">Résolu</option>
                            </select>
                        </div>

                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                            <textarea name="notes" id="notes" rows="3"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#0d9488] focus:ring-[#0d9488]">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Documents -->
                <div class="mt-8 border-t pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Fichiers</h3>
                    <input type="file" name="files[]" multiple
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#0d9488] file:text-white hover:file:bg-green-700">
                    <p class="mt-2 text-sm text-gray-500">
                        Formats acceptés : PDF, Word, Images (max 10MB)
                    </p>
                </div>

                <div class="mt-8 border-t pt-6 flex justify-end space-x-4">
                    <a href="{{ route('archives.legal-documents.index') }}"
                       class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Annuler
                    </a>
                    <button type="submit"
                            class="bg-[#0d9488] py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-green-700">
                        Créer le document
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection