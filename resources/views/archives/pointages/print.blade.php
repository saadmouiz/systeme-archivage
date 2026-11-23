<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Impression Pointages {{ $mois }}/{{ $annee }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; font-size: 11px; }
        h1 { margin-bottom: 4px; }
        .actions { margin-bottom: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 3px; text-align: center; }
        th { background: #f3f3f3; }
        .name { text-align: left; white-space: nowrap; }
        @media print { .actions { display: none; } }
    </style>
</head>
<body>
    <div class="actions">
        <button onclick="window.print()">Imprimer</button>
        <a href="{{ route('archives.pointages.index', ['mois' => $mois, 'annee' => $annee]) }}">Retour</a>
    </div>
    <h1>Rapport de pointages — {{ $mois }}/{{ $annee }}</h1>
    <table>
        <thead>
            <tr>
                <th class="name">Employé</th>
                @foreach($joursDuMois as $jour)
                    <th>{{ $jour->format('d') }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $employee)
                <tr>
                    <td class="name">{{ $employee->nom }} {{ $employee->prenom }}</td>
                    @foreach($joursDuMois as $jour)
                        @php
                            $p = data_get($pointages, $employee->id . '.' . $jour->format('Y-m-d'));
                            $map = ['present'=>'P','absent'=>'A','retard'=>'R','conge'=>'C','maladie'=>'M','jour_ferie'=>'JF'];
                        @endphp
                        <td>{{ $p ? ($map[$p->statut] ?? substr($p->statut,0,1)) : '-' }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
    <script>window.addEventListener('load', () => setTimeout(() => window.print(), 300));</script>
</body>
</html>
