@extends('layouts.sidebar')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto space-y-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Clôture des exercices annuels</h1>
            <p class="text-sm text-gray-600 mt-1">Figer une année empêche toute modification accidentelle des dossiers / pointages de cet exercice.</p>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 text-green-800">{{ session('success') }}</div>
        @endif

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Clôturer un exercice</h2>
            <form method="POST" action="{{ route('archives.clotures.store') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700">Année</label>
                    <select name="annee" class="mt-1 block w-full border-gray-300 rounded-md" required>
                        @foreach($annees as $a)
                            <option value="{{ $a }}">{{ $a }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Module</label>
                    <select name="module" class="mt-1 block w-full border-gray-300 rounded-md" required>
                        <option value="beneficiaires">Bénéficiaires</option>
                        <option value="pointages">Pointages</option>
                        <option value="all">Tous modules</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Notes</label>
                    <input type="text" name="notes" class="mt-1 block w-full border-gray-300 rounded-md" placeholder="Bilan annuel…">
                </div>
                <button type="submit" class="bg-red-900 text-white px-4 py-2 rounded-md hover:bg-red-800">Clôturer</button>
            </form>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left">Année</th>
                        <th class="px-4 py-3 text-left">Module</th>
                        <th class="px-4 py-3 text-left">Clôturé par</th>
                        <th class="px-4 py-3 text-left">Date</th>
                        <th class="px-4 py-3 text-left">Notes</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clotures as $c)
                        <tr class="border-t">
                            <td class="px-4 py-3 font-medium">{{ $c->annee }}</td>
                            <td class="px-4 py-3">{{ $c->module }}</td>
                            <td class="px-4 py-3">{{ $c->closed_by_name ?? '—' }}</td>
                            <td class="px-4 py-3">{{ optional($c->closed_at)->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-3">{{ $c->notes ?? '—' }}</td>
                            <td class="px-4 py-3 text-right">
                                <form method="POST" action="{{ route('archives.clotures.destroy', $c) }}" onsubmit="return confirm('Rouvrir cet exercice ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-700 hover:underline text-sm">Rouvrir</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-6 text-gray-500">Aucun exercice clôturé.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
