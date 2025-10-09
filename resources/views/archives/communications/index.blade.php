@extends('layouts.sidebar')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Archives de Communication</h1>
        <a href="{{ route('archives.communications.create') }}" 
           class="bg-red-900 hover:bg-red-800 text-white font-semibold py-2 px-4 rounded-lg inline-flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nouveau Document
        </a>
    </div>

    @if(session('success'))
        <div class="bg-[#FEE2E2] border border-red-300 text-red-900 px-4 py-3 rounded relative mb-6" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($communications as $type => $documents)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="bg-gray-50 px-4 py-3 border-b">
                    <h2 class="text-xl font-semibold text-gray-800">{{ $type }}</h2>
                </div>
                <div class="p-4">
                    <div class="space-y-4">
                        @foreach($documents as $doc)
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h3 class="font-medium text-gray-900 mb-2">{{ $doc->titre }}</h3>
                                <div class="flex items-center text-sm text-gray-500 mb-2">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ $doc->date_publication->format('d/m/Y') }}
                                </div>
                                <p class="text-gray-600 text-sm mb-3">{{ Str::limit($doc->description, 100) }}</p>
                                
                                <div class="flex items-center text-sm text-gray-500 mb-3">
                                    <span class="bg-red-100 text-red-900 text-xs font-medium px-2.5 py-0.5 rounded">
                                        {{ $doc->format_type }}
                                    </span>
                                </div>

                                <div class="flex justify-between items-center">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('archives.communications.show', $doc) }}" 
                                           class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 rounded-md hover:bg-blue-200 transition-colors text-sm font-medium">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            Voir
                                        </a>
                                        <a href="{{ route('archives.communications.edit', $doc) }}" 
                                           class="inline-flex items-center px-3 py-1 bg-yellow-100 text-yellow-800 rounded-md hover:bg-yellow-200 transition-colors text-sm font-medium">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            Modifier
                                        </a>
                                    </div>
                                    <form action="{{ route('archives.communications.destroy', $doc) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce document ?');"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm text-red-600 hover:text-red-800">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3">
                <p class="text-center text-gray-500">Aucun document de communication trouvé.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
