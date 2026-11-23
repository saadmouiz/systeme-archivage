@extends('layouts.sidebar')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="p-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-2">Nouvelle inscription / Réorientation</h1>
                <p class="text-sm text-gray-600 mb-6">
                    {{ $beneficiaire->nom_complet }}
                    @if($beneficiaire->cin) — CIN {{ $beneficiaire->cin }} @endif
                </p>

                @if($beneficiaire->parcoursActuel)
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6 text-sm">
                        <p class="font-medium text-blue-900 mb-1">Parcours actuel</p>
                        <p>École : {{ optional($beneficiaire->parcoursActuel->ecole)->nom ?? '—' }}</p>
                        <p>Filière : {{ $beneficiaire->parcoursActuel->filiere ?? '—' }}</p>
                        <p>Année : {{ $beneficiaire->parcoursActuel->annee_academique ?? '—' }}</p>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                        <ul class="text-sm text-red-600 list-disc pl-4">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('archives.beneficiaires.reorient', $beneficiaire) }}" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nouveau partenaire / École</label>
                        <select name="ecole_id" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-900 focus:border-red-900">
                            <option value="">Sélectionnez</option>
                            @foreach($ecoles as $id => $nom)
                                <option value="{{ $id }}" {{ (string) old('ecole_id') === (string) $id ? 'selected' : '' }}>{{ $nom }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nouvelle filière</label>
                        <input type="text" name="filiere" value="{{ old('filiere') }}" required
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-900 focus:border-red-900">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Niveau d'études (optionnel)</label>
                        <input type="text" name="niveau" value="{{ old('niveau') }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-900 focus:border-red-900">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Année académique</label>
                        <input type="text" name="annee_academique" value="{{ old('annee_academique', date('Y') . '/' . (date('Y')+1)) }}"
                               placeholder="2026/2027" required
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-900 focus:border-red-900">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Statut de l'ancien cursus</label>
                        <select name="statut_ancien" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-900 focus:border-red-900">
                            @foreach($statutsFin as $key => $label)
                                <option value="{{ $key }}" {{ old('statut_ancien', 'Réorienté') === $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Notes</label>
                        <textarea name="notes" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-900 focus:border-red-900">{{ old('notes') }}</textarea>
                    </div>

                    <div class="flex justify-end gap-3 pt-2">
                        <a href="{{ route('archives.beneficiaires.show', $beneficiaire) }}"
                           class="px-4 py-2 border border-gray-300 rounded-md text-sm text-gray-700 bg-white hover:bg-gray-50">Annuler</a>
                        <button type="submit" class="px-4 py-2 bg-red-900 text-white rounded-md text-sm hover:bg-red-800">
                            Enregistrer la réorientation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
