<?php
require_once '../bd/usuario.php';
require_once '../lib/funciones.php';
require_once '../bd/publicacion.php';
require_once '../bd/libro.php';
require_once '../bd/publicacion.php';
session_start();

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
} else {
    header('Location: ../gestion_cuentas/login.php');
    die();
}

$tituloPagina = "Read&Meet | Home";
$activoHome = 'active';
$HojaCSS = "../css/estilo_home.css";

if ($usuario->administrador == 1) {
    require_once '../include/cabecera_home_admin.php';
} else {
    require_once '../include/cabecera_home_usuario.php';
}

$todas_las_publicaciones = Publicacion::todas_las_publicaciones();

?>

<div id="resultados" class="row">
    <?php foreach ($todas_las_publicaciones as $publicacion) :
        $libro = Libro::cargaLibroId($publicacion['id_libro']);
        $usuario_publicacion = Usuario::cargaUsuarioId($publicacion['id_usuario']); ?>
        <div class="tarjeta">
            <div class="contenido-tarjeta">
                <div class="informacion-usuario">
                    <a title="Ir al perfil" href="perfil.php?usuario=<?php echo $usuario_publicacion->usuario ?>" title="Perfil">
                        <img id="imagen_perfil_nav" src="<?php 
                        
                        echo Usuario::getRutaFotoObjeto($usuario_publicacion) ?>" width="45" height="45">
                    </a>
                    <div class="nombre-usuario"><?php echo $usuario->nombre_completo ?></div>
                </div>
                <p class="titulo-tarjeta"><?php echo $publicacion['texto'] . ' ' . $libro->titulo ?></p>
                <div class="fecha-publicacion"><?php echo formateaFecha($publicacion['fecha']) ?></div>
            </div>
            <div class="imagen-portada">
                <a title="Ir al libro" href="libro.php?id=<?php echo $libro->id_libro ?>">
                    <img src="../portadas_libros/<?php echo Libro::getRutaFotoObjeto($libro) ?>" width="100" height="150">
                </a>
            </div>
        </div>
    <?php endforeach; ?>
</div>


<?php
require_once "../include/script.php";
?>

<?php
require_once "../include/pie_normal.php";
?>