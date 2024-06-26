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

$errores = []; // crea un array para los errores

if (empty($_POST['nombre_completo'])) { // si está vacío o no definido
    $errores['nombre_completo'] = "Nombre completo requerido"; // se añade el error "nombre" al array de errores
}

if (empty($_POST['usuario'])) { // si está vacío
    $errores['usuario'] = "Nombre de usuario requerido"; // se añade el error "login" al array de errores si no hay nada puesto
} else { // Si no está vacío
    $usuario_comprobar = Usuario::cargaLogin($_POST['usuario']);

    if ($usuario_comprobar && $usuario_comprobar->usuario != $usuario_sesion->usuario) { // si el usuario existe y no es el mismo que el usuario que quieres cambiar
        $errores['usuario'] = "Ya existe un usuario con este nombre"; // se añade el error "login" al array de errores si ya hay un usuario con ese nombre
    }
}

$foto_perfil = $_FILES['foto_perfil'];
$destino_foto = $usuario_sesion->foto_perfil; // por defecto mantiene la foto actual

if ($foto_perfil['error'] == UPLOAD_ERR_OK) {
    if (str_starts_with($foto_perfil['type'], 'image/')) {
        $nuevo_destino_foto = '../imagenes_perfil/' . $_POST['usuario'] . '.' . pathinfo($foto_perfil['name'], PATHINFO_EXTENSION);

        // eliminar la foto anterior si existe y es diferente de la predeterminada
        if (file_exists($destino_foto) && $destino_foto !== '../imagenes_perfil/default.jpg') {
            unlink($destino_foto);
        }

        // mover la nueva foto
        move_uploaded_file($foto_perfil['tmp_name'], $nuevo_destino_foto);
        $destino_foto = $nuevo_destino_foto;
    } else {
        $errores['foto_perfil'] = 'La foto no es una imagen válida';
    }
} else if ($foto_perfil['error'] != UPLOAD_ERR_NO_FILE) { //si no sube foto se mantiene la que tenía
    $errores['foto_perfil'] = 'Error subiendo foto';
}

if (!empty($_POST['contrasena'])) { // si el campo está relleno
    $contrasena = $_POST['contrasena'];
} else {
    $contrasena = $usuario_sesion->contrasena; // mantiene la contraseña actual
}

if (count($errores) > 0) { // si hay errores redirige a miCuenta otra vez
    $_SESSION['errores'] = $errores;
    $_SESSION['datos'] = [
        'nombre_completo' => $_POST['nombre_completo'],
        'foto_perfil' => $destino_foto,
        'usuario' => $_POST['usuario'],
        'contrasena' => ''
    ];
    header("Location: editar_mi_cuenta.php");
} else { // si no hay errores actualiza los datos
    $usuario_sesion->nombre_completo = $_POST['nombre_completo'];
    $usuario_sesion->usuario = $_POST['usuario'];
    $usuario_sesion->contrasena = $contrasena;
    $usuario_sesion->foto_perfil = $destino_foto;
    $usuario_sesion->actualizar();
    $_SESSION['usuario'] = $usuario_sesion;

    header('Location: ../paginas_principales/home.php');
}
