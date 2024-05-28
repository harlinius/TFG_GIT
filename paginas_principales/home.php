<?php
require_once '../bd/usuario.php';
require_once '../lib/funciones.php';
require_once '../bd/publicacion.php';
require_once '../bd/libro.php';
require_once '../bd/publicacion.php';
session_start();

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
} else {
    header('Location: ../gestion_cuentas/login.php');
    die();
}

$tituloPagina = "Read&Meet | Home";
$activoHome = 'active';
$HojaCSS = "../css/estilo_home.css";

if ($usuario->administrador == 1) {
    require_once '../include/cabecera_home_admin.php';
} else {
    require_once '../include/cabecera_home_usuario.php';
}

$todas_las_publicaciones = Publicacion::todas_las_publicaciones();

?>

<div id="resultados" class="row">
    <?php foreach ($todas_las_publicaciones as $publicacion) : ?>
        <div class="tarjeta">
            <div class="informacion-usuario">
                <img id="imagen_perfil_nav" src="<?php echo Usuario::getRutaFotoObjeto($usuario) ?>" width="45" height="45">
                <div class="nombre-usuario"><?php echo $usuario->nombre_completo ?></div>
                <div class="fecha-publicacion"><?php echo $publicacion['fecha'] ?></div>
            </div>
            <div class="contenido-tarjeta">
                <p class="titulo-tarjeta"><?php echo $publicacion['texto'] ?></p>
            </div>
        </div>
    <?php endforeach; ?>


    <?php
    require_once "../include/script.php";
    ?>

    <?php
    require_once "../include/pie_normal.php";
    ?>