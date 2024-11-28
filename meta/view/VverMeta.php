<!-- realmente la funcion del archivo es RegistrarMeta -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Metas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .contenedorformulario {
            margin-top: 1.5rem;
        }
    </style>
</head>

<body>
    <?php include '../includes/menu.php'; ?>

    <header id="titulo" class="text-center p-4 bg-primary text-white">
        <h1>Gestión de Metas</h1>
    </header>

    <div class="container">
        <div class="principal mt-5">
            <a href="./view/VverListaMetas.php" class="btn btn-primary">Mis Metas</a>
            <div class="contenedorformulario">
                <h2>Registrar Nueva Meta</h2>
                <form action="./controller/insertarMeta.php" method="POST">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" name="nombre" id="nombre"
                            placeholder="Ingrese el nombre de la meta" required>
                    </div>
                    <div class="form-group">
                        <label for="monto_maximo">Monto Máximo</label>
                        <input type="text" class="form-control" name="monto_maximo" id="monto_maximo"
                            placeholder="Ingrese el monto máximo" required>
                    </div>
                    <div class="form-group">
                        <label for="nombre_categoria">Categoría Gasto</label>
                        <!-- <p>
                            <?php
                            echo count($categoria);
                            ?>
                        </p> -->
                        <select class="form-control" name="categoriagasto_id" id="nombre_categoria" required>
                            <option value="">Seleccione una categoría</option>
                            <?php
                            foreach ($categoria as $categorias) {
                                if (!empty($categorias['nombre'])) {
                                    echo "<option value=\"{$categorias['categoriagasto_id']}\">" . htmlspecialchars($categorias['nombre']) . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="plazo">Plazo</label>
                        <input type="date" class="form-control" name="plazo" id="plazo" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Registrar Meta</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>