<?php
require_once '../bd/usuario.php';
require_once '../bd/libro.php';
require_once '../bd/biblioteca.php';
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
    Biblioteca::empezar_a_leer($libro,$usuario);
    header('Location: ../paginas_principales/biblioteca.php');
}
else{
    echo "Acceso denegado. <a href='../gestion_cuentas/login.php' class='btn btn-secondary'>Volver</a>";
}