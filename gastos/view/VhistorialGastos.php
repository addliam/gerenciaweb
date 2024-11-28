<!-- Fragmento necesario para validar haya iniciado sesion -->
<?php require_once '../../includes/sessionmanager.php' ?>

<?php
$SESSION_USUARIO_ID = $_SESSION['usuario_id'];
require_once '../model/GastoModel.php';
$gasto = new Gasto();
$gastos = $gasto->obtenerGastos($SESSION_USUARIO_ID);
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gastos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        /* Colores personalizados */
        .btn-edit {
            background-color: #13b2f5;
            /* Picton Blue */
            color: white;
        }

        .btn-delete {
            background-color: #0094b7;
            /* Bondi Blue */
            color: white;
        }

        .btn-edit:hover,
        .btn-delete:hover {
            opacity: 0.8;
        }

        /* Estilo para la tabla con scroll */
        .table-container {
            max-height: 400px;
            /* Altura máxima de la tabla */
            overflow-y: auto;
            /* Habilita el scroll vertical */
            border: 1px solid #dee2e6;
            /* Borde para mejorar la visualización */
            border-radius: 0.25rem;
            /* Bordes redondeados */
        }

        /* Ajustes para dispositivos pequeños */
        @media (max-width: 240px) {

            .table th,
            .table td {
                font-size: 10px;
                /* Fuente más pequeña */
                padding: 4px;
                /* Menor padding */
            }

            .btn-edit,
            .btn-delete {
                font-size: 8px;
                /* Botones más pequeños */
            }
        }
    </style>
</head>

<body>

    <?php include '../../includes/menu.php'; ?>
    <header class="text-center bg-primary text-white p-4">
        <h1>Historial de Gastos</h1>
    </header>
    <div class="container mt-5">

        <a class="btn btn-primary" style="margin-bottom: 20px" href="..">Registrar Nuevo Gasto</a>
        <div class="table-responsive">
            <div class="table-container">
                <table class="table table-bordered table-sm">
                    <thead class="thead-light">
                        <tr>
                            <th>ID Gasto</th>
                            <th>Categoría</th>
                            <th>Nombre del Gasto</th>
                            <th>Monto</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($gastos as $gasto): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($gasto['gasto_id']); ?></td>
                                <td><?php echo htmlspecialchars($gasto['categoria_nombre']); ?></td>
                                <td><?php echo htmlspecialchars($gasto['gasto_nombre'] ?: 'Sin nombre'); ?></td>
                                <td><?php echo htmlspecialchars($gasto['monto']); ?></td>
                                <td><?php echo htmlspecialchars($gasto['fecha']); ?></td>
                                <td>
                                    <button class="btn btn-edit btn-sm" title="Editar">
                                        <span class="material-icons">edit</span>
                                    </button>
                                    <button class="btn btn-delete btn-sm" title="Eliminar">
                                        <span class="material-icons">delete</span>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>