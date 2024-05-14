<?php
require_once '../bd/bd.php';
require_once '../bd/usuario.php';

$login = $_POST['usuario'];

$usuario = Usuario::cargaLogin($login);
if ($login == $usuario->usuario) {
    echo "DUPLICADO";
}
else {
    echo "OK";
}
