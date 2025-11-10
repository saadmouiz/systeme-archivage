@extends('layouts.sidebar')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="p-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-8">Nouveau Courrier Entrant</h1>

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

                <form action="{{ route('archives.courriers.arrivants.store') }}" 
                      method="POST" 
                      enctype="multipart/form-data"
                      class="space-y-8">
                    @csrf

                    <div>
                        <label for="date_arrive" class="block text-sm font-medium text-gray-700 mb-2">Date d'arrivée *</label>
                        <input type="date" 
                               name="date_arrive" 
                               id="date_arrive" 
                               class="mt-1 block w-full px-4 py-3 text-base rounded-lg border-gray-300 shadow-sm focus:border-blue-900 focus:ring-blue-900 transition-colors"
                               value="{{ old('date_arrive') }}" 
                               required>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="numero_document" class="block text-sm font-medium text-gray-700 mb-2">Numéro du document</label>
                            <input type="text" 
                                   name="numero_document" 
                                   id="numero_document" 
                                   class="mt-1 block w-full px-4 py-3 text-base rounded-lg border-gray-300 shadow-sm focus:border-blue-900 focus:ring-blue-900 transition-colors"
                                   value="{{ old('numero_document') }}">
                        </div>

                        <div>
                            <label for="date_document" class="block text-sm font-medium text-gray-700 mb-2">Date du document</label>
                            <input type="date" 
                                   name="date_document" 
                                   id="date_document" 
                                   class="mt-1 block w-full px-4 py-3 text-base rounded-lg border-gray-300 shadow-sm focus:border-blue-900 focus:ring-blue-900 transition-colors"
                                   value="{{ old('date_document') }}">
                        </div>
                    </div>

                    <div>
                        <label for="expediteur" class="block text-sm font-medium text-gray-700 mb-2">Expéditeur / Organisme d'Origine *</label>
                        <input type="text" 
                               name="expediteur" 
                               id="expediteur" 
                               class="mt-1 block w-full px-4 py-3 text-base rounded-lg border-gray-300 shadow-sm focus:border-blue-900 focus:ring-blue-900 transition-colors"
                               value="{{ old('expediteur') }}"
                               required>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   name="pieces_jointes" 
                                   id="pieces_jointes" 
                                   value="1"
                                   {{ old('pieces_jointes') ? 'checked' : '' }}
                                   class="h-5 w-5 text-blue-900 focus:ring-blue-900 border-gray-300 rounded">
                            <label for="pieces_jointes" class="ml-3 block text-sm text-gray-700">
                                Pièces jointes
                            </label>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" 
                                   name="renvoi" 
                                   id="renvoi" 
                                   value="1"
                                   {{ old('renvoi') ? 'checked' : '' }}
                                   class="h-5 w-5 text-blue-900 focus:ring-blue-900 border-gray-300 rounded">
                            <label for="renvoi" class="ml-3 block text-sm text-gray-700">
                                Renvoi
                            </label>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" 
                                   name="signature_recu" 
                                   id="signature_recu" 
                                   value="1"
                                   {{ old('signature_recu') ? 'checked' : '' }}
                                   class="h-5 w-5 text-blue-900 focus:ring-blue-900 border-gray-300 rounded">
                            <label for="signature_recu" class="ml-3 block text-sm text-gray-700">
                                Signature réceptionnée
                            </label>
                        </div>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea name="description" 
                                  id="description" 
                                  rows="4" 
                                  class="mt-1 block w-full px-4 py-3 text-base rounded-lg border-gray-300 shadow-sm focus:border-blue-900 focus:ring-blue-900 transition-colors resize-none">{{ old('description') }}</textarea>
                    </div>

                    <div>
                        <label for="fichier" class="block text-sm font-medium text-gray-700 mb-2">Fichier (optionnel)</label>
                        <input type="file" 
                               name="fichier" 
                               id="fichier" 
                               accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                               class="mt-1 block w-full px-4 py-3 text-base rounded-lg border-gray-300 shadow-sm focus:border-blue-900 focus:ring-blue-900 transition-colors">
                        <p class="mt-2 text-sm text-gray-500">Formats acceptés: PDF, Word, Images (max 10MB)</p>
                    </div>

                    <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                        <a href="{{ route('archives.courriers.arrivants.index') }}" 
                           class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-900">
                            Annuler
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-8 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-900 shadow-lg">
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

