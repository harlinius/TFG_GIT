<?php
//cerrar sesion
require_once '../bd/usuario.php';
session_start();
session_destroy();

header('Location: login.php');

?>