<?php

namespace App\Support;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExcelExport
{
    public static function assertAvailable(): void
    {
        if (!class_exists(Spreadsheet::class)) {
            abort(503, "L'export Excel est indisponible : le package phpoffice/phpspreadsheet n'est pas installé sur le serveur. Exécutez : composer install --no-dev");
        }
    }

    /**
     * @param  array<int, array<int, string|int|float|null>>  $rows
     */
    public static function download(string $filename, string $sheetTitle, array $headers, array $rows): StreamedResponse
    {
        self::assertAvailable();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle(mb_substr($sheetTitle, 0, 31));

        foreach ($headers as $index => $header) {
            $sheet->setCellValueByColumnAndRow($index + 1, 1, $header);
        }

        $rowNum = 2;
        foreach ($rows as $row) {
            $col = 1;
            foreach ($row as $value) {
                $sheet->setCellValueByColumnAndRow($col, $rowNum, $value);
                $col++;
            }
            $rowNum++;
        }

        foreach (range(1, max(1, count($headers))) as $col) {
            $sheet->getColumnDimensionByColumn($col)->setAutoSize(true);
        }

        return response()->streamDownload(function () use ($spreadsheet) {
            (new Xlsx($spreadsheet))->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
}
