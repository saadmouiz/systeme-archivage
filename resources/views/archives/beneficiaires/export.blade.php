<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques Bénéficiaires - Export</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .header h1 {
            color: #2563eb;
            margin: 0;
            font-size: 28px;
        }
        
        .header p {
            color: #6b7280;
            margin: 5px 0 0 0;
            font-size: 14px;
        }
        
        .section {
            background-color: #fff;
            margin-bottom: 25px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            page-break-inside: avoid;
        }
        
        .section h2 {
            color: #1f2937;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 10px;
            margin-bottom: 20px;
            font-size: 20px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }
        
        .stat-card {
            background-color: #f8fafc;
            padding: 15px;
            border-radius: 6px;
            text-align: center;
            border-left: 4px solid #2563eb;
        }
        
        .stat-card h3 {
            margin: 0 0 5px 0;
            font-size: 14px;
            color: #6b7280;
        }
        
        .stat-card .value {
            font-size: 24px;
            font-weight: bold;
            color: #1f2937;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        
        th, td {
            border: 1px solid #e5e7eb;
            padding: 12px;
            text-align: left;
        }
        
        th {
            background-color: #f3f4f6;
            font-weight: bold;
            color: #374151;
            font-size: 12px;
            text-transform: uppercase;
        }
        
        td {
            font-size: 14px;
        }
        
        .total-row {
            background-color: #f3f4f6;
            font-weight: bold;
            border-top: 2px solid #374151;
        }
        
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .badge-blue {
            background-color: #dbeafe;
            color: #1e40af;
        }
        
        .badge-green {
            background-color: #dcfce7;
            color: #166534;
        }
        
        .badge-red {
            background-color: #fee2e2;
            color: #dc2626;
        }
        
        .badge-pink {
            background-color: #fce7f3;
            color: #be185d;
        }
        
        .badge-indigo {
            background-color: #e0e7ff;
            color: #3730a3;
        }
        
        .badge-purple {
            background-color: #f3e8ff;
            color: #7c3aed;
        }
        
        .chart-placeholder {
            background-color: #f8fafc;
            border: 2px dashed #d1d5db;
            padding: 40px;
            text-align: center;
            border-radius: 8px;
            margin: 20px 0;
        }
        
        .chart-placeholder h3 {
            color: #6b7280;
            margin: 0;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
            padding-top: 15px;
        }

        /* Styles pour le graphique en barres */
        .chart-container {
            margin-top: 20px;
            margin-bottom: 20px;
        }
        
        .bar-chart-container {
            display: flex;
            align-items: flex-end;
            height: 200px;
            padding-left: 30px;
            position: relative;
            border-bottom: 1px solid #ccc;
            padding-bottom: 20px;
        }

        .y-axis {
            position: absolute;
            left: 0;
            bottom: 20px;
            height: 150px;
            display: flex;
            flex-direction: column-reverse;
            justify-content: space-between;
            font-size: 10px;
            color: #666;
            text-align: right;
            width: 25px;
        }

        .y-label {
            height: calc(150px / 9);
            line-height: calc(150px / 9);
            padding-right: 5px;
            border-top: 1px dotted #eee;
            box-sizing: border-box;
        }
        .y-label:first-child {
            border-top: none;
        }

        .bars-wrapper {
            display: flex;
            align-items: flex-end;
            height: 150px;
            flex-grow: 1;
            padding-left: 10px;
            justify-content: space-around;
        }

        .bar-group {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0 5px;
            height: 100%;
            justify-content: flex-end;
            flex-shrink: 0;
        }

        .bar {
            width: 30px;
            margin-bottom: 5px;
            background-color: #ccc;
            min-height: 5px;
        }

        .bar.blue { background-color: #3b82f6; }
        .bar.pink { background-color: #ec4899; }
        .bar.green { background-color: #22c55e; }
        .bar.red { background-color: #ef4444; }

        .bar-group .label {
            font-size: 12px;
            color: #333;
            text-align: center;
            margin-top: 5px;
            white-space: nowrap;
        }

    </style>
</head>
<body>
    <!-- En-tête -->
    <div class="header">
        <h1>Dashboard Bénéficiaires</h1>
        <p>Statistiques et analyses des documents des bénéficiaires</p>
        <p>Généré le {{ date('d/m/Y à H:i') }}</p>
    </div>

    <!-- Statistiques générales -->
    <div class="section">
        <h2>Statistiques Générales</h2>
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Bénéficiaires</h3>
                <div class="value">{{ number_format($totalBeneficiaires) }}</div>
            </div>
            <div class="stat-card">
                <h3>Documents Éducatifs</h3>
                <div class="value">{{ $totauxStats['total_beneficiaires'] ?? 0 }}</div>
            </div>
            <div class="stat-card">
                <h3>Acceptés</h3>
                <div class="value">{{ $totauxStats['accepter'] ?? 0 }}</div>
            </div>
            <div class="stat-card">
                <h3>Refusés</h3>
                <div class="value">{{ $totauxStats['refuser'] ?? 0 }}</div>
            </div>
            <div class="stat-card">
                <h3>Hommes</h3>
                <div class="value">{{ $totauxStats['hommes'] ?? 0 }}</div>
            </div>
            <div class="stat-card">
                <h3>Femmes</h3>
                <div class="value">{{ $totauxStats['femmes'] ?? 0 }}</div>
            </div>
        </div>
    </div>

    <!-- Statistiques détaillées par école -->
    <div class="section">
        <h2>Statistiques Détaillées par École</h2>
        <table>
            <thead>
                <tr>
                    <th>Établissement</th>
                    <th>Candidat</th>
                    <th>Inscrit</th>
                    <th>Refuser</th>
                    <th>Hommes</th>
                    <th>Femmes</th>
                    <th>Association</th>
                    <th>Eps</th>
                </tr>
            </thead>
            <tbody>
                @forelse($statsParEcole as $stat)
                <tr>
                    <td><strong>{{ $stat['etablissement'] }}</strong></td>
                    <td><span class="badge badge-blue">{{ $stat['candidat'] }}</span></td>
                    <td><span class="badge badge-green">{{ $stat['inscrit'] }}</span></td>
                    <td><span class="badge badge-red">{{ $stat['refuser'] }}</span></td>
                    <td><span class="badge badge-blue">{{ $stat['hommes'] }}</span></td>
                    <td><span class="badge badge-pink">{{ $stat['femmes'] }}</span></td>
                    <td><span class="badge badge-indigo">{{ $stat['association'] }}</span></td>
                    <td><span class="badge badge-purple">{{ $stat['eps'] }}</span></td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align: center; color: #6b7280;">
                        Aucune donnée disponible pour les documents éducatifs
                    </td>
                </tr>
                @endforelse
                
                @if($statsParEcole->count() > 0)
                <tr class="total-row">
                    <td><strong>TOTAL</strong></td>
                    <td><span class="badge badge-blue">{{ $totauxStats['candidat'] ?? 0 }}</span></td>
                    <td><span class="badge badge-green">{{ $totauxStats['inscrit'] ?? 0 }}</span></td>
                    <td><span class="badge badge-red">{{ $totauxStats['refuser'] ?? 0 }}</span></td>
                    <td><span class="badge badge-blue">{{ $totauxStats['hommes'] ?? 0 }}</span></td>
                    <td><span class="badge badge-pink">{{ $totauxStats['femmes'] ?? 0 }}</span></td>
                    <td><span class="badge badge-indigo">{{ $totauxStats['association'] ?? 0 }}</span></td>
                    <td><span class="badge badge-purple">{{ $totauxStats['eps'] ?? 0 }}</span></td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Répartition par Genre et Status -->
    <div class="section">
        <h2>Répartition par Genre et Status</h2>
        <div class="chart-container">
            <div class="bar-chart-container">
                <!-- Y-axis -->
                <div class="y-axis">
                    <div class="y-label">9</div>
                    <div class="y-label">8</div>
                    <div class="y-label">7</div>
                    <div class="y-label">6</div>
                    <div class="y-label">5</div>
                    <div class="y-label">4</div>
                    <div class="y-label">3</div>
                    <div class="y-label">2</div>
                    <div class="y-label">1</div>
                    <div class="y-label">0</div>
                </div>
                
                <!-- Bars -->
                <div class="bars-wrapper">
                    <div class="bar-group">
                        <div class="bar blue" style="height: {{ (($totauxStats['hommes'] ?? 0) / 9) * 150 }}px;"></div>
                        <div class="label">Hommes</div>
                    </div>
                    <div class="bar-group">
                        <div class="bar pink" style="height: {{ (($totauxStats['femmes'] ?? 0) / 9) * 150 }}px;"></div>
                        <div class="label">Femmes</div>
                    </div>
                    <div class="bar-group">
                        <div class="bar green" style="height: {{ (($totauxStats['accepter'] ?? 0) / 9) * 150 }}px;"></div>
                        <div class="label">Accepter</div>
                    </div>
                    <div class="bar-group">
                        <div class="bar red" style="height: {{ (($totauxStats['refuser'] ?? 0) / 9) * 150 }}px;"></div>
                        <div class="label">Refuser</div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Répartition par Type de Document -->
    <div class="section">
        <h2>Répartition par Type de Document</h2>
        <table>
            <thead>
                <tr>
                    <th>Type de Document</th>
                    <th>Nombre</th>
                    <th>Pourcentage</th>
                </tr>
            </thead>
            <tbody>
                @foreach($beneficiairesParType as $type => $count)
                <tr>
                    <td>{{ $type }}</td>
                    <td><span class="badge badge-blue">{{ $count }}</span></td>
                    <td>{{ $totalBeneficiaires > 0 ? round(($count / $totalBeneficiaires) * 100, 1) : 0 }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pied de page -->
    <div class="footer">
        <p>Document généré automatiquement par le système de gestion des archives</p>
        <p>© {{ date('Y') }} - Tous droits réservés</p>
    </div>
</body>
</html>
