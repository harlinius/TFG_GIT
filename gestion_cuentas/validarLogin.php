<?php
require_once '../bd/bd.php';
require_once '../bd/usuario.php';

session_start();


//si hay session que salte solo si existe un usuario con diferente usuario que el de sesion
if (isset($_POST['usuario'])) {
    if (isset($_SESSION['usuario'])) {
        $usuario_comprobar = Usuario::cargaLogin($_POST['usuario']);
        if (
            $usuario_comprobar && $_POST['usuario'] == $usuario_comprobar->usuario
            && $_POST['usuario'] != $_SESSION['usuario']->usuario
        ) {
            echo "DUPLICADO";
        } else {
            echo "OK";
        }
    } else {
        $login = $_POST['usuario'];
        $usuario = Usuario::cargaLogin($login);

        if ($usuario && $login == $usuario->usuario) {
            echo "DUPLICADO";
        } else {
            echo "OK";
        }
    }
} else {
    echo "Acceso denegado. <a href='login.php' class='btn btn-secondary'>Volver</a>";
}
