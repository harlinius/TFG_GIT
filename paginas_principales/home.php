<?php
require_once '../bd/usuario.php';
require_once '../lib/funciones.php';
session_start();

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
}
else {
    header('Location: ../gestion_cuentas/login.php');
    die();
}

$tituloPagina = "Read&Meet | Home";

if ($usuario->administrador == 1){
    require_once '../include/cabecera_home_admin.php';
}
else{
    require_once '../include/cabecera_home_usuario.php';
}
?>

<?php 
    echo $usuario->administrador;
?>

<a class="dropdown-item" href="../gestion_cuentas/logout.php">Cerrar sesión</a>

<?php
require_once "../include/script.php";
?>

<?php
require_once "../include/pie_normal.php";
?>