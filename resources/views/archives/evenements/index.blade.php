@extends('layouts.sidebar')

@section('content')
<div class="container mx-auto px-8 py-20">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Gestion des Événements</h1>
        <a href="{{ route('archives.evenements.create') }}" 
           class="bg-red-900 text-white px-4 py-2 rounded-lg hover:bg-red-900 transition-colors">
            Nouvel Événement
        </a>
    </div>

    @if(session('success'))
    <div class="bg-[#FEE2E2] border border-red-300 text-red-900 px-4 py-3 rounded relative mb-4" role="alert">
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
                            {{ $evenement->type === 'interne' ? 'bg-red-100 text-red-900' : 'bg-red-100 text-red-900' }}">
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
                                @case('planifie') bg-red-100 text-red-900 @break
                                @case('en_cours') bg-red-100 text-red-900 @break
                                @case('termine') bg-red-100 text-red-900 @break
                                @case('annule') bg-red-100 text-red-800 @break
                            @endswitch">
                            {{ ucfirst($evenement->statut) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('archives.evenements.show', $evenement) }}" 
                               class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 rounded-md hover:bg-blue-200 transition-colors text-sm font-medium">
                                Voir
                            </a>
                            <a href="{{ route('archives.evenements.edit', $evenement) }}" 
                               class="inline-flex items-center px-3 py-1 bg-yellow-100 text-yellow-800 rounded-md hover:bg-yellow-200 transition-colors text-sm font-medium">
                                Modifier
                            </a>
                            <form action="{{ route('archives.evenements.destroy', $evenement) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="inline-flex items-center px-3 py-1 bg-red-100 text-red-800 rounded-md hover:bg-red-200 transition-colors text-sm font-medium"
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet événement ?')">
                                    Supprimer
                                </button>
                            </form>
                        </div>
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