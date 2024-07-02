<?php
include 'db.php';
require 'vendor/autoload.php'; // Asegúrate de que la ruta sea correcta

use PhpOffice\PhpSpreadsheet\IOFactory;

// Función para agregar producto desde el formulario
function agregarProducto($conn, $data) {
    $codigo = isset($data['codigo']) ? $data['codigo'] : '';
    $nombre = isset($data['nombre']) ? $data['nombre'] : '';
    $descripcion = isset($data['descripcion']) ? $data['descripcion'] : '';
    $precio_unidad = isset($data['precio_unidad']) ? $data['precio_unidad'] : 0;
    $total_cajas = isset($data['total_cajas']) ? $data['total_cajas'] : 0;
    $stock_tienda = isset($data['stock_tienda']) ? $data['stock_tienda'] : 0;
    $stock_almacen = isset($data['stock_almacen']) ? $data['stock_almacen'] : 0;
    $categoria_id = isset($data['categoria_id']) ? $data['categoria_id'] : 0;

    if ($codigo && $nombre && $categoria_id) { // Verificación simplificada
        $sql = "INSERT INTO productos_cajas (codigo, nombre, descripcion, precio_unidad, total_cajas, stock_tienda, stock_almacen, categoria_id) VALUES ('$codigo', '$nombre', '$descripcion', '$precio_unidad', '$total_cajas', '$stock_tienda', '$stock_almacen', '$categoria_id')";

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
    if (agregarProducto($conn, $_POST)) {
        header("Location: agregar_caja.html?status=success");
        exit();
    } else {
        header("Location: agregar_caja.html?status=error");
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
                'precio_unidad' => $data[3],
                'total_cajas' => $data[4],
                'stock_tienda' => $data[5],
                'stock_almacen' => $data[6],
                'categoria_id' => $data[7],
            ];

            if (!agregarProducto($conn, $productoData)) {
                $importSuccess = false;
                break;
            }
        }
    }

    if ($importSuccess) {
        header("Location: agregar_caja.html?status=success");
        exit();
    } else {
        header("Location: agregar_caja.html?status=error");
        exit();
    }
}

$conn->close();
?>
