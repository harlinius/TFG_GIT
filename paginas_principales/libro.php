<?php
require_once '../bd/usuario.php';
require_once '../bd/libro.php';
require_once '../lib/funciones.php';
session_start();

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
} else {
    header('Location: ../gestion_cuentas/login.php');
    die();
}

if (isset($_GET['id'])) {
    $libro = Libro::cargaLibroId($_GET['id']);
}

$tituloPagina = "Read&Meet | Buscar";
$HojaCSS = "../css/estilo_libro.css";

if ($usuario->administrador == 1) {
    require_once '../include/cabecera_home_admin.php';
} else {
    require_once '../include/cabecera_home_usuario.php';
}
?>



<?php
require_once "../include/script.php";
?>

<?php
require_once "../include/pie_normal.php";
?>