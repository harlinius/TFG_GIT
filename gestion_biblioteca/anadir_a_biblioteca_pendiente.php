<?php
require_once '../bd/usuario.php';
require_once '../bd/libro.php';
require_once '../bd/biblioteca.php';
require_once '../bd/publicacion.php';
require_once '../lib/funciones.php';
session_start();

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
} else {
    header('Location: ../gestion_cuentas/login.php');
    die();
}

if (isset($_GET['id_libro'])) {
    $libro = Libro::cargaLibroId($_GET['id_libro']);
    Biblioteca::insertar_en_biblioteca_pendiente($libro,$usuario);
    $texto = $usuario->nombre_completo . " quiere leer:";
    Publicacion::insertar_publicacion($texto, $usuario->id_usuario, $_GET['id_libro']);
    header('Location: ../paginas_principales/libro.php?id='. $_GET['id_libro']);
}
else{
    echo "Acceso denegado. <a href='../gestion_cuentas/login.php' class='btn btn-secondary'>Volver</a>";
}