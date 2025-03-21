<?php
require_once 'functions/koneksi.php';
require 'functions/function_package.php';
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

// Ambil data dari database
$all = getData();

// Debugging: Cek apakah data ada
if (!is_array($all) || empty($all)) {
    die("Tidak ada data untuk diekspor atau terjadi kesalahan.");
}


$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set Header Kolom
$columns = [
    'A' => 'Kode Paket', 
    'B' => 'Nama Paket', 
    'C' => 'Kategori Paket', 
    'D' => 'Jenis Kelamin',
    'E' => 'Harga', 
    'F' => 'Komisi Seller', 
    'G' => 'Deskripsi'
];

foreach ($columns as $col => $name) {
    $sheet->setCellValue($col . '1', $name);
}

// Isi Data
$i = 2;
foreach ($all as $data) {
    $sheet->setCellValue('A' . $i, $data['package_code']); // Pastikan lowercase
    $sheet->setCellValue('B' . $i, $data['package_name']);
    $sheet->setCellValue('C' . $i, $data['category_name']);
    $sheet->setCellValue('D' . $i, $data['gender_name']);
    $sheet->setCellValue('E' . $i, $data['price']);
    $sheet->setCellValue('F' . $i, $data['commission']);
    $sheet->setCellValue('G' . $i, $data['description']);
    $i++;
}

// Set Border & Alignment
$lastRow = $i - 1;
$styleArray = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
        ],
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
    ],
];
$sheet->getStyle("A1:G$lastRow")->applyFromArray($styleArray);

// Set ukuran kolom otomatis
foreach (array_keys($columns) as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Buat judul tabel bold
$sheet->getStyle("A1:G1")->getFont()->setBold(true);

// Set Nama Sheet
$spreadsheet->getActiveSheet()->setTitle('Data Paket');

// Bersihkan output buffer hanya jika aktif
if (ob_get_length()) {
    ob_end_clean();
}

// Set header sebelum output
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Data_Paket.xlsx"');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: public');

// Output ke browser
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
