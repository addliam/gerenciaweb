<!-- Fragmento necesario para validar haya iniciado sesion -->
<?php require_once '../../includes/sessionmanager.php' ?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Días de Racha</title>
    <!-- Nunito -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .contenedorclose {
            display: flex;
            flex-direction: row;
            justify-content: end;
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="contenedor-racha">
        <a class="contenedorclose" href="/gerenciaweb/gastos/view/VhistorialGastos.php">
            <img src="../public/assets/close.png" width="48px" height="auto" alt="cerrar" id="close">
        </a>
        <img id="imgracha" class="imagen-racha" src="../public/assets/racha-removebg-preview.png" alt="Imagen Racha">
        <div class="dias-racha" id="dias-racha"></div>
        <div class="texto-racha texto-dias-racha">días de racha</div>
        <div class="texto-racha" id="texto-fecha-inicio-racha1">Desde el <span id="fecha-inicio-racha"></span></div>
        <div class="texto-racha" id="texto-fecha-inicio-racha2">Hasta el <span id="fecha-fin-racha"></span></div>
        <div class="mensaje-felicitaciones" id="mensaje-felicitaciones">
            Felicitaciones por usar la aplicación durante <span id="racha-dias"></span> días seguidos
        </div>
    </div>
</body>

<script>
    async function obtenerRachaDeDias() {
        const response = await fetch("../controllers/GastoControlador.php?op=obtenerRacha", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            // body: JSON.stringify({ "1", "2" })
        })


        const gastos = await response.json();
        const resultado = contarRacha(gastos);
        document.getElementById('racha-dias').textContent = resultado.contador;
        document.getElementById('dias-racha').textContent = resultado.contador;
        document.getElementById('fecha-inicio-racha').textContent = resultado.fechaInicioRacha;
        document.getElementById('fecha-fin-racha').textContent = resultado.fechaFinRacha;
        if (resultado.contador == 0) {
            // poner img cara triste si contador es 0
            document.getElementById('imgracha').src = "../public/assets/sad.png"
            document.getElementById('mensaje-felicitaciones').textContent = "No tienes ningun dia de racha acumulado";
            document.getElementById('texto-fecha-inicio-racha1').textContent = "";
            document.getElementById('texto-fecha-inicio-racha2').textContent = "";
        }
    }

    obtenerRachaDeDias();

    function contarRacha(gastos) {
        let contador = 0;
        let fechaAnterior = null;
        let fechaAnterior2 = null;
        let fechaInicioRacha = null; // Fecha desde que se cumple la racha
        let fechaFinRacha = null; // Fecha actual en que se cumple la racha
        if (gastos.length == 1) {
            let contador = 0;
            let fechaInicioRacha = "";
            let fechaFinRacha = "";
            return {
                contador,// Número de días consecutivos
                fechaInicioRacha,// Fecha desde que se cumple la racha
                fechaFinRacha // Última fecha de la racha
            };
        } else {
            console.log(gastos)
            for (let i = 0; i < gastos.length; i++) {

                let fechaActual = new Date(gastos[i].fecha);

                fechaFinRacha = gastos[i].fecha;


                if (fechaAnterior) {

                    let diferencia = (fechaActual - fechaAnterior) / (1000 * 60 * 60 * 24); // Diferencia en días
                    console.log(fechaAnterior);
                    console.log(fechaActual);
                    console.log(fechaActual - fechaAnterior);
                    if (diferencia > 1 || diferencia < 0) {
                        contador = 0;
                        fechaInicioRacha = fechaFinRacha;
                    } else if (diferencia == 1) {


                        console.log(diferencia);
                        console.log("diferencia es de un dia");

                        contador++;
                    }
                } else {
                    fechaInicioRacha = gastos[i].fecha;
                }

                fechaAnterior = fechaActual;

            }
            return {
                contador, // Número de días consecutivos
                fechaInicioRacha, // Fecha desde que se cumple la racha
                fechaFinRacha // Última fecha de la racha
            };
        }

    }

</script>

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

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* html {
    font-size: 20px;
} */
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-color: #ffffff;
        font-family: "Nunito", sans-serif;
    }

    .contenedor-racha {
        text-align: center;
        border-radius: .9375rem;
        padding: .625rem 1.25rem .625rem 1.25rem;
        width: 50%;
        height: 75%;
        box-shadow: 0 .25rem .5rem rgba(0, 0, 0, 0.1);
        background: #000;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    #imgracha {
        width: 12.5rem;
        margin: 0rem 0rem 1.25rem 0rem;
    }

    .dias-racha {
        font-size: 6.25rem;
        font-weight: bold;
        color: #fff;
        line-height: 1;
    }

    .texto-racha {
        font-size: 2rem;
        color: #fff;
        font-weight: bold;

    }

    .texto-dias-racha {
        color: orange;
        font-weight: bold;
    }

    .mensaje-felicitaciones {
        font-size: 1.5625rem;
        background-color: #f0f0f0;
        border-radius: .5rem;
        padding: .625rem;
        margin: .9375rem 0;
        color: #000000;
        font-weight: bold;

    }

    @media (max-width: 400px) {
        .contenedor-racha {
            width: 85%;
        }

        html {
            font-size: 9px;
        }
    }

    @media (min-width: 400px) and (max-width: 700px) {
        .contenedor-racha {
            width: 80%;
        }

        html {
            font-size: 12px;
        }
    }
</style>

</html>