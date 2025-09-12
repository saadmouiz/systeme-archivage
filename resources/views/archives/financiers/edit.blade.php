@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="p-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Modifier le Document Financier</h1>

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

                <form action="{{ route('archives.financiers.update', $financier) }}" 
                      method="POST" 
                      enctype="multipart/form-data"
                      class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="titre" class="block text-sm font-medium text-gray-700">Titre</label>
                            <input type="text" 
                                   name="titre" 
                                   id="titre" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   value="{{ old('titre', $financier->titre) }}" 
                                   required>
                        </div>

                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700">Type de document</label>
                            <select name="type" 
                                    id="type" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    required>
                                @foreach($types as $type)
                                    <option value="{{ $type }}" {{ old('type', $financier->type) == $type ? 'selected' : '' }}>
                                        {{ $type }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Champ conditionnel pour les types de journaux -->
                    <div id="journal-type-field" class="{{ old('type', $financier->type) == 'Journaux' ? '' : 'hidden' }}">
                        <div>
                            <label for="journal_type" class="block text-sm font-medium text-gray-700">Type de journal</label>
                            <select name="journal_type" 
                                    id="journal_type" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Sélectionnez un type de journal</option>
                                <option value="Journal des achats" {{ old('journal_type', $financier->journal_type) == 'Journal des achats' ? 'selected' : '' }}>Journal des achats</option>
                                <option value="Journal des ventes" {{ old('journal_type', $financier->journal_type) == 'Journal des ventes' ? 'selected' : '' }}>Journal des ventes</option>
                                <option value="Journal de trésorerie" {{ old('journal_type', $financier->journal_type) == 'Journal de trésorerie' ? 'selected' : '' }}>Journal de trésorerie</option>
                                <option value="Journal des opérations diverses" {{ old('journal_type', $financier->journal_type) == 'Journal des opérations diverses' ? 'selected' : '' }}>Journal des opérations diverses</option>
                                <option value="Journal des encaissements" {{ old('journal_type', $financier->journal_type) == 'Journal des encaissements' ? 'selected' : '' }}>Journal des encaissements</option>
                                <option value="Journal des paiements en espèces" {{ old('journal_type', $financier->journal_type) == 'Journal des paiements en espèces' ? 'selected' : '' }}>Journal des paiements en espèces</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="montant" class="block text-sm font-medium text-gray-700">Montant (DH)</label>
                        <input type="number" 
                               name="montant" 
                               id="montant" 
                               step="0.01" 
                               value="{{ old('montant', $financier->montant) }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="date_document" class="block text-sm font-medium text-gray-700">Date du document</label>
                            <input type="date" 
                                   name="date_document" 
                                   id="date_document" 
                                   value="{{ old('date_document', $financier->date_document->format('Y-m-d')) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   required>
                        </div>

                        <div>
                            <label for="annee_financiere" class="block text-sm font-medium text-gray-700">Année financière</label>
                            <select name="annee_financiere" 
                                    id="annee_financiere" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    required>
                                @foreach($annees as $annee)
                                    <option value="{{ $annee }}" {{ old('annee_financiere', $financier->annee_financiere) == $annee ? 'selected' : '' }}>
                                        {{ $annee }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="statut" class="block text-sm font-medium text-gray-700">Statut</label>
                        <select name="statut" 
                                id="statut" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                required>
                            @foreach($statuts as $key => $value)
                                <option value="{{ $key }}" {{ old('statut', $financier->statut) == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" 
                                  id="description" 
                                  rows="4" 
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description', $financier->description) }}</textarea>
                    </div>

                    <!-- Fichier actuel -->
                    @if($financier->fichier)
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700">Document actuel</label>
                            <div class="mt-1 flex items-center">
                                <span class="text-sm text-gray-500">{{ basename($financier->fichier) }}</span>
                                <a href="{{ Storage::url($financier->fichier) }}" 
                                   class="ml-2 text-sm text-blue-600 hover:text-blue-500"
                                   target="_blank">
                                    Voir le document
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- Nouveau fichier -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nouveau document (optionnel)</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" 
                                          stroke-width="2" 
                                          stroke-linecap="round" 
                                          stroke-linejoin="round"/>
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="fichier" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 hover:underline">
                                        <span>Téléverser un nouveau fichier</span>
                                        <input id="fichier" name="fichier" type="file" class="sr-only">
                                    </label>
                                </div>
                                <p class="text-xs text-gray-500">PDF, DOC, DOCX, XLS, XLSX jusqu'à 10MB</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('archives.financiers.index') }}" 
                           class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-gray-700 bg-gray-100 hover:bg-gray-200">
                            Annuler
                        </a>
                        <button type="submit" 
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('type');
    const journalTypeField = document.getElementById('journal-type-field');
    const journalTypeSelect = document.getElementById('journal_type');

    function toggleJournalTypeField() {
        if (typeSelect.value === 'Journaux') {
            journalTypeField.classList.remove('hidden');
            journalTypeSelect.required = true;
        } else {
            journalTypeField.classList.add('hidden');
            journalTypeSelect.required = false;
            journalTypeSelect.value = '';
        }
    }

    // Vérifier l'état initial au chargement de la page
    toggleJournalTypeField();

    // Écouter les changements sur le select de type
    typeSelect.addEventListener('change', toggleJournalTypeField);
});
</script>
@endsection