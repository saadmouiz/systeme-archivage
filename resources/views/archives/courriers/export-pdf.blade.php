<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}{{ !empty($annee) ? ' - ' . $annee : '' }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #333; margin: 20px; }
        h1 { font-size: 20px; margin: 0 0 6px; }
        .meta { color: #666; margin-bottom: 18px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #d1d5db; padding: 6px 8px; text-align: left; }
        th { background: #f3f4f6; font-size: 10px; text-transform: uppercase; }
        tr:nth-child(even) { background: #f9fafb; }
        .empty { text-align: center; padding: 20px; color: #6b7280; }
    </style>
</head>
<body>
    <h1>{{ $title }}</h1>
    <div class="meta">
        @if(!empty($annee)) Année {{ $annee }} — @endif
        Généré le {{ date('d/m/Y H:i') }} — {{ $courriers->count() }} enregistrement(s)
    </div>

    <table>
        <thead>
            <tr>
                @if($type === 'arrivants')
                    <th>N° Arrivée</th>
                    <th>Date arrivée</th>
                    <th>N° Document</th>
                    <th>Date document</th>
                    <th>Expéditeur</th>
                    <th>Description</th>
                @else
                    <th>N° Sortant</th>
                    <th>Date sortie</th>
                    <th>Destinataire</th>
                    <th>Sujet</th>
                    <th>Description</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse($courriers as $courrier)
                <tr>
                    @if($type === 'arrivants')
                        <td>{{ $courrier->numero_arrive }}</td>
                        <td>{{ optional($courrier->date_arrive)->format('d/m/Y') }}</td>
                        <td>{{ $courrier->numero_document ?? '-' }}</td>
                        <td>{{ optional($courrier->date_document)->format('d/m/Y') ?: '-' }}</td>
                        <td>{{ $courrier->expediteur }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($courrier->description, 80) }}</td>
                    @else
                        <td>{{ $courrier->numero_sortant }}</td>
                        <td>{{ optional($courrier->date_sortant)->format('d/m/Y') }}</td>
                        <td>{{ $courrier->destinataire }}</td>
                        <td>{{ $courrier->sujet }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($courrier->description, 80) }}</td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="empty">Aucun courrier trouvé</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
