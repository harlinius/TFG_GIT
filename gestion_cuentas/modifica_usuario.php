<?php
require_once '../bd/usuario.php';
require_once '../lib/funciones.php';
session_start();

if (isset($_SESSION['usuario'])) {
    $usuario_sesion = $_SESSION['usuario'];
} else {
    header('Location: login.php');
    die();
}

$errores = []; // Crea un array para los errores

if (empty($_POST['nombre_completo'])) { // Si está vacío o no definido
    $errores['nombre_completo'] = "Nombre completo requerido"; // Se añade el error "nombre" al array de errores
}

if (empty($_POST['usuario'])) { // Si está vacío
    $errores['usuario'] = "Nombre de usuario requerido"; // Se añade el error "login" al array de errores si no hay nada puesto
} else { // Si no está vacío
    $usuario_comprobar = Usuario::cargaLogin($_POST['usuario']);

    if ($usuario_comprobar && $usuario_comprobar->usuario != $usuario_sesion->usuario) { // Si el usuario existe y no es el mismo que el usuario que quieres cambiar
        $errores['usuario'] = "Ya existe un usuario con este nombre"; // Se añade el error "login" al array de errores si ya hay un usuario con ese nombre
    }
}

$foto_perfil = $_FILES['foto_perfil'];
$destino_foto = $usuario_sesion->foto_perfil; // Por defecto mantiene la foto actual

if ($foto_perfil['error'] == UPLOAD_ERR_OK) {
    if (str_starts_with($foto_perfil['type'], 'image/')) {
        $destino_foto = '../imagenes_perfil/' . $_POST['usuario'] . '.' . pathinfo($foto_perfil['name'], PATHINFO_EXTENSION);
        move_uploaded_file($foto_perfil['tmp_name'], $destino_foto);
    } else {
        $errores['foto_perfil'] = 'La foto no es una imagen válida';
    }
} else if ($foto_perfil['error'] != UPLOAD_ERR_NO_FILE) { // Si no sube foto se mantiene la que tenía
    $errores['foto_perfil'] = 'Error subiendo foto';
}

if (!empty($_POST['contrasena'])) { // Si el campo está relleno
    $contrasena = $_POST['contrasena'];
} else {
    $contrasena = $usuario_sesion->contrasena; // Mantiene la contraseña actual
}

if (count($errores) > 0) { // Si hay errores redirige a miCuenta otra vez
    $_SESSION['errores'] = $errores;
    $_SESSION['datos'] = [
        'nombre_completo' => $_POST['nombre_completo'],
        'email' => $usuario_sesion->email,
        'foto_perfil' => $destino_foto,
        'usuario' => $_POST['usuario'],
        'contrasena' => ''
    ];
    header("Location: editar_mi_cuenta.php");
} else { // Si no hay errores actualiza los datos
    $usuario_sesion->nombre_completo = $_POST['nombre_completo'];
    $usuario_sesion->usuario = $_POST['usuario'];
    $usuario_sesion->contrasena = $contrasena;
    $usuario_sesion->foto_perfil = $destino_foto;
    $usuario_sesion->actualizar();
    $_SESSION['usuario'] = $usuario_sesion;

    header('Location: ../paginas_principales/home.php');
}
