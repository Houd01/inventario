<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Inventario</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="sidebar">
        <nav class="nav flex-column">
            <h2 class="nav-link" data-toggle="collapse" data-target="#productosSubmenu">Gestión de Productos</h2>
            <div class="collapse show" id="productosSubmenu">
                <a class="nav-link" href="categorias.php">Categorías</a>
                <a class="nav-link" href="agregar_individual.html">Productos Individuales</a>
                <a class="nav-link" href="agregar_caja.html">Productos por Caja</a>
            </div>
            <h2 class="nav-link" data-toggle="collapse" data-target="#inventarioSubmenu">Gestión de Inventario</h2>
            <div class="collapse show" id="inventarioSubmenu">
                <a class="nav-link" href="inventario_individual.php">Inventario Individual</a>
                <a class="nav-link" href="inventario_cajas.php">Inventario por Cajas</a>
            </div>
        </nav>
    </div>
    <div class="content">
        <h1>Bienvenido al Sistema de Inventario</h1>
        <p>Use la barra de navegación para gestionar productos, categorías y ver el inventario.</p>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
