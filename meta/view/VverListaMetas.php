<!-- Fragmento necesario para validar haya iniciado sesion -->
<?php require_once '../../includes/sessionmanager.php' ?>


<?php
$SESSION_USUARIO_ID = $_SESSION['usuario_id'];
require_once '../model/metaModel.php';
$metaModel = new MetaModel();
$metas = $metaModel->getAllMetas($SESSION_USUARIO_ID);
$categoria = $metaModel->getAllCategoriagasto();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Metas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .editable { display: none; }
        .progress-circle {
            width: 80px;
            height: 80px;
            position: relative;
            border-radius: 50%;
        }

        .circle-bg {
            fill: none;
            stroke: #e6e6e6;
            stroke-width: 8;
        }

        .circle-progress {
            fill: none;
            stroke: #007bff;
            stroke-width: 8;
            stroke-linecap: round;
            transition: stroke-dasharray 0.35s;
        }

        .circle-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 11px;
            font-weight: bold;
        }
        #btncontainer{
            display: flex;
            flex-direction: row;
            gap: 2rem;
            justify-content: center;
        }
    </style>
</head>
<body>
    <?php include '../../includes/menu.php'; ?>
    <header id="titulo" class="text-center p-4 bg-primary text-white">
        <h1>Lista de Metas</h1>
    </header>
    <div class="container mt-5">
        <div id="btncontainer" class="text-center mb-4">
            <a href="../index.php" class="btn btn-primary">Registrar Nueva Meta</a>
            <a href="./VverMetasNoAlcanzadas.php" class="btn btn-primary">Metas No Alcanzadas</a>
        </div>
        <div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Monto Máximo</th>
                        <th>Categoría Gasto</th>
                        <th>Plazo</th>
                        <th>Progreso</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($metas as $meta): ?>
                        <tr>
                            <form action="../controller/actualizarMeta.php" method="POST">
                                <td>
                                    <span class="static-text"><?php echo htmlspecialchars($meta['nombre']); ?></span>
                                    <input type="text" name="nombre" value="<?php echo htmlspecialchars($meta['nombre']); ?>" class="form-control editable" disabled>
                                </td>
                                <td>
                                    <span class="static-text"><?php echo htmlspecialchars($meta['monto_maximo']); ?></span>
                                    <input type="text" name="monto_maximo" value="<?php echo htmlspecialchars($meta['monto_maximo']); ?>" class="form-control editable" disabled>
                                </td>
                                <td>
                                    <span class="static-text">
                                        <?php
                                        foreach ($categoria as $categorias) {
                                            if ($meta['categoriagasto_id'] == $categorias['categoriagasto_id']) {
                                                echo htmlspecialchars($categorias['nombre']);
                                            }
                                        }
                                        ?>
                                    </span>
                                    <select name="categoriagasto_id" class="form-control editable" disabled>
                                        <?php foreach ($categoria as $categorias): ?>
                                            <option value="<?php echo $categorias['categoriagasto_id']; ?>" 
                                                <?php echo $meta['categoriagasto_id'] == $categorias['categoriagasto_id'] ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($categorias['nombre']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                
                                <td>
                                    <span class="static-text"><?php echo htmlspecialchars($meta['plazo']); ?></span>
                                    <input type="date" name="plazo" value="<?php echo htmlspecialchars($meta['plazo']); ?>" class="form-control editable" disabled>
                                </td>
                                <td>
                                    <div class="progress-circle">
                                        <svg width="80" height="80">
                                            <circle class="circle-bg" cx="40" cy="40" r="25"></circle>
                                            <circle class="circle-progress" cx="40" cy="40" r="25" 
                                                    style="
                                                        stroke-dasharray: <?php echo 2 * pi() * 25; ?>; 
                                                        stroke-dashoffset: <?php echo 2 * pi() * 25 * (1 - min($meta['progreso_actual'] / 100, 1)); ?>;
                                                        stroke: <?php echo $meta['progreso_actual'] > 100 ? '#dc3545' : '#28a745'; ?>;
                                                        transition: stroke-dashoffset 0.5s ease;
                                                    ">
                                            </circle>                                        
                                        </svg>
                                        <div class="circle-text">
                                            <?php 
                                            echo floor($meta['progreso_actual']) == $meta['progreso_actual'] 
                                            ? number_format($meta['progreso_actual'], 0) 
                                            : number_format($meta['progreso_actual'], 2); 
                                            ?>%                                        
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <input type="hidden" name="meta_id" value="<?php echo $meta['meta_id']; ?>">
                                    <button type="button" class="btn btn-warning btn-sm" onclick="habilitarEdicion(this)">Editar</button>
                                    <button type="submit" class="btn btn-success btn-sm editable" disabled>Guardar</button>
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirmDeleteModal-<?php echo $meta['meta_id']; ?>">Eliminar</button>
                                </td>
                            </form>
                        </tr>
                        <div class="modal fade" id="confirmDeleteModal-<?php echo $meta['meta_id']; ?>" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Eliminación</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        ¿Estás seguro de que quieres eliminar esta meta?
                                    </div>
                                    <div class="modal-footer">
                                        <form action="../controller/eliminarMeta.php" method="POST" style="display:inline;">
                                            <input type="hidden" name="meta_id" value="<?php echo $meta['meta_id']; ?>">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-danger">Eliminar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <script>
            function habilitarEdicion(btn) {
                var row = btn.closest('tr');
                var inputs = row.querySelectorAll('.editable');
                var staticTexts = row.querySelectorAll('.static-text');

                inputs.forEach(function(input) {
                    input.disabled = false;
                    input.style.display = 'block';
                });

                staticTexts.forEach(function(span) {
                    span.style.display = 'none';
                });

                btn.style.display = 'none';
                btn.nextElementSibling.disabled = false;
            }
            </script>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
