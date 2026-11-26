<!DOCTYPE html>
<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta charset="UTF-8">
    <title>{{ $title }}{{ !empty($annee) ? ' - ' . $annee : '' }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #333; margin: 20px; }
        h1 { font-size: 20px; margin: 0 0 6px; }
        .meta { color: #666; margin-bottom: 18px; }
        table { width: 100%; border-collapse: collapse; table-layout: fixed; }
        th, td { border: 1px solid #d1d5db; padding: 6px 8px; text-align: left; vertical-align: top; word-wrap: break-word; }
        th { background: #f3f4f6; font-size: 10px; text-transform: uppercase; }
        tr:nth-child(even) { background: #f9fafb; }
        .empty { text-align: center; padding: 20px; color: #6b7280; }
        .txt { font-family: DejaVu Sans, sans-serif; }
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
                    <th style="width:12%">N° Arrivée</th>
                    <th style="width:12%">Date arrivée</th>
                    <th style="width:12%">N° Document</th>
                    <th style="width:12%">Date document</th>
                    <th style="width:22%">Expéditeur</th>
                    <th style="width:30%">Description</th>
                @else
                    <th style="width:12%">N° Sortant</th>
                    <th style="width:12%">Date sortie</th>
                    <th style="width:22%">Destinataire</th>
                    <th style="width:22%">Sujet</th>
                    <th style="width:32%">Description</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse($courriers as $courrier)
                <tr>
                    @if($type === 'arrivants')
                        <td class="txt">@pdfText($courrier->numero_arrive)</td>
                        <td>{{ optional($courrier->date_arrive)->format('d/m/Y') }}</td>
                        <td class="txt">@pdfText($courrier->numero_document ?? '-')</td>
                        <td>{{ optional($courrier->date_document)->format('d/m/Y') ?: '-' }}</td>
                        <td class="txt">@pdfText($courrier->expediteur)</td>
                        <td class="txt">@pdfText(\Illuminate\Support\Str::limit((string) $courrier->description, 120))</td>
                    @else
                        <td class="txt">@pdfText($courrier->numero_sortant)</td>
                        <td>{{ optional($courrier->date_sortant)->format('d/m/Y') }}</td>
                        <td class="txt">@pdfText($courrier->destinataire)</td>
                        <td class="txt">@pdfText($courrier->sujet)</td>
                        <td class="txt">@pdfText(\Illuminate\Support\Str::limit((string) $courrier->description, 120))</td>
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
