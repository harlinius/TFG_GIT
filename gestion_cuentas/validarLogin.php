<?php
require_once '../bd/bd.php';
require_once '../bd/usuario.php';

if (isset($_POST['usuario'])) {
    $login = $_POST['usuario'];
    $usuario = Usuario::cargaLogin($login);
    if ($login == $usuario->usuario) {
        echo "DUPLICADO";
    } else {
        echo "OK";
    }
} else {
    echo "Acceso denegado. <a href='login.php' class='btn btn-secondary'>Volver</a>";
}