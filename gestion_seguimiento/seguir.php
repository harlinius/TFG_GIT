<?php
require_once '../bd/usuario.php';
require_once '../bd/seguidores.php';
require_once '../lib/funciones.php';
session_start();

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
} else {
    header('Location: ../gestion_cuentas/login.php');
    die();
}

if (isset($_GET['id_seguido'])) {
    Seguidores::seguir( $usuario->id_usuario, $_GET['id_seguido']);
    $usuario_seguido = Usuario::cargaUsuarioId($_GET['id_seguido']);
    header('Location: ../paginas_principales/perfil.php?usuario='. $usuario_seguido->usuario);
}
else{
    echo "Acceso denegado. <a href='../gestion_cuentas/login.php' class='btn btn-secondary'>Volver</a>";
}