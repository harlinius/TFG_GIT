<?php
require_once '../bd/bd.php';
require_once '../bd/like.php';
session_start();


if (isset($_GET['id_publicacion']) && isset($_GET['id_usuario'])) {
    $id_publicacion = $_GET['id_publicacion'];
    $id_usuario = $_GET['id_usuario'];

    Likes::quitar_like($id_publicacion, $id_usuario);
    header("Location: ../paginas_principales/home.php");  // Redirigir de nuevo a la página principal
}
else {
    echo "Acceso denegado. <a href='../gestion_cuentas/login.php' class='btn btn-secondary'>Volver</a>";
}
?>