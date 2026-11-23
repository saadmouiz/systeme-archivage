<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Impression — Visiteurs</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 24px; color: #111; }
        h1 { margin-bottom: 4px; }
        .meta { color: #555; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; font-size: 13px; }
        th { background: #f5f5f5; }
        .actions { margin-bottom: 16px; }
        @media print { .actions { display: none; } }
    </style>
</head>
<body>
    <div class="actions">
        <button onclick="window.print()">Imprimer</button>
        <a href="{{ route('visiteurs.index', request()->only(['annee','mois','genre'])) }}">Retour</a>
    </div>
    <h1>Rapport des Visiteurs</h1>
    <div class="meta">
        @if(request('annee')) Année {{ request('annee') }} — @endif
        @if(request('mois')) Mois {{ request('mois') }} — @endif
        @if(request('genre')) Genre {{ request('genre') }} — @endif
        {{ $visiteurs->count() }} enregistrement(s)
    </div>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>CIN</th>
                <th>Genre</th>
                <th>Arrivée</th>
            </tr>
        </thead>
        <tbody>
            @forelse($visiteurs as $visiteur)
                <tr>
                    <td>{{ $visiteur->nom }}</td>
                    <td>{{ $visiteur->prenom }}</td>
                    <td>{{ $visiteur->cin }}</td>
                    <td>{{ $visiteur->genre ?? '-' }}</td>
                    <td>{{ optional($visiteur->heure_arrivee)->format('d/m/Y H:i') }}</td>
                </tr>
            @empty
                <tr><td colspan="5">Aucun visiteur</td></tr>
            @endforelse
        </tbody>
    </table>
    <script>window.addEventListener('load', () => setTimeout(() => window.print(), 300));</script>
</body>
</html>
