<?php
require_once '../bd/usuario.php';
require_once '../bd/libro.php';
require_once '../bd/biblioteca.php';
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

$tituloPagina = "Read&Meet | $libro->titulo";
$HojaCSS = "../css/estilo_libro.css";
$esta_biblioteca = Biblioteca::BuscaLibroEnBiblioteca($libro);

if ($usuario->administrador == 1) {
    require_once '../include/cabecera_home_admin.php';
} else {
    require_once '../include/cabecera_home_usuario.php';
}
?>

<div id="bloque_libro" class="row">
    <div class="titulo_libro col-lg-12">
        <h1><?php echo "$libro->titulo" ?></h1>
    </div>
    <div class="botones col-lg-12">
        <?php if (!isset($esta_biblioteca)) { 
            echo ('
            <a href="../gestion_biblioteca/anadir_a_biblioteca.php?id_libro=<?php echo $libro->id_libro ?>" class="btn no_pendiente">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark-star-fill" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M2 15.5V2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.74.439L8 13.069l-5.26 2.87A.5.5 0 0 1 2 15.5M8.16 4.1a.178.178 0 0 0-.32 0l-.634 1.285a.18.18 0 0 1-.134.098l-1.42.206a.178.178 0 0 0-.098.303L6.58 6.993c.042.041.061.1.051.158L6.39 8.565a.178.178 0 0 0 .258.187l1.27-.668a.18.18 0 0 1 .165 0l1.27.668a.178.178 0 0 0 .257-.187L9.368 7.15a.18.18 0 0 1 .05-.158l1.028-1.001a.178.178 0 0 0-.098-.303l-1.42-.206a.18.18 0 0 1-.134-.098z" />
                </svg>
                Guardar como pendiente
            </a>');
        } 
        else {
            echo ('
            <a href="../gestion_biblioteca/quitar_de_biblioteca.php?id_libro=<?php echo $libro->id_libro ?>" class="btn pendiente">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark-star-fill" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M2 15.5V2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.74.439L8 13.069l-5.26 2.87A.5.5 0 0 1 2 15.5M8.16 4.1a.178.178 0 0 0-.32 0l-.634 1.285a.18.18 0 0 1-.134.098l-1.42.206a.178.178 0 0 0-.098.303L6.58 6.993c.042.041.061.1.051.158L6.39 8.565a.178.178 0 0 0 .258.187l1.27-.668a.18.18 0 0 1 .165 0l1.27.668a.178.178 0 0 0 .257-.187L9.368 7.15a.18.18 0 0 1 .05-.158l1.028-1.001a.178.178 0 0 0-.098-.303l-1.42-.206a.18.18 0 0 1-.134-.098z" />
                </svg>
                Eliminar de la biblioteca
            </a>
            ');}
        ?>
    </div>
    <div class="portada_libro col-lg-12 ">
        <img class="img_portada" src="../portadas_libros/<?php echo "$libro->portada" ?>">
    </div>
    <div class="resumen_libro col-lg-12 ">
        <p>
            <?php echo $libro->sinopsis ?>
        </p>
    </div>
</div>


<?php
require_once "../include/script.php";
?>

<?php
require_once "../include/pie_normal.php";
?>