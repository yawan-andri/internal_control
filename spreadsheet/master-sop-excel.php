<?php

require '../config/app.php';
require '../vendor/autoload.php';

$sop_master = select 
                    ("SELECT * FROM tbSOP
                        OUTER APPLY (SELECT TOP 1 KategoriSOP FROM tbSOPKategori kat
                                    WHERE kat.NoSOP = tbSOP.NoSOP
                                    )tbSOPKategori
                    ");
$no = 1;
$cell = 2;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$activeWorksheet = $spreadsheet->getActiveSheet();
$activeWorksheet->setCellValue('A1', 'No');
$activeWorksheet->setCellValue('B1', 'No SOP');
$activeWorksheet->setCellValue('C1', 'Nama SOP');
$activeWorksheet->setCellValue('D1', 'Divisi Main');
$activeWorksheet->setCellValue('E1', 'Kategori SOP');

foreach ($sop_master as $sop_master) {
    $activeWorksheet->setCellValue('A' . $cell, $no++)->getColumnDimension('A')->setAutoSize(true);
    $activeWorksheet->setCellValue('B' . $cell, $sop_master['NoSOP'])->getColumnDimension('B')->setAutoSize(true);
    $activeWorksheet->setCellValue('C' . $cell, $sop_master['NamaSOP'])->getColumnDimension('C')->setAutoSize(true);
    $activeWorksheet->setCellValue('D' . $cell, $sop_master['DivisiMain'])->getColumnDimension('D')->setAutoSize(true);
    $activeWorksheet->setCellValue('E' . $cell, $sop_master['KategoriSOP'])->getColumnDimension('E')->setAutoSize(true);
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

$activeWorksheet->getStyle('A1:E' . $border)->applyFromArray($styleArray);

$writer = new Xlsx($spreadsheet);
$writer->save('Data Master SOP.xlsx');

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheet.sheet');
header('Content-Disposition: attachment;filename="Data Master SOP.xlsx"');
readfile('Data Master SOP.xlsx');
unlink('Data Master SOP.xlsx');
exit;
?>