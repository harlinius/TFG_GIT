<?php
require_once '../bd/usuario.php';
require_once '../bd/libro.php';
require_once '../bd/biblioteca.php';
require_once '../lib/funciones.php';
require_once '../bd/publicacion.php';
session_start();

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
} else {
    header('Location: ../gestion_cuentas/login.php');
    die();
}

if (isset($_GET['id_libro'])) {
    if (!isset($_POST['rate'])){
        $valoracion = 0;
    }
    else{
        $valoracion = $_POST['rate'];
    }
    $libro = Libro::cargaLibroId($_GET['id_libro']);
    Biblioteca::actualizar_valoracion($valoracion,$libro,$usuario);
    $texto = " ha valorado:";
    Publicacion::insertar_publicacion($texto, $usuario->id_usuario, $_GET['id_libro']);
    header('Location: ../paginas_principales/biblioteca.php');
}
else{
    echo "Acceso denegado. <a href='../gestion_cuentas/login.php' class='btn btn-secondary'>Volver</a>";
}