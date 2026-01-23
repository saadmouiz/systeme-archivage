<!DOCTYPE html>
<html>
<head>
    <title>Rapport de Pointages - {{ $mois }}/{{ $annee }}</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            font-size: 8px;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 10px; 
        }
        table, th, td { 
            border: 1px solid #000; 
            padding: 4px; 
        }
        th { 
            background-color: #f2f2f2; 
            text-align: center;
            font-weight: bold;
            font-size: 7px;
        }
        td {
            text-align: center;
            font-size: 7px;
        }
        .header {
            text-align: center;
            margin-bottom: 15px;
        }
        .header h1 {
            margin: 5px 0;
            font-size: 16px;
        }
        .header h2 {
            margin: 5px 0;
            font-size: 12px;
        }
        .employee-name {
            text-align: left;
            font-weight: bold;
            font-size: 7px;
        }
        .statut-present { background-color: #d4edda; }
        .statut-absent { background-color: #f8d7da; }
        .statut-retard { background-color: #fff3cd; }
        .statut-conge { background-color: #cfe2ff; }
        .statut-maladie { background-color: #f5c6cb; }
        .statut-jour_ferie { background-color: #e2e3e5; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Rapport Mensuel de Pointages</h1>
        <h2>{{ Carbon\Carbon::createFromDate($annee, $mois, 1)->locale('fr')->monthName }} {{ $annee }}</h2>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 15%;">Employé</th>
                @foreach($joursDuMois as $jour)
                    <th style="width: {{ 85 / $joursDuMois->count() }}%;">{{ $jour->format('d') }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $employee)
                <tr>
                    <td class="employee-name">{{ $employee->prenom }} {{ $employee->nom }}</td>
                    @foreach($joursDuMois as $jour)
                        @php
                            $pointage = $pointages[$employee->id][$jour->format('Y-m-d')] ?? null;
                            $statutClass = $pointage ? 'statut-' . $pointage->statut : '';
                            $statutLabel = '';
                            if ($pointage) {
                                switch($pointage->statut) {
                                    case 'present': $statutLabel = 'P'; break;
                                    case 'absent': $statutLabel = 'A'; break;
                                    case 'retard': $statutLabel = 'R'; break;
                                    case 'conge': $statutLabel = 'C'; break;
                                    case 'maladie': $statutLabel = 'M'; break;
                                    case 'jour_ferie': $statutLabel = 'JF'; break;
                                    default: $statutLabel = $pointage->statut;
                                }
                            }
                        @endphp
                        <td class="{{ $statutClass }}">
                            @if($pointage)
                                {{ $statutLabel }}
                                @if($pointage->heure_arrivee && $pointage->heure_sortie)
                                    @php
                                        $heureArrivee = is_string($pointage->heure_arrivee) ? $pointage->heure_arrivee : $pointage->heure_arrivee->format('H:i');
                                        $heureSortie = is_string($pointage->heure_sortie) ? $pointage->heure_sortie : $pointage->heure_sortie->format('H:i');
                                    @endphp
                                    <br><small>{{ $heureArrivee }}-{{ $heureSortie }}</small>
                                @endif
                            @else
                                -
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 20px; font-size: 8px;">
        <strong>Légende:</strong>
        <span style="background-color: #d4edda; padding: 2px 5px; margin: 0 5px;">P = Présent</span>
        <span style="background-color: #f8d7da; padding: 2px 5px; margin: 0 5px;">A = Absent</span>
        <span style="background-color: #fff3cd; padding: 2px 5px; margin: 0 5px;">R = Retard</span>
        <span style="background-color: #cfe2ff; padding: 2px 5px; margin: 0 5px;">C = Congé</span>
        <span style="background-color: #f5c6cb; padding: 2px 5px; margin: 0 5px;">M = Maladie</span>
        <span style="background-color: #e2e3e5; padding: 2px 5px; margin: 0 5px;">JF = Jour férié</span>
    </div>
</body>
</html>
