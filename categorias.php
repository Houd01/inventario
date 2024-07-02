<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Categorías</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            width: 250px;
            background-color: #343a40;
            padding-top: 20px;
            overflow-y: auto;
            z-index: 1000;
        }
        .sidebar a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .sidebar .nav-header {
            padding: 15px;
            text-transform: uppercase;
            font-weight: bold;
            color: #adb5bd;
            font-size: 14px;
            letter-spacing: 1px;
        }
        .sidebar .nav-item {
            padding: 10px 15px;
            margin: 10px 0;
            background-color: #495057;
            border-radius: 5px;
        }
        .sidebar .nav-item h2 {
            font-size: 18px;
            margin: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <nav class="nav flex-column">
            <div class="nav-header">Gestión de Productos</div>
            <div class="nav-item">
                <h2 class="nav-link collapsed" data-toggle="collapse" data-target="#productosSubmenu">Productos</h2>
                <div class="collapse" id="productosSubmenu">
                    <a class="nav-link" href="categorias.php">Categorías</a>
                    <a class="nav-link" href="agregar_individual.html">Productos Individuales</a>
                    <a class="nav-link" href="agregar_caja.html">Productos por Caja</a>
                </div>
            </div>
            <div class="nav-header">Gestión de Inventario</div>
            <div class="nav-item">
                <h2 class="nav-link collapsed" data-toggle="collapse" data-target="#inventarioSubmenu">Inventario</h2>
                <div class="collapse" id="inventarioSubmenu">
                    <a class="nav-link" href="inventario_individual.php">Inventario Individual</a>
                    <a class="nav-link" href="inventario_cajas.php">Inventario por Cajas</a>
                </div>
            </div>
        </nav>
    </div>
    <div class="content">
        <h2>Gestionar Categorías</h2>
        <form id="form-categoria" action="add_categoria.php" method="post">
            <div class="form-group">
                <label for="nombre-categoria">Nombre de la Categoría:</label>
                <input type="text" class="form-control" id="nombre-categoria" name="nombre_categoria" required>
            </div>
            <button type="submit" class="btn btn-primary">Agregar Categoría</button>
        </form>
        <h3 class="mt-5">Categorías Existentes</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre de la Categoría</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'db.php';
                $result = $conn->query("SELECT * FROM categorias");
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>" . htmlspecialchars($row['nombre_categoria']) . "</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td>No hay categorías</td></tr>";
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
