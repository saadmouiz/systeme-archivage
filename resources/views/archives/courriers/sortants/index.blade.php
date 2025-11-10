@extends('layouts.sidebar')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-red-50">
    <div class="container mx-auto px-4 py-12">
        <!-- Header Section -->
        <div class="mb-12">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div class="mb-6 lg:mb-0">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-[#FEE2E2] border border-red-300 rounded-2xl flex items-center justify-center mr-4 shadow-lg">
                            <svg class="w-6 h-6 text-red-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-4xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">
                                Courriers
                            </h1>
                            <p class="text-gray-600 mt-2">Gestion des courriers entrants et sortants</p>
                        </div>
                    </div>
                </div>
                <a href="{{ route('archives.courriers.sortants.create') }}" 
                   class="group relative inline-flex items-center px-8 py-4 bg-[#871C1C] border border-red-300 text-white font-semibold rounded-2xl shadow-2xl hover:shadow-red-900/25 transition-all duration-300 hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-r from-red-900 to-red-700 rounded-2xl blur opacity-30 group-hover:opacity-50 transition duration-300"></div>
                    <svg class="w-5 h-5 mr-3 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span class="relative z-10">Nouveau Courrier</span>
                </a>
            </div>
        </div>

        <!-- Tabs Section -->
        <div class="mb-8">
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-2 shadow-xl border border-white/20">
                <div class="flex space-x-2">
                    <a href="{{ route('archives.courriers.arrivants.index') }}" 
                       class="flex-1 flex items-center justify-center py-3 px-4 rounded-xl font-medium text-sm transition-all duration-300 text-gray-600 hover:bg-gray-100">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Courriers Entrants
                    </a>
                    <a href="{{ route('archives.courriers.sortants.index') }}" 
                       class="flex-1 flex items-center justify-center py-3 px-4 rounded-xl font-medium text-sm transition-all duration-300 bg-[#FEE2E2] border border-red-300 text-red-900 shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"/>
                        </svg>
                        Courriers Sortants
                    </a>
                </div>
            </div>
        </div>

        <!-- Filtres Section -->
        <div class="mb-12">
            <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-8 shadow-xl border border-white/20">
                <form action="{{ route('archives.courriers.sortants.index') }}" method="GET" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="text" 
                                   name="search" 
                                   placeholder="Rechercher..." 
                                   class="w-full pl-12 pr-4 py-4 text-lg border-2 border-gray-200 rounded-2xl shadow-sm focus:ring-4 focus:ring-red-900/20 focus:border-red-900 transition-all duration-300 bg-white/50 backdrop-blur-sm"
                                   value="{{ request('search') }}">
                        </div>
                        <div>
                            <input type="date" 
                                   name="date_from" 
                                   class="w-full px-4 py-4 text-lg border-2 border-gray-200 rounded-2xl shadow-sm focus:ring-4 focus:ring-red-900/20 focus:border-red-900 transition-all duration-300 bg-white/50 backdrop-blur-sm"
                                   value="{{ request('date_from') }}">
                        </div>
                        <div>
                            <input type="date" 
                                   name="date_to" 
                                   class="w-full px-4 py-4 text-lg border-2 border-gray-200 rounded-2xl shadow-sm focus:ring-4 focus:ring-red-900/20 focus:border-red-900 transition-all duration-300 bg-white/50 backdrop-blur-sm"
                                   value="{{ request('date_to') }}">
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <button type="submit" 
                                class="px-8 py-3 bg-red-900 text-white font-semibold rounded-xl hover:bg-red-700 shadow-lg hover:shadow-xl transition-all duration-200">
                            Filtrer
                        </button>
                        <a href="{{ route('archives.courriers.sortants.index') }}" 
                           class="px-8 py-3 bg-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-300 transition-all duration-200">
                            Réinitialiser
                        </a>
                    </div>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-8 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-red-900 p-6 rounded-r-2xl shadow-lg">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-500 flex items-center justify-center rounded-full">
                            <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-green-900">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-8 bg-gradient-to-r from-red-50 to-pink-50 border-l-4 border-red-900 p-6 rounded-r-2xl shadow-lg">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-red-500 flex items-center justify-center rounded-full">
                            <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-red-900">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Table -->
        <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-8 shadow-xl border border-white/20 overflow-x-auto">
            @if($courriers->count() > 0)
                <table class="w-full">
                    <thead>
                        <tr class="border-b-2 border-gray-200">
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Numéro Sortant</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Date Sortant</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Destinataire</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Sujet</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($courriers as $courrier)
                            <tr class="hover:bg-red-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="font-mono font-semibold text-red-900">{{ $courrier->numero_sortant }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $courrier->date_sortant->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 text-gray-700 font-medium">{{ $courrier->destinataire }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ \Illuminate\Support\Str::limit($courrier->sujet, 50) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('archives.courriers.sortants.show', $courrier) }}" 
                                           class="p-2 text-red-600 hover:text-white hover:bg-red-600 rounded-lg transition-all duration-200"
                                           title="Voir">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                        @if($courrier->fichier)
                                            <a href="{{ route('archives.courriers.sortants.download', $courrier) }}" 
                                               class="p-2 text-green-600 hover:text-white hover:bg-green-600 rounded-lg transition-all duration-200"
                                               title="Télécharger">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                                </svg>
                                            </a>
                                        @endif
                                        <a href="{{ route('archives.courriers.sortants.edit', $courrier) }}" 
                                           class="p-2 text-yellow-600 hover:text-white hover:bg-yellow-600 rounded-lg transition-all duration-200"
                                           title="Modifier">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        <form action="{{ route('archives.courriers.sortants.destroy', $courrier) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce courrier ?');"
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="p-2 text-red-600 hover:text-white hover:bg-red-600 rounded-lg transition-all duration-200"
                                                    title="Supprimer">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $courriers->links() }}
                </div>
            @else
                <div class="text-center py-20">
                    <div class="mx-auto w-32 h-32 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-8 shadow-xl">
                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Aucun courrier trouvé</h3>
                    <p class="text-gray-600 text-lg mb-8">Commencez par ajouter votre premier courrier sortant.</p>
                    <a href="{{ route('archives.courriers.sortants.create') }}" 
                       class="inline-flex items-center px-8 py-4 bg-red-900 border border-red-300 text-white font-semibold rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Ajouter un courrier
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

