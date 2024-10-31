<?php

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consejo Financiero</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        h1 {
            margin-top: 20px;
            text-align: center;
            font-size: 2rem;
        }

        .button-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .result-container {
            margin-top: 30px;
        }

        .result-table {
            width: 100%;
            max-width: 700px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <?php include '../includes/menu.php'; ?>
    <header class="text-center bg-primary text-white p-4">
        <h1>Consejo Financiero</h1>
    </header>

    <div class="container">
        <div class="button-container">
            <button id="consultButton" class="btn btn-primary">Consultar ahora</button>
        </div>

        <div id="resultContainer" class="result-container">
            <!-- Aquí se mostrarán los resultados -->
        </div>
    </div>

    <script>
        document.getElementById('consultButton').addEventListener('click', function () {
            fetch('http://localhost:8000/ia?userid=1')
                .then(response => response.json())
                .then(data => {
                    const resultContainer = document.getElementById('resultContainer');
                    resultContainer.innerHTML = `
                        <table class="table table-bordered result-table">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Título</th>
                                    <th>Descripción</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${data.recomendaciones.map(rec => `
                                    <tr>
                                        <td>${rec.titulo}</td>
                                        <td>${rec.descripcion}</td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    `;
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>