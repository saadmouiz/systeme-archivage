<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Bénéficiaires</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #e5e7eb;
            padding: 25px 0 20px 0;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        
        .logo {
            width: 200px;
            height: 120px;
            margin: 0 auto 20px;
            display: block;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            object-fit: contain;
        }
        
        .title {
            font-size: 28px;
            font-weight: bold;
            color: #1f2937;
            margin: 0;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }
        
        .subtitle {
            font-size: 16px;
            color: #4b5563;
            margin-top: 8px;
            font-weight: 500;
        }
        
        .date {
            font-size: 12px;
            color: #6b7280;
            margin-top: 12px;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 6px 12px;
            border-radius: 6px;
            display: inline-block;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        
        th {
            background-color: #f3f4f6;
            color: #374151;
            font-weight: bold;
            padding: 8px;
            text-align: left;
            border: 1px solid #d1d5db;
            font-size: 10px;
        }
        
        td {
            padding: 8px;
            border: 1px solid #d1d5db;
            font-size: 10px;
        }
        
        tr:nth-child(even) {
            background-color: #f9fafb;
        }
        
        .type-employe {
            background-color: #dbeafe;
            color: #1e40af;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        
        .type-etudiant {
            background-color: #dcfce7;
            color: #166534;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        
        .stats {
            margin-top: 25px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            padding: 20px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }
        
        .stat-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 16px;
            background-color: #ffffff;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            transition: all 0.2s ease;
        }
        
        .stat-item:hover {
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        }
        
        .stat-label {
            font-size: 11px;
            font-weight: 600;
            color: #374151;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .stat-number {
            font-size: 16px;
            font-weight: 700;
            color: #1f2937;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            padding: 4px 8px;
            border-radius: 6px;
            background-color: #f0f9ff;
            border: 1px solid #bfdbfe;
        }
        
        .stat-icon {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 8px;
            display: inline-block;
        }
        
        .stat-icon.total { background-color: #3b82f6; }
        .stat-icon.filles { background-color: #ec4899; }
        .stat-icon.garcons { background-color: #10b981; }
        
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #9ca3af;
            border-top: 1px solid #e5e7eb;
            padding-top: 15px;
        }
    </style>
</head>
<body>
    <!-- En-tête -->
    <div class="header">
        <img src="{{ public_path('asset/hhh.jpeg') }}" alt="Logo Association" class="logo">
        <h1 class="title">Liste des Bénéficiaires</h1>
    </div>

    <!-- Tableau -->
    <table>
        <thead>
            <tr>
                <th style="width: 8%;">ID</th>
                <th style="width: 25%;">Nom Complet</th>
                <th style="width: 12%;">Type</th>
                <th style="width: 15%;">Ville</th>
                <th style="width: 15%;">Filière</th>
                <th style="width: 15%;">École</th>
                <th style="width: 15%;">Domaine</th>
            </tr>
        </thead>
        <tbody>
            @forelse($beneficiaires as $beneficiaire)
                <tr>
                    <td>{{ $beneficiaire['id'] }}</td>
                    <td>{{ $beneficiaire['nom_complet'] }}</td>
                    <td>
                        <span class="{{ $beneficiaire['type'] === 'Employé' ? 'type-employe' : 'type-etudiant' }}">
                            {{ $beneficiaire['type'] }}
                        </span>
                    </td>
                    <td>{{ $beneficiaire['ville'] }}</td>
                    <td>{{ $beneficiaire['filiere'] }}</td>
                    <td>{{ $beneficiaire['ecole'] ?? '-' }}</td>
                    <td>{{ $beneficiaire['domaine'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px; color: #6b7280;">
                        Aucun bénéficiaire trouvé
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Statistiques -->
    <div class="stats">
        <div class="stat-item">
            <div class="stat-label">
                <span class="stat-icon total"></span>Total
            </div>
            <div class="stat-number">{{ $total }}</div>
        </div>
        <div class="stat-item">
            <div class="stat-label">
                <span class="stat-icon filles"></span>Filles
            </div>
            <div class="stat-number">{{ $totalFilles }}</div>
        </div>
        <div class="stat-item">
            <div class="stat-label">
                <span class="stat-icon garcons"></span>Garçons
            </div>
            <div class="stat-number">{{ $totalGarcons }}</div>
        </div>
    </div>

    <!-- Pied de page -->
    <div class="footer">
    </div>
</body>
</html>
