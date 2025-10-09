@extends('layouts.sidebar')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">{{ ucfirst($category) }}</h1>
            <a href="{{ route('archives.index') }}" class="text-red-900 hover:underline">
                Retour aux archives
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            @forelse($archives as $archive)
                <div class="border rounded-lg p-4 mb-4 last:mb-0">
                    <h3 class="font-medium text-lg">{{ $archive->title }}</h3>
                    <p class="text-sm text-gray-600 mt-1">{{ $archive->sub_category }}</p>
                    <p class="mt-2">{{ $archive->description }}</p>
                    
                    @if($archive->files)
                        <div class="mt-3 flex flex-wrap gap-2">
                            @foreach($archive->files as $file)
                                <a href="{{ Storage::url($file) }}" 
                                   class="inline-flex items-center px-3 py-1 rounded-full bg-red-100 text-red-900 hover:bg-red-900"
                                   target="_blank">
                                    Document {{ $loop->iteration }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            @empty
                <div class="text-center py-12 text-gray-500">
                   
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection 