<?php
require_once '../model/CategoriaModel.php';


// Crear instancia de la clase Categoria
$categoria = new Categoria();

// Obtener todas las categorías
$categorias = $categoria->obtenerCategorias();
?>
<!-- TODO: sera usado luego por el admin exclusivamente, no todos pueden CRUD categoria -->

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Categorías</title>
    <!-- Enlace a Bootstrap y Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --columbia-blue: #a6cce0ff;
            --picton-blue: #13b2f5ff;
            --bondi-blue: #0094b7ff;
            --resolution-blue: #212696ff;
            --azure: #1377e0ff;
            --prussian-blue: #023151ff;
            --celeste: #b5f2f4ff;
            --celtic-blue: #4b76caff;
            --oxford-blue: #002146ff;
        }

        h1 {
            color: var(--resolution-blue);
        }

        table {
            color: var(--oxford-blue);
        }

        th {
            background-color: var(--columbia-blue);
        }

        .btn-edit {
            background-color: var(--picton-blue);
            color: #fff;
        }

        .btn-delete {
            background-color: var(--bondi-blue);
            color: #fff;
        }

        .btn-add {
            background-color: var(--resolution-blue);
            color: #fff;
        }
    </style>
</head>

<body class="bg-light">

    <div class="container my-5">
        <h1 class="text-center mb-4">Lista de Categorías</h1>
        <button class="btn btn-add btn-sm" data-bs-toggle="modal" data-bs-target="#addModal"
            style="margin-bottom: 20px;">
            <i> Nueva Categoria</i>
        </button>
        <div class="table-responsive d-flex justify-content-center">

            <table class="table table-bordered table-striped text-center" id="listaCategorias">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categorias as $categoria): ?>
                        <tr data-id="<?php echo htmlspecialchars($categoria['categoriagasto_id']); ?>">
                            <td><?php echo htmlspecialchars($categoria['categoriagasto_id']); ?></td>
                            <td class="categoria-nombre"><?php echo htmlspecialchars($categoria['nombre']); ?></td>
                            <td>
                                <button class="btn btn-edit btn-sm me-2" data-bs-toggle="modal" data-bs-target="#editModal"
                                    onclick="openEditModal(<?php echo htmlspecialchars($categoria['categoriagasto_id']); ?>, '<?php echo htmlspecialchars($categoria['nombre']); ?>')">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <button class="btn btn-delete btn-sm me-2">
                                    <i class="fas fa-trash-alt"></i>
                                </button>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal para Agregar Categoría -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Agregar Categoría</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="addCategoryName" class="form-label">Nombre de la Nueva Categoría</label>
                        <input type="text" class="form-control" id="addCategoryName">
                    </div>
                </div>
                <div class="modal-footer">
                    <button data-bs-dismiss="modal" type="button" class="btn btn-primary"
                        onclick="addCategory()">Agregar Categoría</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Editar Categoría -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Categoría</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editCategoryId">
                    <div class="mb-3">
                        <label for="editCategoryName" class="form-label">Nuevo Nombre de la Categoría</label>
                        <input type="text" class="form-control" id="editCategoryName">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="updateCategory()">Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>



    <!-- Enlace a Bootstrap JS y sus dependencias -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

    <script>
        function openEditModal(id, name) {
            document.getElementById('editCategoryId').value = id;
            document.getElementById('editCategoryName').value = name;
        }

        function updateCategory() {
            const id = document.getElementById('editCategoryId').value;
            const name = document.getElementById('editCategoryName').value;

            fetch('Ccategoria.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ categoriagasto_id: id, nombre: name }),
            })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    location.reload(); // Recarga la página para mostrar los cambios
                });
        }

        function addCategory() {
            const name = document.getElementById('addCategoryName').value;

            fetch('../controller/CinsertarCategoria.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ nombre: name }),
            }).then(response => response.json())
                .then(
                    data =>
                        crearFila(data.message)

                )
        }

        function crearFila(data) {
            location.reload();
        }
    </script>
    <!-- 
        <script>
            document.getElementById("formAgregarCategoria").addEventListener("submit", function(event) {
                event.preventDefault(); // Evitar el envío del formulario

                const nombreCategoria = document.getElementById("nombreCategoria").value; // Obtener el valor del campo
                const tablaCategorias = document.getElementById("tablaCategorias");

                // Crear una nueva fila y celda
                const nuevaFila = document.createElement("tr");
                const nuevaCelda = document.createElement("td");
                nuevaCelda.textContent = nombreCategoria; // Asignar el nombre a la celda

                // Agregar la celda a la fila y la fila al cuerpo de la tabla
                nuevaFila.appendChild(nuevaCelda);
                tablaCategorias.appendChild(nuevaFila);

                // Limpiar el campo de entrada y cerrar el modal
                document.getElementById("nombreCategoria").value = "";
                $('#agregarCategoriaModal').modal('hide'); // Cerrar el modal
            });
        </script> -->
</body>

</html>