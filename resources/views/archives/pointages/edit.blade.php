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
                            </select>
                        </div>

                        <div>
                            <label for="heure_arrivee" class="block text-sm font-medium text-gray-700">Heure d'arrivée</label>
                            <input type="time" name="heure_arrivee" id="heure_arrivee" value="{{ $pointage->heure_arrivee }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-900 focus:ring focus:ring-red-900 focus:ring-opacity-50 time-field" {{ $pointage->statut !== 'present' ? 'disabled' : '' }}>
                        </div>

                        <div>
                            <label for="heure_sortie" class="block text-sm font-medium text-gray-700">Heure de sortie</label>
                            <input type="time" name="heure_sortie" id="heure_sortie" value="{{ $pointage->heure_sortie }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-900 focus:ring focus:ring-red-900 focus:ring-opacity-50 time-field" {{ $pointage->statut !== 'present' ? 'disabled' : '' }}>
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
        const isPresent = selectElement.value === 'present';
        const timeFields = document.querySelectorAll('.time-field');
        
        timeFields.forEach(field => {
            field.disabled = !isPresent;
        });
    }
</script>
@endsection

