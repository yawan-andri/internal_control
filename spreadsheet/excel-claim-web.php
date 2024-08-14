<?php

require '../config/app.php';
require '../vendor/autoload.php';

$database = $_POST['database'];
$periode = $_POST['periode'];
$namapc = "WIANTORO-CLAIM-WEB";

if ($database == "DESWEB") {
    $unit = "DES";
} else {
    $unit = "STS";
}

$sql = "{call MASTER_DES.dbo.spClaimWeb(?, ?, ?)}";
$stmt = $conn->prepare($sql);
$stmt->bindParam(1, $database, PDO::PARAM_STR);
$stmt->bindParam(2, $periode, PDO::PARAM_STR);
$stmt->bindParam(3, $namapc, PDO::PARAM_STR);

try {
    $stmt->execute();
} catch (PDOException $e) {
    // Handle the exception
    echo "Error: " . $e->getMessage();
}

$claim_web_hasil = select 
                    ("select * from MASTER_DES.dbo.fclaimwebsum('WIANTORO-CLAIM-WEB-TEMP')
                    ORDER BY nomor, nomorsub");

$cell = 2;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$activeWorksheet = $spreadsheet->getActiveSheet();
$activeWorksheet->setCellValue('A1', 'INDIKATOR');
$activeWorksheet->setCellValue('B1', 'JAN');
$activeWorksheet->setCellValue('C1', 'FEB');
$activeWorksheet->setCellValue('D1', 'MAR');
$activeWorksheet->setCellValue('E1', 'APR');
$activeWorksheet->setCellValue('F1', 'MEI');
$activeWorksheet->setCellValue('G1', 'JUN');
$activeWorksheet->setCellValue('H1', 'JUL');
$activeWorksheet->setCellValue('I1', 'AGU');
$activeWorksheet->setCellValue('J1', 'SEP');
$activeWorksheet->setCellValue('K1', 'OKT');
$activeWorksheet->setCellValue('L1', 'NOV');
$activeWorksheet->setCellValue('M1', 'DES');
$activeWorksheet->setCellValue('N1', 'TOTAL S I');
$activeWorksheet->setCellValue('O1', 'TOTAL S II');
$activeWorksheet->setCellValue('P1', 'TOTAL TAHUN');

foreach ($claim_web_hasil as $claim_web) {
    $activeWorksheet->setCellValue('A' . $cell, $claim_web['indikator'])->getColumnDimension('A')->setAutoSize(true);
    $activeWorksheet->setCellValue('B' . $cell, $claim_web['1'])->getColumnDimension('B')->setAutoSize(true);
    $activeWorksheet->setCellValue('C' . $cell, $claim_web['2'])->getColumnDimension('C')->setAutoSize(true);
    $activeWorksheet->setCellValue('D' . $cell, $claim_web['3'])->getColumnDimension('D')->setAutoSize(true);
    $activeWorksheet->setCellValue('E' . $cell, $claim_web['4'])->getColumnDimension('E')->setAutoSize(true);
    $activeWorksheet->setCellValue('F' . $cell, $claim_web['5'])->getColumnDimension('F')->setAutoSize(true);
    $activeWorksheet->setCellValue('G' . $cell, $claim_web['6'])->getColumnDimension('G')->setAutoSize(true);
    $activeWorksheet->setCellValue('H' . $cell, $claim_web['7'])->getColumnDimension('H')->setAutoSize(true);
    $activeWorksheet->setCellValue('I' . $cell, $claim_web['8'])->getColumnDimension('I')->setAutoSize(true);
    $activeWorksheet->setCellValue('J' . $cell, $claim_web['9'])->getColumnDimension('J')->setAutoSize(true);
    $activeWorksheet->setCellValue('K' . $cell, $claim_web['10'])->getColumnDimension('K')->setAutoSize(true);
    $activeWorksheet->setCellValue('L' . $cell, $claim_web['11'])->getColumnDimension('L')->setAutoSize(true);
    $activeWorksheet->setCellValue('M' . $cell, $claim_web['12'])->getColumnDimension('M')->setAutoSize(true);
    $activeWorksheet->setCellValue('N' . $cell, $claim_web['S1'])->getColumnDimension('N')->setAutoSize(true);
    $activeWorksheet->setCellValue('O' . $cell, $claim_web['S2'])->getColumnDimension('O')->setAutoSize(true);
    $activeWorksheet->setCellValue('P' . $cell, $claim_web['TAHUN'])->getColumnDimension('P')->setAutoSize(true);
    $cell++;
}

$styleArray = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
];

$border  = $cell - 1;

$activeWorksheet->getStyle('A1:P' . $border)->applyFromArray($styleArray);

$writer = new Xlsx($spreadsheet);
$writer->save('Claim Web ' . $unit . ' ' . $periode . '.xlsx');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheet.sheet');
header('Content-Disposition: attachment;filename="Claim Web ' . $unit . ' ' . $periode . '.xlsx"');
readfile('Claim Web ' . $unit . ' ' . $periode . '.xlsx');
unlink('Claim Web ' . $unit . ' ' . $periode . '.xlsx');  