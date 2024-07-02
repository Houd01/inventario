<?php
include 'db.php';
require 'vendor/autoload.php'; // Asegúrate de que la ruta sea correcta

use PhpOffice\PhpSpreadsheet\IOFactory;

// Función para agregar producto individual desde el formulario
function agregarProductoIndividual($conn, $data) {
    $codigo = isset($data['codigo']) ? $data['codigo'] : '';
    $nombre = isset($data['nombre']) ? $data['nombre'] : '';
    $descripcion = isset($data['descripcion']) ? $data['descripcion'] : '';
    $precio = isset($data['precio']) ? $data['precio'] : 0;
    $stock_tienda = isset($data['stock_tienda']) ? $data['stock_tienda'] : 0;
    $stock_almacen = isset($data['stock_almacen']) ? $data['stock_almacen'] : 0;
    $stock_almacen_tienda = isset($data['stock_almacen_tienda']) ? $data['stock_almacen_tienda'] : 0;
    $categoria_id = isset($data['categoria_id']) ? $data['categoria_id'] : 0;
    $stock_total = $stock_tienda + $stock_almacen + $stock_almacen_tienda;

    if ($codigo && $nombre && $categoria_id) { // Verificación simplificada
        $sql = "INSERT INTO productos_individuales (codigo, nombre, descripcion, precio, stock_tienda, stock_almacen, stock_almacen_tienda, stock_total, categoria_id) VALUES ('$codigo', '$nombre', '$descripcion', '$precio', '$stock_tienda', '$stock_almacen', '$stock_almacen_tienda', '$stock_total', '$categoria_id')";

        if ($conn->query($sql) === TRUE) {
            return true;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            return false;
        }
    } else {
        return false;
    }
}

// Procesar datos del formulario
if (isset($_POST['nombre'])) {
    if (agregarProductoIndividual($conn, $_POST)) {
        header("Location: agregar_individual.html?status=success");
        exit();
    } else {
        header("Location: agregar_individual.html?status=error");
        exit();
    }
}

// Procesar importación de Excel
if (isset($_FILES['import_file'])) {
    $file = $_FILES['import_file']['tmp_name'];
    $spreadsheet = IOFactory::load($file);
    $worksheet = $spreadsheet->getActiveSheet();

    $importSuccess = true;

    foreach ($worksheet->getRowIterator(2) as $row) {
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(FALSE);

        $data = [];
        foreach ($cellIterator as $cell) {
            $data[] = $cell->getValue();
        }

        if (array_filter($data)) { // Verifica que la fila no esté completamente vacía
            $productoData = [
                'codigo' => $data[0],
                'nombre' => $data[1],
                'descripcion' => $data[2],
                'precio' => $data[3],
                'stock_tienda' => $data[4],
                'stock_almacen' => $data[5],
                'stock_almacen_tienda' => $data[6],
                'categoria_id' => $data[7],
            ];

            if (!agregarProductoIndividual($conn, $productoData)) {
                $importSuccess = false;
                break;
            }
        }
    }

    if ($importSuccess) {
        header("Location: agregar_individual.html?status=success");
        exit();
    } else {
        header("Location: agregar_individual.html?status=error");
        exit();
    }
}

$conn->close();
?>
