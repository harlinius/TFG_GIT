<?php
require_once '../bd/usuario.php';
require_once '../lib/funciones.php';
require_once '../bd/libro.php';
require_once '../bd/biblioteca.php';
session_start();

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
} else {
    header('Location: ../gestion_cuentas/login.php');
    die();
}

$tituloPagina = "Read&Meet | Biblioteca";
$activoBiblioteca = 'active';
$HojaCSS = "../css/estilo_biblioteca.css";
$bibliotecas = Biblioteca::biblioteca_usuario($usuario);

if ($usuario->administrador == 1) {
    require_once '../include/cabecera_home_admin.php';
} else {
    require_once '../include/cabecera_home_usuario.php';
}
?>

<div id="resultados" class="row">
        <?php foreach ($bibliotecas as $biblioteca) :
            $libro = Libro::cargaLibroId($biblioteca['id_libro']); ?>
            <div class="card">
                <?php echo '<img class="img_portada_biblioteca" src="../portadas_libros/' . Libro::getRutaFotoArray($biblioteca) . '">' ?>
                <div class="card__content">
                    <p class="card__title"><?php echo e($libro->titulo) ?>
                    </p>
                    <p class="card__description">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>
                </div>
            </div>
        <?php endforeach; ?>
</div>

<?php
require_once "../include/script.php";
?>

<?php
require_once "../include/pie_normal.php";
?>