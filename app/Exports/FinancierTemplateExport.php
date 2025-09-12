<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class FinancierTemplateExport
{
    public function export()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Définir les en-têtes
        $headers = [
            'A1' => 'Date',
            'B1' => 'Description',
            'C1' => 'Référence',
            'D1' => 'Montant (DH)',
            'E1' => 'Notes',
            'F1' => 'Statut'
        ];
        
        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }
        
        // Données d'exemple
        $exampleData = [
            ['2025-01-15', 'Achat fournitures de bureau', 'FAC-2025-001', 1500.00, 'Fournitures de bureau pour le mois de janvier', 'Payé'],
            ['', '', '', '', '', ''],
            ['', '', '', '', '', ''],
            ['', '', '', '', '', ''],
            ['', '', '', '', '', ''],
            ['', '', '', '', '', ''],
            ['', '', '', '', '', ''],
            ['', '', '', '', '', ''],
            ['', '', '', '', '', ''],
            ['', '', '', '', '', ''],
        ];
        
        // Ajouter les données d'exemple
        $row = 2;
        foreach ($exampleData as $data) {
            $col = 'A';
            foreach ($data as $value) {
                $sheet->setCellValue($col . $row, $value);
                $col++;
            }
            $row++;
        }
        
        // Style des en-têtes
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4472C4']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ];
        
        $sheet->getStyle('A1:F1')->applyFromArray($headerStyle);
        
        // Largeur des colonnes
        $sheet->getColumnDimension('A')->setWidth(15); // Date
        $sheet->getColumnDimension('B')->setWidth(30); // Description
        $sheet->getColumnDimension('C')->setWidth(20); // Référence
        $sheet->getColumnDimension('D')->setWidth(15); // Montant
        $sheet->getColumnDimension('E')->setWidth(40); // Notes
        $sheet->getColumnDimension('F')->setWidth(15); // Statut
        
        // Style des cellules de données
        $dataStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'CCCCCC']
                ]
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER
            ]
        ];
        
        $sheet->getStyle('A2:F11')->applyFromArray($dataStyle);
        
        // Alignement spécifique pour les colonnes
        $sheet->getStyle('A2:A11')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Date
        $sheet->getStyle('D2:D11')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT); // Montant
        $sheet->getStyle('F2:F11')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Statut
        
        return $spreadsheet;
    }
}
