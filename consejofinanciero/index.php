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
        /* VARIABLES */
        :root {
            --color-header: #0d0d0d;
            --color-text: #404040;
            --color-btn-text: #3363ff;
            --color-btn-background: #e6ecff;
            --transition: 0.2s;
        }

        .result-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 3rem;
            background-color: #fff;
            font-family: "Inter", sans-serif;
        }

        /* MAIN CONTENT */
        .gridc {
            display: grid;
            width: 100%;
            gap: 2rem;
            grid-template-columns: repeat(auto-fit, minmax(12rem, 1fr));
        }

        .card {
            display: flex;
            flex-direction: column;
            background-color: #fff;
            border-radius: 0.4rem;
            overflow: hidden;
            box-shadow: 0 3rem 6rem rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: var(--transition);
        }

        .card:hover {
            transform: translateY(-0.5%);
            box-shadow: 0 4rem 8rem rgba(0, 0, 0, 0.2);
        }

        .card__img {
            width: 100%;
            height: 8rem;
            object-fit: contain;
            padding: 15px;
        }

        .card__content {
            display: grid;
            grid-template-rows: auto 1fr auto;
            gap: 1rem;
            padding: 1rem;
            height: 100%;
            border-top: 2px solid #e9e9e9;
        }

        .card__header {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--color-header);
            margin: .6em 0px .3em 0px;
        }

        .card__text {
            text-align: justify;
            font-size: 1rem;
            color: var(--color-text);
            margin: 0px;
        }

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
        const imagePaths = [
            "../icons/consejo/img1.png",
            "../icons/consejo/img2.png",
            "../icons/consejo/img3.png",
            "../icons/consejo/img4.png",
            "../icons/consejo/img5.png"
        ];

        let usedImages = [];

        function getRandomImage() {
            const availableImages = imagePaths.filter(image => !usedImages.includes(image));
            if (availableImages.length === 0) {
                usedImages = [];
            }
            const randomImage = availableImages[Math.floor(Math.random() * availableImages.length)];
            usedImages.push(randomImage);
            return randomImage;
        }

        const APIURL = 'http://127.0.0.1:8000';
        document.getElementById('consultButton').addEventListener('click', function () {
            fetch(`${APIURL}/ia?userid=1`)
                .then(response => response.json())
                .then(data => {
                    const resultContainer = document.getElementById('resultContainer');
                    resultContainer.innerHTML = `
                <div class="gridc">
                    ${data.recomendaciones.map(rec => `
                        <div class="card">
                            <img class="card__img"
                                 src="${getRandomImage()}"                                    
                                 alt="${rec.titulo}">
                            <div class="card__content">
                                <h1 class="card__header">${rec.titulo}</h1>
                                <p class="card__text">${rec.descripcion}</p>
                            </div>
                        </div>
                    `).join('')}
                </div>
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