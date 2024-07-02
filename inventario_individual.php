<?php
include 'db.php';
require 'vendor/autoload.php'; // Asegúrate de que la ruta sea correcta
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

// Función para exportar a Excel
function exportToExcel($conn) {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Agregar encabezados de columna
    $sheet->setCellValue('A1', 'Código');
    $sheet->setCellValue('B1', 'Nombre');
    $sheet->setCellValue('C1', 'Descripción');
    $sheet->setCellValue('D1', 'Precio');
    $sheet->setCellValue('E1', 'Stock en Tienda');
    $sheet->setCellValue('F1', 'Stock en Almacén');
    $sheet->setCellValue('G1', 'Stock Almacén Tienda');
    $sheet->setCellValue('H1', 'Stock Total');
    $sheet->setCellValue('I1', 'Categoría');

    // Obtener los datos de la base de datos
    $result = $conn->query("SELECT productos_individuales.*, categorias.nombre_categoria FROM productos_individuales LEFT JOIN categorias ON productos_individuales.categoria_id = categorias.id");

    if ($result->num_rows > 0) {
        $rowNumber = 2; // Empezar en la segunda fila
        while ($row = $result->fetch_assoc()) {
            $sheet->setCellValue('A' . $rowNumber, $row['codigo']);
            $sheet->setCellValue('B' . $rowNumber, $row['nombre']);
            $sheet->setCellValue('C' . $rowNumber, $row['descripcion']);
            $sheet->setCellValue('D' . $rowNumber, $row['precio']);
            $sheet->setCellValue('E' . $rowNumber, $row['stock_tienda']);
            $sheet->setCellValue('F' . $rowNumber, $row['stock_almacen']);
            $sheet->setCellValue('G' . $rowNumber, $row['stock_almacen_tienda']);
            $sheet->setCellValue('H' . $rowNumber, $row['stock_tienda'] + $row['stock_almacen'] + $row['stock_almacen_tienda']);
            $sheet->setCellValue('I' . $rowNumber, $row['nombre_categoria']);
            $rowNumber++;
        }
    }

    // Crear y descargar el archivo Excel
    $writer = new Xlsx($spreadsheet);
    $filename = 'Inventario_Productos_Individuales.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
    exit;
}

// Manejar la solicitud de exportación
if (isset($_GET['export']) && $_GET['export'] == 'excel') {
    exportToExcel($conn);
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario Individual</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
        }
        .sidebar {
            width: 250px;
            background-color: #343a40;
            min-height: 100vh;
            color: #fff;
        }
        .sidebar a {
            color: #fff;
            text-decoration: none;
        }
        .sidebar .nav-item:hover {
            background-color: #495057;
        }
        .content {
            flex: 1;
            padding: 20px;
        }
        .nav-link.collapsed::after {
            content: ' +';
        }
        .nav-link:not(.collapsed)::after {
            content: ' -';
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <nav class="nav flex-column">
            <h2 class="nav-link">Gestión de Productos</h2>
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#productosSubmenu">Productos</a>
            <div class="collapse" id="productosSubmenu">
                <a class="nav-link" href="categorias.php">Categorías</a>
                <a class="nav-link" href="agregar_individual.html">Productos Individuales</a>
                <a class="nav-link" href="agregar_caja.html">Productos por Caja</a>
            </div>
            <h2 class="nav-link">Gestión de Inventario</h2>
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#inventarioSubmenu">Inventario</a>
            <div class="collapse" id="inventarioSubmenu">
                <a class="nav-link" href="inventario_individual.php">Inventario Individual</a>
                <a class="nav-link" href="inventario_cajas.php">Inventario por Cajas</a>
            </div>
        </nav>
    </div>
    <div class="content">
        <h2>Inventario de Productos Individuales</h2>
        <a href="inventario_individual.php?export=excel" class="btn btn-success">Exportar a Excel</a>
        <form action="importar_inventario_individual.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="import-file-individual">Archivo Excel:</label>
                <div class="input-group">
                    <input type="file" class="form-control-file" id="import-file-individual" name="import_file" accept=".xlsx, .xls" required>
                    <div class="input-group-append">
                        <a class="btn btn-secondary" href="descargar_plantilla_individual.php">Descargar Plantilla</a>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Importar Inventario</button>
        </form>
        <hr>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Stock en Tienda</th>
                    <th>Stock en Almacén</th>
                    <th>Stock Almacén Tienda</th>
                    <th>Stock Total</th>
                    <th>Categoría</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $conn->query("SELECT productos_individuales.*, categorias.nombre_categoria FROM productos_individuales LEFT JOIN categorias ON productos_individuales.categoria_id = categorias.id");
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['codigo']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['nombre']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['descripcion']) . "</td>";
                        echo "<td>" . htmlspecialchars(number_format($row['precio'], 2)) . "</td>";
                        echo "<td>" . htmlspecialchars($row['stock_tienda']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['stock_almacen']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['stock_almacen_tienda']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['stock_tienda'] + $row['stock_almacen'] + $row['stock_almacen_tienda']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['nombre_categoria']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No hay productos en el inventario</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
