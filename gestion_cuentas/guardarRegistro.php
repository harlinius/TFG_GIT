<?php

require_once '../bd/usuario.php';
session_start();

$usuario = new Usuario();
$usuario->nombre_completo = $_POST['nombre_completo'];
$usuario->usuario = $_POST['usuario'];
$usuario->contrasena = $_POST['contrasena'];

$errores = []; //crea un array para los errores
if ($usuario->nombre_completo == '') { //si está vacío
    $errores['nombre_completo'] = "Nombre completo requerido"; //da a nombre el valor "Nombre completo requerido"
}
if ($usuario->usuario == '') {
    $errores['usuario'] = "Nombre de usuario requerido";
}
else {
    $existente = Usuario::cargaLogin($usuario->usuario);
    if ($existente) {
        $errores['usuario'] = "Ya existe un usuario con este nombre";
    }
}
if ($usuario->contrasena == '') {
    $errores['contrasena'] = "Contraseña requerida";
}

if (count($errores) > 0) { //si hay errores redirige a registro otra vez
    $_SESSION['errores'] = $errores;
    $_SESSION['datos'] = $usuario;
    header("Location: crearCuenta.php");
}
else { //si no, pasa al index (mis contactos)
    $usuario->insertar();
    $_SESSION['usuario'] = $usuario;
    header('Location: ../paginas_principales/home.php');
}

?>

