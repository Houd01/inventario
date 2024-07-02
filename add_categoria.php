<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_categoria = $conn->real_escape_string($_POST['nombre_categoria']);

    $sql = "INSERT INTO categorias (nombre_categoria) VALUES ('$nombre_categoria')";

    if ($conn->query($sql) === TRUE) {
        header("Location: categorias.php"); // Redirigir a la página de gestión de categorías
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
