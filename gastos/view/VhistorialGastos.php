<!-- Fragmento necesario para validar haya iniciado sesion -->
<?php require_once '../../includes/sessionmanager.php' ?>

<?php
$SESSION_USUARIO_ID = $_SESSION['usuario_id'];
require_once '../model/GastoModel.php';
$gasto = new Gasto();
$gastos = $gasto->obtenerGastos($SESSION_USUARIO_ID);
?>

<?php

$host = $_SERVER['HTTP_HOST'];
define("BASE_URL", "http://" . $host);

?>


<script>
    const validacion = "<?php echo $SESSION_USUARIO_ID ?>"

</script>

<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="icon" type="image/x-icon" href="/gerenciaweb/favicon/favicon.ico">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gastos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="../../includes/global.css">
    <style>
        header {
            background-color: var(--color-verde-claro);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: var(--color-fondo);
            border: 2px solid var(--color-borde);
            font-family: Arial, sans-serif;
            font-size: 14px;
            text-align: left;
            margin-bottom: 20px;
        }

        th {
            padding: 8px 28px !important;
            text-align: center !important;
            background-color: var(--color-verde-oscuro);
            color: var(--color-fondo);
            border-bottom: 3px solid var(--color-primario);
            text-transform: uppercase;
        }

        td {
            padding: 8px;
            border-bottom: 1px solid var(--color-borde);
            color: var(--color-texto-primario);
        }

        tr:nth-child(even) {
            background-color: var(--color-borde-hover);
        }

        tr:hover {
            background-color: var(--color-primario);
            color: var(--color-fondo);
        }

        .btn-delete {
            background-color: var(--color-rojo);
            color: var(--color-fondo);
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-delete:hover {
            background-color: var(--color-texto-hover);
            opacity: 0.9;
        }

        .table-header {
            background-color: var(--color-primario);
            color: var(--color-fondo);
            font-weight: bold;
        }
    </style>

</head>

<body>

    <?php include '../../includes/menu.php'; ?>
    <header class="text-center text-white p-4">
        <h1>Historial de Gastos</h1>
    </header>
    <div class="container mt-5">

        <a class="btn btn-primary" style="margin-bottom: 20px" href="./index.php">Registrar Nuevo Gasto</a>
        <div class="table-responsive">
            <div class="table-container">
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr class="tr-cabecera">
                            <th>ID Gasto</th>
                            <th>Categoría</th>
                            <th>Nombre del Gasto</th>
                            <th>Monto</th>
                            <th>Fecha</th>
                            <th>Hora</th>
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
                                <td><?php echo htmlspecialchars(substr($gasto['fecha_hora'], 11)); ?></td>
                                <td>
                                    <!-- <button 
                                    class="btn btn-edit btn-sm" 
                                    title="Editar" 
                                    data-id="<?php echo htmlspecialchars($gasto['gasto_id']); ?>">
                                    <span class="material-icons">edit</span>
                                </button> -->
                                    <button class="btn btn-delete btn-sm" title="Eliminar"
                                        data-id="<?php echo htmlspecialchars($gasto['gasto_id']); ?>">
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

    <!-- Modal -->
    <div id="modal" class="modal" style="display: none;">
        <div class="modal-content">
            <span id="close-modal" class="close">&times;</span>
            <p id="modal-message"></p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        const BASE_URL = "<?php echo BASE_URL ?>"
        const usuario_id = "<?php echo $SESSION_USUARIO_ID ?>"


        // Manejo de botones Eliminar
        document.querySelectorAll(".btn-delete").forEach(button => {
            button.addEventListener("click", async function () {
                const gastoId = this.getAttribute("data-id");
                // Confirmar eliminación

                // if (confirm("¿Estás seguro de que deseas eliminar este gasto?")) {
                // }

                const response = await fetch("../controller/CeliminarGasto.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({ action: "eliminar", gasto_id: gastoId })
                })
                const result = await response.json();
                // Mostrar el mensaje 
                Swal.fire({
                    title: "Gasto eliminado correctamente!",
                    text: "",
                    icon: "success"
                });
                // showModal(result.message);
                // Recargar para actualizar vista de tabla
                setTimeout(function () {
                    location.reload();
                }, 500);
            });
        });

        document.addEventListener("DOMContentLoaded", async () => {
            // const response = await fetch(`${BASE_URL}/gerenciaweb-main/controller/GastoControlador.php?op=obtenerFechaUltimoGasto`, {
            const response = await fetch(`../controller/GastoControlador.php?op=obtenerFechaUltimoGasto`, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ usuario_id })
            })

            const result = await response.json();
            console.log(result.data)
            const lastGastoDate = new Date(result.data);
            const currentDate = new Date();
            const differenceInDays = Math.floor((currentDate - lastGastoDate) / (1000 * 60 * 60 * 24));
            console.log(lastGastoDate)
            if (differenceInDays >= 7) {
                showAnimatedNotification(`¡Hace ${differenceInDays - 1} días que no registras un gasto!`);
                // console.log(`¡Hace ${differenceInDays} días que no registras un gasto!`);

            }

            // localStorage.setItem("lastAccessDate", currentDate.toISOString());
            console.log(result);

            function showAnimatedNotification(message, imageSource) {
                const notificationContainer = document.createElement("div");
                // imagen capibara
                const img = document.createElement("img");
                img.src = imageSource ? imageSource : "/gerenciaweb/icons/capibara/capybara_indiferente.png";
                img.alt = "Imagen capibara";
                img.style.width = "100px";
                img.style.height = "100px";
                console.log(notificationContainer);
                // sgte
                notificationContainer.style.position = "fixed";
                notificationContainer.style.display = "block";
                notificationContainer.style.top = "20px";
                notificationContainer.style.right = "20px";
                notificationContainer.style.padding = "20px";
                notificationContainer.style.backgroundColor = "#FFD700";
                notificationContainer.style.color = "#000";
                notificationContainer.style.fontSize = "16px";
                notificationContainer.style.fontWeight = "bold";
                notificationContainer.style.boxShadow = "0 4px 8px rgba(0, 0, 0, 0.2)";
                notificationContainer.style.borderRadius = "8px";
                notificationContainer.style.transition = "transform 0.5s ease, opacity 0.5s ease";
                notificationContainer.style.zIndex = "1000";

                notificationContainer.textContent = message;
                document.body.appendChild(notificationContainer);
                notificationContainer.appendChild(img);

                // Animación de entrada
                notificationContainer.style.transform = "translateX(100%)";
                notificationContainer.style.opacity = "0";
                setTimeout(() => {
                    notificationContainer.style.transform = "translateX(0)";
                    notificationContainer.style.opacity = "1";
                }, 100);

                // Desaparición después de 5 segundos
                setTimeout(() => {
                    notificationContainer.style.transform = "translateX(100%)";
                    notificationContainer.style.opacity = "0";
                    setTimeout(() => {
                        notificationContainer.remove();
                    }, 500);
                }, 5000);
            }

        });





    </script>

</body>

</html>