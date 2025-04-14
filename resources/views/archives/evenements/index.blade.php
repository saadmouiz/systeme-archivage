@extends('layouts.app')

@section('content')
<div class="container mx-auto px-8 py-20">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Gestion des Événements</h1>
        <a href="{{ route('archives.evenements.create') }}" 
           class="bg-green-700 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
            Nouvel Événement
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Titre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($evenements as $evenement)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $evenement->titre }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $evenement->type === 'interne' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                            {{ ucfirst($evenement->type) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
    @if($evenement->date_debut)
        {{ \Carbon\Carbon::parse($evenement->date_debut)->format('d/m/Y') }}
    @else
        Non défini
    @endif
</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                            @switch($evenement->statut)
                                @case('planifie') bg-yellow-100 text-yellow-800 @break
                                @case('en_cours') bg-blue-100 text-blue-800 @break
                                @case('termine') bg-green-100 text-green-800 @break
                                @case('annule') bg-red-100 text-red-800 @break
                            @endswitch">
                            {{ ucfirst($evenement->statut) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('archives.evenements.show', $evenement) }}" 
                           class="text-indigo-600 hover:text-indigo-900 mr-3">Voir</a>
                        <a href="{{ route('archives.evenements.edit', $evenement) }}" 
                           class="text-yellow-600 hover:text-yellow-900 mr-3">Modifier</a>
                        <form action="{{ route('archives.evenements.destroy', $evenement) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900"
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet événement ?')">
                                Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $evenements->links() }}
    </div>
</div>