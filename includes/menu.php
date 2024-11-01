<?php
define('BASE_PATH', '/gerenciaweb/');
?>
<!-- menu.php -->
<nav class="navbar navbar-expand-lg navbar-dark-blue">
    <a class="navbar-brand" href="#">App</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo BASE_PATH; ?>index.php">Inicio
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo BASE_PATH; ?>gastos/view/VhistorialGastos.php">Gastos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo BASE_PATH; ?>meta/index.php">Metas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo BASE_PATH; ?>consejofinanciero/">Consejo Financiero</a>
            </li>
        </ul>
    </div>
</nav>

<!-- Estilos específicos para menu.php -->
<style>
    .navbar-dark-blue {
        background-color: #003366;
        color: white;
    }

    .navbar-dark-blue .nav-link,
    .navbar-dark-blue .navbar-brand {
        color: white !important;
    }

    .navbar-dark-blue .nav-link:hover {
        color: #66b2ff !important;
    }
</style>