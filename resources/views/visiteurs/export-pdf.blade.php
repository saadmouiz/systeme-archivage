<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport Visiteurs</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #333; margin: 20px; }
        h1 { font-size: 18px; margin: 0 0 8px; }
        .meta { color: #666; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #d1d5db; padding: 6px 8px; text-align: left; }
        th { background: #f3f4f6; font-size: 10px; text-transform: uppercase; }
    </style>
</head>
<body>
    <h1>Rapport des Visiteurs</h1>
    <div class="meta">
        @if(!empty($annee)) Année {{ $annee }} — @endif
        @if(!empty($mois)) Mois {{ $mois }} — @endif
        @if(!empty($genre)) Genre {{ $genre }} — @endif
        {{ $visiteurs->count() }} visiteur(s) — Généré le {{ date('d/m/Y H:i') }}
    </div>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>CIN</th>
                <th>Genre</th>
                <th>Date / Heure d'arrivée</th>
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
                <tr><td colspan="5" style="text-align:center;">Aucun visiteur</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
