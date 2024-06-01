<?php
require_once '../bd/usuario.php';
require_once '../bd/publicacion.php';
require_once '../bd/libro.php';
require_once '../bd/usuario.php';
require_once '../bd/like.php';
require_once '../lib/funciones.php';
session_start();

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
} else {
    header('Location: ../gestion_cuentas/login.php');
    die();
}

$tituloPagina = "Read&Meet | Seguidos";
$activoSeguidos = 'active';
$HojaCSS = "../css/estilo_seguidos.css";

if ($usuario->administrador == 1) {
    require_once '../include/cabecera_home_admin.php';
} else {
    require_once '../include/cabecera_home_usuario.php';
}

$pub_seguidos = Publicacion::publicaciones_seguidos($usuario->id_usuario);

?>


<div id="resultados" class="row">
    <?php foreach ($pub_seguidos as $publicacion) :
        $libro = Libro::cargaLibroId($publicacion['id_libro']);
        $usuario_publicacion = Usuario::cargaUsuarioId($publicacion['id_usuario']); ?>
        <div class="tarjeta">
            <div class="contenido-tarjeta">
                <div class="informacion-usuario">
                    <a title="Ir al perfil" href="perfil.php?usuario=<?php echo $usuario_publicacion->usuario ?>" title="Perfil">
                        <img id="imagen_perfil_nav" src="<?php

                                                            echo Usuario::getRutaFotoObjeto($usuario_publicacion) ?>" width="45" height="45">
                    </a>
                    <div class="nombre-usuario"><?php echo $usuario_publicacion->nombre_completo ?></div>
                </div>
                <p class="titulo-tarjeta"><?php echo $publicacion['texto'] . ' ' . $libro->titulo ?></p>
                <div class="fecha-publicacion"><?php echo formateaFecha($publicacion['fecha']) ?></div>

                <a <?php if (Likes::hay_like($publicacion['id_publicacion'], $usuario->id_usuario) == 1) {
                        echo "hidden";
                    }
                    ?> class="corazones" title="Dar like" href="../gestion_likes/dar_like.php?id_publicacion=<?php echo $publicacion['id_publicacion'] ?>&id_usuario=<?php echo $usuario->id_usuario ?>">

                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi2 bi-heart" viewBox="0 0 16 16">
                        <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 
                        3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 
                        4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15" />
                    </svg>

                    <p class="numero_likes"><?php echo Likes::contarLikes($publicacion['id_publicacion']) ?></p>

                </a>
                <a <?php if (Likes::hay_like($publicacion['id_publicacion'], $usuario->id_usuario) == 0) {
                        echo "hidden";
                    }
                    ?> class="corazones" title="Quitar like" href="../gestion_likes/quitar_like.php?id_publicacion=<?php echo $publicacion['id_publicacion'] ?>&id_usuario=<?php echo $usuario->id_usuario ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi2 bi-heart-fill" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314" />
                    </svg>
                    <p class="numero_likes"><?php echo Likes::contarLikes($publicacion['id_publicacion']) ?></p>
                </a>

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