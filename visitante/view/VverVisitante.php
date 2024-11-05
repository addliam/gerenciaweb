<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visitantes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./styles.css">
    <style>
        h1 {
            margin-top: 20px;
            text-align: center;
        }

        h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--celtic-blue);
        }

        .table {
            max-width: 20rem;
        }

        .table thead {
            background-color: var(--oxford-blue);
            color: white;
        }

        #titulo {
            display: flex;
            gap: 2rem;
            justify-content: center;
        }

        .principal {
            display: flex;
            gap: 5rem;
        }
    </style>
</head>

<body>
    <header id="titulo" class="text-center p-4 bg-primary text-white">
        <h1>Visitantes</h1>
        <div>
            <img style="width: 80px;" src='./resource/Visitante.png' alt="Icono de visitante">
        </div>
    </header>
    <div class="container">
        <div class="principal mt-5">
            <div class="contenedortabla">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($visitantes as $visitante): ?>
                            <tr>
                                <td><?php echo $visitante['id_visitante']; ?></td>
                                <td><?php echo $visitante['nombre']; ?></td>
                                <td><?php echo $visitante['apellido']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="contenedorformulario">
                <h2>Registrar nuevo visitante</h2>
                <form action="./controller/CinsertarVisitante.php" method="POST">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" name="nombre" id="nombre"
                            placeholder="Ingrese el nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="apellido">Apellido</label>
                        <input type="text" class="form-control" name="apellido" id="apellido"
                            placeholder="Ingrese el apellido" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Registrar</button>
                </form>

            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>