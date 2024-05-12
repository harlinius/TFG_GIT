<?php
require_once '../bd/usuario.php';
session_start();

$usuario_post = $_POST['usuario'];
$contrasena_post = $_POST['contrasena'];

$usuario = Usuario::cargaLogin($usuario_post);

if ($usuario) {
    if (password_verify($contrasena_post, $usuario->contrasena_post)) {
        $_SESSION['usuario'] = $usuario;
        header('Location: home.php');
        die();
    }
}
$_SESSION['error-login'] = "Usuario o contraseña incorrectos";
header('Location: login.php');
?>