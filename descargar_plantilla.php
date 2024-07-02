<?php
require 'vendor/autoload.php'; // Asegúrate de que la ruta sea correcta

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Crear una nueva hoja de cálculo
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Agregar encabezados de columna
$sheet->setCellValue('A1', 'Nombre');
$sheet->setCellValue('B1', 'Descripción');
$sheet->setCellValue('C1', 'Precio por Unidad');
$sheet->setCellValue('D1', 'Precio por Caja');
$sheet->setCellValue('E1', 'Total Cajas');
$sheet->setCellValue('F1', 'Unidades por Caja');
$sheet->setCellValue('G1', 'Stock en Tienda');
$sheet->setCellValue('H1', 'Stock en Almacén');
$sheet->setCellValue('I1', 'Categoría');

// Crear y descargar el archivo Excel
$writer = new Xlsx($spreadsheet);
$filename = 'Plantilla_Productos_Por_Cajas.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
exit;
?>
