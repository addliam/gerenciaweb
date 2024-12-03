<?php
// Corrigio un error tipeo en Folder Categorias -> categorias
require_once '../categorias/model/CategoriaModel.php';
$categoria = new Categoria();
$valores = $categoria->obtenerCategorias();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Finanzas</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex justify-content-center align-items-center vh-100">

    <!-- Formulario de Gastos -->
    <form id="formulario-gastos" class="p-4 bg-info rounded shadow" style="width: 80%; max-width: 400px;">
        <h4 class="text-center text-white mb-3">Gastos</h4>
        <div class="form-group">
            <span style="color: #ffffff; font-weight: bold;">Nombre del gasto</span>
            <input type="text" name="nombre_gasto" class="form-control" placeholder="Nombre del gasto">
            <!-- <input type="text" name="nombre_categoria" class="form-control" placeholder="Nombre del gasto"> -->

        </div>
        <div class="form-group">
            <span style="color: #ffffff; font-weight: bold;">Monto</span>
            <input type="number" name="monto_gasto" class="form-control" placeholder="Insertar monto">
        </div>
        <span style="color: #ffffff; font-weight: bold;">Categoria</span>
        <div class="form-group">
            <select class="form-control" name="nombre_categoria">
                <?php
                // Recorrer el array y crear las opciones
                foreach ($valores as $valor) {
                    // Solo agregar si el nombre no está vacío
                    if (!empty($valor['nombre'])) {
                        echo "<option value=\"{$valor['categoriagasto_id']}\">{$valor['nombre']}</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-dark text-white" style="width: 100%;"
                id="botonRegistrarGasto">Registrar Gasto</button>
        </div>
    </form>

    <script>
        const botonRegistrarGasto = document.getElementById("botonRegistrarGasto");
        const formulario = document.getElementById("formulario-gastos");

        botonRegistrarGasto.addEventListener("click", (event) => {
            event.preventDefault();

            fetch("./controller/CinsertarGasto.php", {
                method: "POST",
                body: new FormData(formulario)
            }).then(response => response.text())
                .then(response => {
                    console.log(response);
                    window.location.replace("./view/VhistorialGastos.php");
                })
        })
    </script>
</body>

</html>