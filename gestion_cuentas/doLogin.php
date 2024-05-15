<?php
require_once '../bd/usuario.php';
session_start();

if (isset($_POST['usuario'])) {
    $usuario_post = $_POST['usuario'];
    $contrasena_post = $_POST['contrasena'];

    $usuario = Usuario::cargaLogin($usuario_post);

    if ($usuario) {
        if ($usuario->contrasena == $contrasena_post) {
            $_SESSION['usuario'] = $usuario;
            header('Location: ../paginas_principales/home.php');
            die();
        }
    }
    $_SESSION['error-login'] = "Usuario o contraseña incorrectos";
    header('Location: login.php');
} else {
    echo "Acceso denegado. <a href='login.php' class='btn btn-secondary'>Volver</a>";
}
