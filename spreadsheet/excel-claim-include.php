<?php

require '../config/app.php';
require '../vendor/autoload.php';

$database = $_POST['database'];
$periode = $_POST['periode'];
$namapc = "WIANTORO-CLAIM-WEB";
$trigger = "spClaimWebAsuransi2";

if ($database == "DESWEB") {
    $unit = "DES";
} else {
    $unit = "STS";
}

$sql = "{call MASTER_DES.dbo.spClaimWebMaster(?, ?, ?, ?)}";
$stmt = $conn->prepare($sql);
$stmt->bindParam(1, $database, PDO::PARAM_STR);
$stmt->bindParam(2, $periode, PDO::PARAM_STR);
$stmt->bindParam(3, $namapc, PDO::PARAM_STR);
$stmt->bindParam(4, $trigger, PDO::PARAM_STR);

try {
    $stmt->execute();
} catch (PDOException $e) {
    // Handle the exception
    echo "Error: " . $e->getMessage();
}

$cw_asuransi_1 = select ("select * from MASTER_DES.dbo.ClaimWebAsuransiV1('WIANTORO-CLAIM-WEB') ORDER BY nomor ASC");

$cw_asuransi_2 = select ("select * from MASTER_DES.dbo.ClaimWebAsuransiV2('WIANTORO-CLAIM-WEB') ORDER BY nomor ASC");

$cw_asuransi_3 = select ("select * from MASTER_DES.dbo.ClaimWebAsuransiV3('WIANTORO-CLAIM-WEB') ORDER BY nomor ASC");

$cw_asuransi_4 = select ("select * from MASTER_DES.dbo.ClaimWebAsuransiV4('WIANTORO-CLAIM-WEB') ORDER BY nomor ASC");


$cell = 5;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$ClaimWebAsuransi = $spreadsheet->getActiveSheet();

$ClaimWebAsuransi->setCellValue('A1', 'VERSI 1');
$ClaimWebAsuransi->setCellValue('B1', 'ASURANSI INCLUDE ' . $unit . '');
$ClaimWebAsuransi->setCellValue('B2', 'UPDATE ' . date("Y-m-d") . '');

$ClaimWebAsuransi->setCellValue('A4', 'INDIKATOR');
$ClaimWebAsuransi->setCellValue('B4', 'JAN');
$ClaimWebAsuransi->setCellValue('C4', 'FEB');
$ClaimWebAsuransi->setCellValue('D4', 'MAR');
$ClaimWebAsuransi->setCellValue('E4', 'APR');
$ClaimWebAsuransi->setCellValue('F4', 'MEI');
$ClaimWebAsuransi->setCellValue('G4', 'JUN');
$ClaimWebAsuransi->setCellValue('H4', 'JUL');
$ClaimWebAsuransi->setCellValue('I4', 'AGU');
$ClaimWebAsuransi->setCellValue('J4', 'SEP');
$ClaimWebAsuransi->setCellValue('K4', 'OKT');
$ClaimWebAsuransi->setCellValue('L4', 'NOV');
$ClaimWebAsuransi->setCellValue('M4', 'DES');


foreach ($cw_asuransi_1 as $cw_asuransi_1) {
    $ClaimWebAsuransi->setCellValue('A' . $cell, $cw_asuransi_1['Indikator'])->getColumnDimension('A')->setAutoSize(true);
    $ClaimWebAsuransi->setCellValue('B' . $cell, $cw_asuransi_1['1'])->getColumnDimension('B')->setAutoSize(true);
    $ClaimWebAsuransi->setCellValue('C' . $cell, $cw_asuransi_1['2'])->getColumnDimension('C')->setAutoSize(true);
    $ClaimWebAsuransi->setCellValue('D' . $cell, $cw_asuransi_1['3'])->getColumnDimension('D')->setAutoSize(true);
    $ClaimWebAsuransi->setCellValue('E' . $cell, $cw_asuransi_1['4'])->getColumnDimension('E')->setAutoSize(true);
    $ClaimWebAsuransi->setCellValue('F' . $cell, $cw_asuransi_1['5'])->getColumnDimension('F')->setAutoSize(true);
    $ClaimWebAsuransi->setCellValue('G' . $cell, $cw_asuransi_1['6'])->getColumnDimension('G')->setAutoSize(true);
    $ClaimWebAsuransi->setCellValue('H' . $cell, $cw_asuransi_1['7'])->getColumnDimension('H')->setAutoSize(true);
    $ClaimWebAsuransi->setCellValue('I' . $cell, $cw_asuransi_1['8'])->getColumnDimension('I')->setAutoSize(true);
    $ClaimWebAsuransi->setCellValue('J' . $cell, $cw_asuransi_1['9'])->getColumnDimension('J')->setAutoSize(true);
    $ClaimWebAsuransi->setCellValue('K' . $cell, $cw_asuransi_1['10'])->getColumnDimension('K')->setAutoSize(true);
    $ClaimWebAsuransi->setCellValue('L' . $cell, $cw_asuransi_1['11'])->getColumnDimension('L')->setAutoSize(true);
    $ClaimWebAsuransi->setCellValue('M' . $cell, $cw_asuransi_1['12'])->getColumnDimension('M')->setAutoSize(true);
    $cell++;
}

    $cell++;
    $ClaimWebAsuransi->setCellValue('A' . $cell, 'VERSI 2');
    $ClaimWebAsuransi->setCellValue('B' . $cell, 'ASURANSI INCLUDE ' . $unit . '');
    
    $cell++;
    $ClaimWebAsuransi->setCellValue('B' . $cell, 'UPDATE ' . date("Y-m-d") . '');

    $cell = $cell + 2;
    $ClaimWebAsuransi->setCellValue('A' . $cell, 'INDIKATOR');
    $ClaimWebAsuransi->setCellValue('B'  . $cell, 'JAN');
    $ClaimWebAsuransi->setCellValue('C'  . $cell, 'FEB');
    $ClaimWebAsuransi->setCellValue('D'  . $cell, 'MAR');
    $ClaimWebAsuransi->setCellValue('E'  . $cell, 'APR');
    $ClaimWebAsuransi->setCellValue('F'  . $cell, 'MEI');
    $ClaimWebAsuransi->setCellValue('G'  . $cell, 'JUN');
    $ClaimWebAsuransi->setCellValue('H'  . $cell, 'JUL');
    $ClaimWebAsuransi->setCellValue('I'  . $cell, 'AGU');
    $ClaimWebAsuransi->setCellValue('J'  . $cell, 'SEP');
    $ClaimWebAsuransi->setCellValue('K'  . $cell, 'OKT');
    $ClaimWebAsuransi->setCellValue('L'  . $cell, 'NOV');
    $ClaimWebAsuransi->setCellValue('M'  . $cell, 'DES');

    $cell++;

foreach ($cw_asuransi_2 as $cw_asuransi_2) {
    $ClaimWebAsuransi->setCellValue('A' . $cell, $cw_asuransi_2['Indikator'])->getColumnDimension('A')->setAutoSize(true);
    $ClaimWebAsuransi->setCellValue('B' . $cell, $cw_asuransi_2['1'])->getColumnDimension('B')->setAutoSize(true);
    $ClaimWebAsuransi->setCellValue('C' . $cell, $cw_asuransi_2['2'])->getColumnDimension('C')->setAutoSize(true);
    $ClaimWebAsuransi->setCellValue('D' . $cell, $cw_asuransi_2['3'])->getColumnDimension('D')->setAutoSize(true);
    $ClaimWebAsuransi->setCellValue('E' . $cell, $cw_asuransi_2['4'])->getColumnDimension('E')->setAutoSize(true);
    $ClaimWebAsuransi->setCellValue('F' . $cell, $cw_asuransi_2['5'])->getColumnDimension('F')->setAutoSize(true);
    $ClaimWebAsuransi->setCellValue('G' . $cell, $cw_asuransi_2['6'])->getColumnDimension('G')->setAutoSize(true);
    $ClaimWebAsuransi->setCellValue('H' . $cell, $cw_asuransi_2['7'])->getColumnDimension('H')->setAutoSize(true);
    $ClaimWebAsuransi->setCellValue('I' . $cell, $cw_asuransi_2['8'])->getColumnDimension('I')->setAutoSize(true);
    $ClaimWebAsuransi->setCellValue('J' . $cell, $cw_asuransi_2['9'])->getColumnDimension('J')->setAutoSize(true);
    $ClaimWebAsuransi->setCellValue('K' . $cell, $cw_asuransi_2['10'])->getColumnDimension('K')->setAutoSize(true);
    $ClaimWebAsuransi->setCellValue('L' . $cell, $cw_asuransi_2['11'])->getColumnDimension('L')->setAutoSize(true);
    $ClaimWebAsuransi->setCellValue('M' . $cell, $cw_asuransi_2['12'])->getColumnDimension('M')->setAutoSize(true);
    $cell++;
}

    $cell++;
    $ClaimWebAsuransi->setCellValue('A' . $cell, 'VERSI 3');
    $ClaimWebAsuransi->setCellValue('B' . $cell, 'ASURANSI INCLUDE ' . $unit . '');
    
    $cell++;
    $ClaimWebAsuransi->setCellValue('B' . $cell, 'UPDATE ' . date("Y-m-d") . '');

    $cell = $cell + 2;
    $ClaimWebAsuransi->setCellValue('A' . $cell, 'INDIKATOR');
    $ClaimWebAsuransi->setCellValue('B'  . $cell, 'JAN');
    $ClaimWebAsuransi->setCellValue('C'  . $cell, 'FEB');
    $ClaimWebAsuransi->setCellValue('D'  . $cell, 'MAR');
    $ClaimWebAsuransi->setCellValue('E'  . $cell, 'APR');
    $ClaimWebAsuransi->setCellValue('F'  . $cell, 'MEI');
    $ClaimWebAsuransi->setCellValue('G'  . $cell, 'JUN');
    $ClaimWebAsuransi->setCellValue('H'  . $cell, 'JUL');
    $ClaimWebAsuransi->setCellValue('I'  . $cell, 'AGU');
    $ClaimWebAsuransi->setCellValue('J'  . $cell, 'SEP');
    $ClaimWebAsuransi->setCellValue('K'  . $cell, 'OKT');
    $ClaimWebAsuransi->setCellValue('L'  . $cell, 'NOV');
    $ClaimWebAsuransi->setCellValue('M'  . $cell, 'DES');

    $cell++;

foreach ($cw_asuransi_3 as $cw_asuransi_3) {
    $ClaimWebAsuransi->setCellValue('A' . $cell, $cw_asuransi_3['Indikator'])->getColumnDimension('A')->setAutoSize(true);
    $ClaimWebAsuransi->setCellValue('B' . $cell, $cw_asuransi_3['1'])->getColumnDimension('B')->setAutoSize(true);
    $ClaimWebAsuransi->setCellValue('C' . $cell, $cw_asuransi_3['2'])->getColumnDimension('C')->setAutoSize(true);
    $ClaimWebAsuransi->setCellValue('D' . $cell, $cw_asuransi_3['3'])->getColumnDimension('D')->setAutoSize(true);
    $ClaimWebAsuransi->setCellValue('E' . $cell, $cw_asuransi_3['4'])->getColumnDimension('E')->setAutoSize(true);
    $ClaimWebAsuransi->setCellValue('F' . $cell, $cw_asuransi_3['5'])->getColumnDimension('F')->setAutoSize(true);
    $ClaimWebAsuransi->setCellValue('G' . $cell, $cw_asuransi_3['6'])->getColumnDimension('G')->setAutoSize(true);
    $ClaimWebAsuransi->setCellValue('H' . $cell, $cw_asuransi_3['7'])->getColumnDimension('H')->setAutoSize(true);
    $ClaimWebAsuransi->setCellValue('I' . $cell, $cw_asuransi_3['8'])->getColumnDimension('I')->setAutoSize(true);
    $ClaimWebAsuransi->setCellValue('J' . $cell, $cw_asuransi_3['9'])->getColumnDimension('J')->setAutoSize(true);
    $ClaimWebAsuransi->setCellValue('K' . $cell, $cw_asuransi_3['10'])->getColumnDimension('K')->setAutoSize(true);
    $ClaimWebAsuransi->setCellValue('L' . $cell, $cw_asuransi_3['11'])->getColumnDimension('L')->setAutoSize(true);
    $ClaimWebAsuransi->setCellValue('M' . $cell, $cw_asuransi_3['12'])->getColumnDimension('M')->setAutoSize(true);
    $cell++;
}


    $cell++;
    $ClaimWebAsuransi->setCellValue('A' . $cell, 'VERSI 4');
    $ClaimWebAsuransi->setCellValue('B' . $cell, 'ASURANSI INCLUDE ' . $unit . '');
    
    $cell++;
    $ClaimWebAsuransi->setCellValue('B' . $cell, 'UPDATE ' . date("Y-m-d") . '');

    $cell = $cell + 2;
    $ClaimWebAsuransi->setCellValue('A' . $cell, 'INDIKATOR');
    $ClaimWebAsuransi->setCellValue('B'  . $cell, 'JAN');
    $ClaimWebAsuransi->setCellValue('C'  . $cell, 'FEB');
    $ClaimWebAsuransi->setCellValue('D'  . $cell, 'MAR');
    $ClaimWebAsuransi->setCellValue('E'  . $cell, 'APR');
    $ClaimWebAsuransi->setCellValue('F'  . $cell, 'MEI');
    $ClaimWebAsuransi->setCellValue('G'  . $cell, 'JUN');
    $ClaimWebAsuransi->setCellValue('H'  . $cell, 'JUL');
    $ClaimWebAsuransi->setCellValue('I'  . $cell, 'AGU');
    $ClaimWebAsuransi->setCellValue('J'  . $cell, 'SEP');
    $ClaimWebAsuransi->setCellValue('K'  . $cell, 'OKT');
    $ClaimWebAsuransi->setCellValue('L'  . $cell, 'NOV');
    $ClaimWebAsuransi->setCellValue('M'  . $cell, 'DES');

    $cell++;

foreach ($cw_asuransi_4 as $cw_asuransi_4) {
    $ClaimWebAsuransi->setCellValue('A' . $cell, $cw_asuransi_4['Indikator'])->getColumnDimension('A')->setAutoSize(true);
    $ClaimWebAsuransi->setCellValue('B' . $cell, $cw_asuransi_4['1'])->getColumnDimension('B')->setAutoSize(true);
    $ClaimWebAsuransi->setCellValue('C' . $cell, $cw_asuransi_4['2'])->getColumnDimension('C')->setAutoSize(true);
    $ClaimWebAsuransi->setCellValue('D' . $cell, $cw_asuransi_4['3'])->getColumnDimension('D')->setAutoSize(true);
    $ClaimWebAsuransi->setCellValue('E' . $cell, $cw_asuransi_4['4'])->getColumnDimension('E')->setAutoSize(true);
    $ClaimWebAsuransi->setCellValue('F' . $cell, $cw_asuransi_4['5'])->getColumnDimension('F')->setAutoSize(true);
    $ClaimWebAsuransi->setCellValue('G' . $cell, $cw_asuransi_4['6'])->getColumnDimension('G')->setAutoSize(true);
    $ClaimWebAsuransi->setCellValue('H' . $cell, $cw_asuransi_4['7'])->getColumnDimension('H')->setAutoSize(true);
    $ClaimWebAsuransi->setCellValue('I' . $cell, $cw_asuransi_4['8'])->getColumnDimension('I')->setAutoSize(true);
    $ClaimWebAsuransi->setCellValue('J' . $cell, $cw_asuransi_4['9'])->getColumnDimension('J')->setAutoSize(true);
    $ClaimWebAsuransi->setCellValue('K' . $cell, $cw_asuransi_4['10'])->getColumnDimension('K')->setAutoSize(true);
    $ClaimWebAsuransi->setCellValue('L' . $cell, $cw_asuransi_4['11'])->getColumnDimension('L')->setAutoSize(true);
    $ClaimWebAsuransi->setCellValue('M' . $cell, $cw_asuransi_4['12'])->getColumnDimension('M')->setAutoSize(true);
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

// $ClaimWebAsuransi->getStyle('A5:P' . $border)->applyFromArray($styleArray);

$writer = new Xlsx($spreadsheet);
$writer->save('Claim Web Asuransi Include' . $unit . ' ' . $periode . '.xlsx');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheet.sheet');
header('Content-Disposition: attachment;filename="Claim Web Asuransi Include' . $unit . ' ' . $periode . '.xlsx"');
readfile('Claim Web Asuransi Include' . $unit . ' ' . $periode . '.xlsx');
unlink('Claim Web Asuransi Include' . $unit . ' ' . $periode . '.xlsx');  