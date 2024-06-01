<?php
require_once '../bd/usuario.php';
require_once '../lib/funciones.php';
require_once '../bd/publicacion.php';
require_once '../bd/libro.php';
require_once '../bd/seguidores.php';
require_once '../bd/biblioteca.php';
require_once '../bd/like.php';
session_start();

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
    if ($usuario->administrador != 1) {
        header('Location: ../gestion_cuentas/login.php');
        die();
    } 
} else {
    header('Location: ../gestion_cuentas/login.php');
    die();
}

$tituloPagina = "Read&Meet | Administración";
$activoAdmin = 'active';
$HojaCSS = "../css/estilo_admin.css";

require_once '../include/cabecera_home_admin.php';


?>


<?php
require_once "../include/script.php";
?>

<?php
require_once "../include/pie_normal.php";
?>