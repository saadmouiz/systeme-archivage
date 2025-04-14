<!-- resources/views/archives/pointages/pdf_export.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Pointages - {{ $mois }}/{{ $annee }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 20px; 
        }
        table, th, td { 
            border: 1px solid #000; 
            padding: 8px; 
        }
        th { 
            background-color: #f2f2f2; 
            text-align: left; 
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Rapport de Pointages</h1>
        <h2>{{ $mois }}/{{ $annee }}</h2>
    </div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Employé</th>
                <th>Statut</th>
                <th>Heure Arrivée</th>
                <th>Heure Sortie</th>
                <th>Commentaire</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pointages as $pointage)
            <tr>
                <td>{{ $pointage->date->format('d/m/Y') }}</td>
                <td>{{ $pointage->employee->nom }} {{ $pointage->employee->prenom }}</td>
                <td>{{ $pointage->statut }}</td>
                <td>{{ $pointage->heure_arrivee ? $pointage->heure_arrivee->format('H:i') : 'N/A' }}</td>
                <td>{{ $pointage->heure_sortie ? $pointage->heure_sortie->format('H:i') : 'N/A' }}</td>
                <td>{{ $pointage->commentaire ?? 'Aucun' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>