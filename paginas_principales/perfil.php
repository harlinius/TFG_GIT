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

if (isset($_GET["estado"])) {
    $bibliotecas = Biblioteca::biblioteca_usuario_filtrada($usuario_perfil, $_GET["estado"]);
} else {
    $bibliotecas = Biblioteca::biblioteca_usuario($usuario_perfil);
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
        <p><?php echo 'Seguidores: ' . Seguidores::seguidores_usuario($usuario_perfil->id_usuario) ?></p>
    </div>
    <div class="botones_seguir">
        <?php if (Seguidores::comprobar_si_sigue($usuario->id_usuario, $usuario_perfil->id_usuario) == false && $usuario_perfil != $usuario) {
            echo '<a class="boton_seguir btn btn-primary btn-outline-light" href="../gestion_seguimiento/seguir.php?id_seguido=' . $usuario_perfil->id_usuario . '">
                    Seguir
                </a>';
        } else if ($usuario_perfil != $usuario) {
            echo '<a class="boton_dejar_de_seguir btn btn-secondary btn-outline-light" href="../gestion_seguimiento/dejar_de_seguir.php?id_seguido=' . $usuario_perfil->id_usuario . '">
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
<div class="row">
    <p></p>
    <div class="col-6 offset-md-4">
        <a class="estado_libro_selector" href="perfil.php?usuario=<?php echo $usuario_perfil->usuario ?>&ver=publicaciones">
            Publicaciones
        </a>
        <a class="estado_libro_selector" href="perfil.php?usuario=<?php echo $usuario_perfil->usuario ?>&ver=biblioteca">
            Biblioteca
        </a>
    </div>
</div>
<div id="resultados" class="row">

<?php if (!isset($_GET['ver']) || $_GET['ver'] == 'publicaciones') { ?>

    <div class="col-lg-12 col-md-12">
        <?php foreach ($publicaciones_usuario as $publicacion) :
            $libro = Libro::cargaLibroId($publicacion['id_libro']);
            $usuario_publicacion = Usuario::cargaUsuarioId($publicacion['id_usuario']); ?>
            <div class="tarjeta">
                <div class="contenido-tarjeta">
                    <div class="informacion-usuario">
                        <a title="Ir al perfil" href="perfil.php?usuario=<?php echo $usuario_publicacion->usuario ?>" title="Perfil">
                            <img id="imagen_perfil_nav" src="<?php echo Usuario::getRutaFotoObjeto($usuario_publicacion) ?>" width="45" height="45">
                        </a>
                        <div class="nombre-usuario"><?php echo $usuario_publicacion->nombre_completo ?></div>
                    </div>
                    <p class="titulo-tarjeta"><?php echo $publicacion['texto'] . ' ' . $libro->titulo ?></p>
                    <div class="fecha-publicacion"><?php echo formateaFecha($publicacion['fecha']) ?></div>

                    <a <?php if (Likes::hay_like($publicacion['id_publicacion'], $usuario->id_usuario) == 1) {
                            echo "hidden";
                        }
                        ?> class="corazones" title="Dar like" href="../gestion_likes/dar_like2.php?id_publicacion=<?php echo $publicacion['id_publicacion'] ?>&id_usuario=<?php echo $usuario->id_usuario ?>">

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
                        ?> class="corazones" title="Quitar like" href="../gestion_likes/quitar_like2.php?id_publicacion=<?php echo $publicacion['id_publicacion'] ?>&id_usuario=<?php echo $usuario->id_usuario ?>">
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
<?php }
    
    if (isset($_GET['ver']) && $_GET['ver'] == 'biblioteca') {
        
        ?>
    <div class="col-lg-12 col-md-12">
        <div class="row enlaces_bib_div">
            <div class="col-lg-12 col-md-12 mb-12 enlaces_biblioteca">
                <a class="estado_libro_selector" href="perfil.php?usuario=<?php echo $usuario_perfil->usuario ?>">
                    Todo
                </a>
                <a class="estado_libro_selector" href="perfil.php?usuario=<?php echo $usuario_perfil->usuario ?>&ver=biblioteca&estado=Pendiente">
                    Pendiente
                </a>
                <a class="estado_libro_selector" href="perfil.php?usuario=<?php echo $usuario_perfil->usuario ?>&ver=biblioteca&estado=Leyendo">
                    Leyendo
                </a>
                <a class="estado_libro_selector" href="perfil.php?usuario=<?php echo $usuario_perfil->usuario ?>&ver=biblioteca&estado=Acabado">
                    Acabado
                </a>
            </div>
        </div>
        <div id="resultados" class="row">
            <?php foreach ($bibliotecas as $biblioteca) :
                $libro = Libro::cargaLibroId($biblioteca['id_libro']); ?>
                <div class="card">
                    <?php echo '<img class="img_portada_biblioteca" src="../portadas_libros/' . Libro::getRutaFotoArray($biblioteca) . '">' ?>
                    <div class="card__content">
                        <p class="card__title"><?php echo '<a title="Ir al libro" href="libro.php?id=' . $libro->id_libro . '">' . $libro->titulo . '</a>' ?>
                        </p>
                        <p class="card__description">
                            <?php echo e($biblioteca['estado']) ?>
                        </p>
                        <?php if ($biblioteca['estado'] == "Leyendo") { ?>
                            <p class="card__description">
                                <?php echo e($biblioteca['progreso']) . ' / ' . $libro->paginas; ?>
                            </p>
                        <?php } else if ($biblioteca['estado'] == "Pendiente") { ?>
                            <p class="card_description">
                                Pendiente de leer
                            </p>
                        <?php } else if ($biblioteca['estado'] == "Acabado") { ?>
                            <p class="card_description">
                                <?php if ($biblioteca['valoracion'] != null) {
                                    echo 'Valoración actual: ' . $biblioteca['valoracion'] . ' <i class="bi bi-star-fill"></i>';
                                } else {
                                    echo 'No valorado.';
                                } ?>
                            </p>
                        <?php }  ?>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php } ?>
</div>



<?php
require_once "../include/script.php";
?>

<?php
require_once "../include/pie_normal.php";
?>