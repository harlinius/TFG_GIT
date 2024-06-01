<?php
require_once '../bd/bd.php';
require_once '../bd/like.php';
require_once '../bd/publicacion.php';
require_once '../bd/usuario.php';
session_start();

if (isset($_GET['id_publicacion']) && isset($_GET['id_usuario'])) {
    $id_publicacion = $_GET['id_publicacion'];
    $id_usuario = $_GET['id_usuario'];

    $publicacion = Publicacion::cargar_publicacion_id($id_publicacion);
    $usuario_publicacion = Usuario::cargaUsuarioId($publicacion->id_usuario);

    Likes::dar_like($id_publicacion, $id_usuario);
    header("Location: ../paginas_principales/perfil.php?usuario=" . $usuario_publicacion -> usuario);
}
else {
    echo "Acceso denegado. <a href='../gestion_cuentas/login.php' class='btn btn-secondary'>Volver</a>";
}
?>
