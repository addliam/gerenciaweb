<?php require_once '../../includes/sessionmanager.php' ?>


<?php
$SESSION_USUARIO_ID = $_SESSION['usuario_id'];
require_once '../model/metaModel.php';
$metaModel = new MetaModel();
$metasNoAlcanzadas = $metaModel->getMetasNoAlcanzadas($SESSION_USUARIO_ID);
$categoria = $metaModel->getAllCategoriagasto();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metas No Alcanzadas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/gerenciaweb/includes/global.css">
    <style>
        header {
            background-color: var(--color-rojo);
        }

        body {
            background-color: #f8f9fa;
            /* Fondo gris claro */
        }

        .meta-item {
            background-color: #ffffff;
            /* Fondo blanco intenso */
            border-radius: 10px;
            /* Esquinas redondeadas */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            /* Sombra sutil */
            padding: 15px;
            margin-bottom: 15px;
            font-size: 0.9rem;
        }

        .meta-title {
            font-size: 1.5rem;
            /* Título más grande */
            font-weight: bold;
            color: #333;
            /* Color oscuro */
            margin-bottom: 10px;
        }

        .meta-label {
            font-weight: bold;
            color: #333;
        }

        .meta-value {
            color: #666;
        }

        .meta-item .row {
            margin-bottom: 5px;
        }

        #msgnul {
            font-size: 1.25rem;
            font-weight: 600;
        }

        #btncontainer {
            display: flex;
            flex-direction: row;
            gap: 2rem;
            justify-content: center;
        }
    </style>
</head>

<body>
    <?php include '../../includes/menu.php'; ?>
    <header id="titulo" class="text-center p-4 text-white">
        <h1>Metas No Alcanzadas</h1>
    </header>
    <div class="container mt-5">
        <div id="btncontainer" class="text-center mb-4">
            <a href="../index.php" class="btn btn-primary">Registrar Nueva Meta</a>
            <a href="../view/VverListaMetas.php" class="btn btn-primary">Ver Todas las Metas</a>
        </div>
        <div>
            <?php echo count($metasNoAlcanzadas) <= 0 ? '<p id="msgnul">No tienes metas sin alcanzar.</p>' : ''; ?>
            <?php foreach ($metasNoAlcanzadas as $meta): ?>
                <div class="meta-item">
                    <div class="meta-title"><?php echo htmlspecialchars($meta['nombre']); ?></div>
                    <div class="row">
                        <div class="col-6">
                            <span class="meta-label">Monto Máximo:</span>
                            <span class="meta-value"><?php echo htmlspecialchars($meta['monto_maximo']); ?></span>
                        </div>
                        <div class="col-6">
                            <span class="meta-label">Plazo:</span>
                            <span class="meta-value"><?php echo htmlspecialchars($meta['plazo']); ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <span class="meta-label">Categoría:</span>
                            <span class="meta-value">
                                <?php
                                foreach ($categoria as $categorias) {
                                    if ($meta['categoriagasto_id'] == $categorias['categoriagasto_id']) {
                                        echo htmlspecialchars($categorias['nombre']);
                                        break;
                                    }
                                }
                                ?>
                            </span>
                        </div>
                        <div class="col-6">
                            <!-- <span class="meta-label">Progreso:</span>-->
                            <div class="progress mt-2" style="height: 20px; background-color: #e9ecef;">
                                <div class="progress-bar bg-success" role="progressbar"
                                    style="width: <?php echo $meta['progreso_actual']; ?>%;"
                                    aria-valuenow="<?php echo $meta['progreso_actual']; ?>" aria-valuemin="0"
                                    aria-valuemax="100">
                                    <?php echo number_format($meta['progreso_actual'], 2); ?>%
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="row mt-2">
                        <div class="col-12">
                            <span class="meta-label">Estado:</span>
                            <span class="meta-value"><?php echo htmlspecialchars($meta['estado']); ?></span>
                        </div>
                    </div> -->
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>