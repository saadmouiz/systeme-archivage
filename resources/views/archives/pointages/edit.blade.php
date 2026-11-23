@extends('layouts.sidebar')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Modifier le pointage</h1>
                <p class="mt-2 text-sm text-gray-600">
                    {{ $employee->prenom }} {{ $employee->nom }} - {{ $pointage->date->format('d/m/Y') }}
                </p>
            </div>
            <div>
                <a href="{{ route('archives.pointages.show', $employee) }}?mois={{ $pointage->date->month }}&annee={{ $pointage->date->year }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-400 focus:ring ring-gray-200 disabled:opacity-25 transition ease-in-out duration-150">
                    Retour à la fiche
                </a>
            </div>
        </div>

        @if(!empty($editLock) && empty($editLock['acquired']))
            <div class="mb-4 px-4 py-3 bg-amber-100 border border-amber-300 text-amber-900 rounded">
                {{ $editLock['message'] }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 px-4 py-3 bg-red-100 border border-red-200 text-red-700 rounded">{{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="mb-4 px-4 py-3 bg-red-100 border border-red-200 text-red-700 rounded">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach 
                </ul>
            </div>
        @endif
                                                         
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <form method="POST" action="{{ route('archives.pointages.update', $pointage) }}">
                @csrf
                @method('PUT')
                
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                            <input type="date" name="date" id="date" value="{{ $pointage->date->format('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-900 focus:ring focus:ring-red-900 focus:ring-opacity-50" required>
                        </div>

                        <div>
                            <label for="statut" class="block text-sm font-medium text-gray-700">Statut</label>
                            <select name="statut" id="statut" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-900 focus:ring focus:ring-red-900 focus:ring-opacity-50" onchange="toggleTimeFields(this)" required>
                                <option value="present" {{ $pointage->statut === 'present' ? 'selected' : '' }}>Présent</option>
                                <option value="absent" {{ $pointage->statut === 'absent' ? 'selected' : '' }}>Absent</option>
                                <option value="retard" {{ $pointage->statut === 'retard' ? 'selected' : '' }}>Retard</option>
                                <option value="conge" {{ $pointage->statut === 'conge' ? 'selected' : '' }}>Congé</option>
                                <option value="maladie" {{ $pointage->statut === 'maladie' ? 'selected' : '' }}>Maladie</option>
                                <option value="jour_ferie" {{ $pointage->statut === 'jour_ferie' ? 'selected' : '' }}>Jour férié</option>
                            </select>
                        </div>

                        <div>
                            <label for="heure_arrivee" class="block text-sm font-medium text-gray-700">Heure d'arrivée</label>
                            <input type="time" name="heure_arrivee" id="heure_arrivee" value="{{ $pointage->heure_arrivee }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-900 focus:ring focus:ring-red-900 focus:ring-opacity-50 time-field" {{ ($pointage->statut !== 'present' && $pointage->statut !== 'retard') ? 'disabled' : '' }}>
                        </div>

                        <div>
                            <label for="heure_sortie" class="block text-sm font-medium text-gray-700">Heure de sortie</label>
                            <input type="time" name="heure_sortie" id="heure_sortie" value="{{ $pointage->heure_sortie }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-900 focus:ring focus:ring-red-900 focus:ring-opacity-50 time-field" {{ ($pointage->statut !== 'present' && $pointage->statut !== 'retard') ? 'disabled' : '' }}>
                        </div>

                        <div class="md:col-span-2">
                            <label for="commentaire" class="block text-sm font-medium text-gray-700">Commentaire</label>
                            <textarea name="commentaire" id="commentaire" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-900 focus:ring focus:ring-red-900 focus:ring-opacity-50">{{ $pointage->commentaire }}</textarea>
                        </div>
                    </div>
                </div>
                
                <div class="px-6 py-4 bg-gray-50 text-right">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-900 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-red-500 disabled:opacity-25 transition ease-in-out duration-150">
                        Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleTimeFields(selectElement) {
        const isPresent = selectElement.value === 'present' || selectElement.value === 'retard';
        const timeFields = document.querySelectorAll('.time-field');
        
        timeFields.forEach(field => {
            field.disabled = !isPresent;
        });
    }
</script>
@push('scripts')
@if(!empty($editLock['acquired']))
<script>
(function () {
    const heartbeatUrl = @json(route('archives.pointages.lock.heartbeat', $pointage));
    const releaseUrl = @json(route('archives.pointages.lock.release', $pointage));
    const csrf = document.querySelector('input[name="_token"]')?.value;
    setInterval(() => {
        fetch(heartbeatUrl, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' }
        }).catch(() => {});
    }, 60000);
    window.addEventListener('beforeunload', () => {
        if (navigator.sendBeacon && csrf) {
            const data = new FormData();
            data.append('_token', csrf);
            navigator.sendBeacon(releaseUrl, data);
        }
    });
})();
</script>
@endif
@endpush
@endsection

