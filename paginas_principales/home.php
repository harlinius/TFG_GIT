<?php
require_once '../bd/usuario.php';
require_once '../lib/funciones.php';
session_start();

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
}
else {
    header('Location: login.php');
    die();
}

$tituloPagina = "Read&Meet | Home";
include __DIR__.'../include/cabecera_home.php';
?>