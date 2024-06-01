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
} else {
    header('Location: ../gestion_cuentas/login.php');
    die();
}

$usuario_perfil = Usuario::cargaLogin($_GET['usuario']);

$tituloPagina = "Read&Meet | " . $usuario_perfil->usuario;

if ($usuario_perfil == $usuario) {
    $activoPerfil = 'active';
}


$HojaCSS = "../css/estilo_perfil.css";

if ($usuario->administrador == 1) {
    require_once '../include/cabecera_home_admin.php';
} else {
    require_once '../include/cabecera_home_usuario.php';
}

$publicaciones_usuario = Publicacion::publicaciones_usuario($usuario_perfil->id_usuario);
?>
<div class="perfil-container text-center">
    <div class="imagen">
        <img class="imagen_perfil" src="<?php echo Usuario::getRutaFotoObjeto($usuario_perfil) ?>" alt="Foto de perfil">
    </div>
    <div class="info_perfil">
        <h1><?php echo e($usuario_perfil->nombre_completo) ?></h1>
        <p><?php if ($usuario_perfil->administrador == 1) {
                echo 'Administrador de Read&Meet';
            } ?></p>
        <p><?php echo 'Seguidores: ' . Seguidores::seguidores_usuario($usuario_perfil->id_usuario)?></p>
    </div>
    <div class="botones_seguir">
        <?php if (Seguidores::comprobar_si_sigue($usuario->id_usuario, $usuario_perfil->id_usuario) == false && $usuario_perfil!= $usuario) {
            echo '<a class="boton_seguir btn btn-primary btn-outline-light" href="../gestion_seguimiento/seguir.php?id_seguido='. $usuario_perfil->id_usuario .'">
                    Seguir
                </a>';
        } else if ($usuario_perfil!= $usuario){
            echo '<a class="boton_dejar_de_seguir btn btn-secondary btn-outline-light" href="../gestion_seguimiento/dejar_de_seguir.php?id_seguido='. $usuario_perfil->id_usuario .'">
                    Dejar de seguir
                </a>';
        }
        if ($usuario_perfil == $usuario) {
            echo '<a class="boton_editar btn btn-secondary btn-outline-light" href="../gestion_cuentas/editar_mi_cuenta.php">
                   Editar mi cuenta
                </a>';
        }
        ?>

    </div>
</div>



<?php
require_once "../include/script.php";
?>

<?php
require_once "../include/pie_normal.php";
?>