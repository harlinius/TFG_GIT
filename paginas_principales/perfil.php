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

$tituloPagina = "Read&Meet | " . $usuario->usuario;
$activoPerfil = 'active';
$HojaCSS = "../css/estilo_perfil.css";

if ($usuario->administrador == 1) {
    require_once '../include/cabecera_home_admin.php';
} else {
    require_once '../include/cabecera_home_usuario.php';
}

$todas_las_publicaciones = Publicacion::todas_las_publicaciones();

?>

<?php
require_once "../include/script.php";
?>

<?php
require_once "../include/pie_normal.php";
?>