@extends('layouts.sidebar')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-8 flex flex-col md:flex-row md:justify-between md:items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Gestion des Visiteurs</h1>
                <p class="mt-2 text-sm text-gray-600">Suivi des visiteurs de l'association</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('visiteurs.print', request()->only(['annee','mois','genre'])) }}"
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    Imprimer le rapport
                </a>
                <a href="{{ route('visiteurs.export.pdf', request()->only(['annee','mois','genre'])) }}"
                   class="inline-flex items-center px-4 py-2 border border-red-800 rounded-md shadow-sm text-sm font-medium text-white bg-red-900 hover:bg-red-800">
                    Exporter PDF
                </a>
                <a href="{{ route('visiteurs.export.excel', request()->only(['annee','mois','genre'])) }}"
                   class="inline-flex items-center px-4 py-2 border border-green-700 rounded-md shadow-sm text-sm font-medium text-white bg-green-700 hover:bg-green-800">
                    Exporter Excel{{ request('annee') ? ' ' . request('annee') : '' }}
                </a>
                <a href="{{ route('visiteurs.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-900 hover:bg-red-800">
                    Nouveau Visiteur
                </a>
            </div>
        </div>

        <div class="mb-8 bg-white overflow-hidden shadow rounded-lg p-5">
            <form method="GET" action="{{ route('visiteurs.index') }}" class="flex flex-wrap gap-3 items-end">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1 uppercase">Année</label>
                    <select name="annee" class="rounded-lg border-gray-300 text-sm">
                        <option value="">Toutes</option>
                        @foreach(($annees ?? []) as $annee)
                            <option value="{{ $annee }}" {{ (string) request('annee') === (string) $annee ? 'selected' : '' }}>{{ $annee }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1 uppercase">Mois</label>
                    <select name="mois" class="rounded-lg border-gray-300 text-sm">
                        <option value="">Tous</option>
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ (string) request('mois') === (string) $m ? 'selected' : '' }}>{{ $m }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1 uppercase">Genre</label>
                    <select name="genre" class="rounded-lg border-gray-300 text-sm">
                        <option value="">Tous</option>
                        <option value="Homme" {{ request('genre') === 'Homme' ? 'selected' : '' }}>Hommes</option>
                        <option value="Femme" {{ request('genre') === 'Femme' ? 'selected' : '' }}>Femmes</option>
                    </select>
                </div>
                <button type="submit" class="px-4 py-2 bg-[#FEE2E2] border border-red-300 text-red-900 rounded-lg text-sm font-medium">Filtrer</button>
                <a href="{{ route('visiteurs.index') }}" class="px-4 py-2 text-sm text-gray-600">Réinitialiser</a>
            </form>
        </div>

        <div class="mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg p-5">
                <div class="text-sm text-gray-500">Total des visiteurs</div>
                <div class="text-2xl font-semibold text-gray-900">{{ $visiteurs->count() }}</div>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded">
                <p class="text-sm text-green-800">{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Prénom</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">CIN</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Genre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Heure d'arrivée</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($visiteurs as $visiteur)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $visiteur->nom }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $visiteur->prenom }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $visiteur->cin }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $visiteur->genre ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ optional($visiteur->heure_arrivee)->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('visiteurs.show', $visiteur) }}" class="text-blue-700 hover:underline">Voir</a>
                                        <a href="{{ route('visiteurs.edit', $visiteur) }}" class="text-yellow-700 hover:underline">Modifier</a>
                                        <form action="{{ route('visiteurs.destroy', $visiteur) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer ce visiteur ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-700 hover:underline">Supprimer</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-sm text-gray-500 text-center">Aucun visiteur enregistré</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
