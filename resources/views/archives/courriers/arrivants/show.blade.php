Route [courriers.arrivants.index] not defined.

@extends('layouts.sidebar')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-blue-50">
    <div class="container mx-auto px-4 py-12">
        <div class="bg-white/80 backdrop-blur-sm rounded-3xl p-8 shadow-xl border border-white/20">
            <div class="flex items-start justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Détail du Courrier Entrant</h1>
                    <p class="text-gray-600 mt-2">Consultation et actions rapides</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('archives.courriers.arrivants.edit', $courrier) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">Modifier</a>
                    <a href="{{ route('archives.courriers.arrivants.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">Retour</a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <p class="text-xs uppercase text-gray-500">Numéro arrivant</p>
                        <p class="font-semibold text-blue-900">{{ $courrier->numero_arrive }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-gray-500">Date d'arrivée</p>
                        <p class="font-medium">{{ $courrier->date_arrive?->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-gray-500">Numéro du document</p>
                        <p class="font-medium">{{ $courrier->numero_document ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-gray-500">Date du document</p>
                        <p class="font-medium">{{ $courrier->date_document?->format('d/m/Y') ?? '-' }}</p>
                    </div>
                </div>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs uppercase text-gray-500">Expéditeur</p>
                        <p class="font-medium">{{ $courrier->expediteur }}</p>
                    </div>
                    <div class="flex gap-2">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $courrier->pieces_jointes ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">Pièces jointes: {{ $courrier->pieces_jointes_text }}</span>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $courrier->renvoi ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800' }}">Renvoi: {{ $courrier->renvoi_text }}</span>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $courrier->signature_recu ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">Signature: {{ $courrier->signature_recu_text }}</span>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-gray-500">Description</p>
                        <p class="font-medium whitespace-pre-line">{{ $courrier->description ?? '-' }}</p>
                    </div>
                    @if($courrier->fichier)
                        <div class="pt-2">
                            <a href="{{ route('archives.courriers.arrivants.download', $courrier) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Télécharger le fichier</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection


