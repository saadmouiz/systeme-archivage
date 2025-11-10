@extends('layouts.sidebar')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-green-50">
    <div class="container mx-auto px-4 py-12">
        <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-8 shadow-xl border border-white/20">
            <div class="flex items-start justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Détail du Courrier Sortant</h1>
                    <p class="text-gray-600 mt-2">Consultation et actions rapides</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('archives.courriers.sortants.edit', $courrier) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">Modifier</a>
                    <a href="{{ route('archives.courriers.sortants.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">Retour</a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <p class="text-xs uppercase text-gray-500">Numéro sortant</p>
                        <p class="font-semibold text-green-900">{{ $courrier->numero_sortant }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-gray-500">Date sortant</p>
                        <p class="font-medium">{{ $courrier->date_sortant?->format('d/m/Y') }}</p>
                    </div>
                </div>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs uppercase text-gray-500">Destinataire</p>
                        <p class="font-medium">{{ $courrier->destinataire }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-gray-500">Sujet</p>
                        <p class="font-medium whitespace-pre-line">{{ $courrier->sujet }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-gray-500">Description</p>
                        <p class="font-medium whitespace-pre-line">{{ $courrier->description ?? '-' }}</p>
                    </div>
                    @if($courrier->fichier)
                        <div class="pt-2">
                            <a href="{{ route('archives.courriers.sortants.download', $courrier) }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Télécharger le fichier</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


