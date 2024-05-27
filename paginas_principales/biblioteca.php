<?php
require_once '../bd/usuario.php';
require_once '../lib/funciones.php';
require_once '../bd/libro.php';
require_once '../bd/biblioteca.php';
session_start();

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
} else {
    header('Location: ../gestion_cuentas/login.php');
    die();
}

$tituloPagina = "Read&Meet | Biblioteca";
$activoBiblioteca = 'active';
$HojaCSS = "../css/estilo_biblioteca.css";


if (isset($_GET["estado"])) {
    $bibliotecas = Biblioteca::biblioteca_usuario_filtrada($usuario, $_GET["estado"]);
} else {
    $bibliotecas = Biblioteca::biblioteca_usuario($usuario);
}

if ($usuario->administrador == 1) {
    require_once '../include/cabecera_home_admin.php';
} else {
    require_once '../include/cabecera_home_usuario.php';
}
?>

<div class="row enlaces_bib_div">
    <div class="col-lg-12 col-md-12 mb-12 enlaces_biblioteca">
        <a class="estado_libro_selector" href="biblioteca.php">
            Todo
        </a>
        <a class="estado_libro_selector" href="biblioteca.php?estado=Pendiente">
            Pendiente
        </a>
        <a class="estado_libro_selector" href="biblioteca.php?estado=Leyendo">
            Leyendo
        </a>
        <a class="estado_libro_selector" href="biblioteca.php?estado=Acabado">
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
                <p class="card__title"><?php echo e($libro->titulo) ?>
                </p>
                <p class="card__description">
                    <?php echo e($biblioteca['estado']) ?>
                </p>
                <?php if ($biblioteca['estado'] == "Leyendo") { ?>
                    <p class="card__description">
                        <?php echo e($biblioteca['progreso']) . ' / ' . $libro->paginas; ?>
                    </p>
                    <p class="card_description">
                        <a class="boton_editar btn btn-primary btn-outline-light" data-bs-toggle="modal" data-bs-target="#modalEditarLibro<?= $libro->id_libro ?>">
                            Editar progreso
                        </a>
                    </p>
                <?php } else if ($biblioteca['estado'] == "Pendiente") { ?>
                    <p class="card_description">
                        <a href="../gestion_biblioteca/empezar_a_leer.php?id_libro=1" class="boton_empezar btn btn-primary btn-outline-light">
                            Empezar a leer
                        </a>
                    </p>
                <?php } else if ($biblioteca['estado'] == "Acabado") { ?>
                    <p class="card_description">
                        <a class="boton_valorar btn btn-primary btn-outline-light" data-bs-toggle="modal" data-bs-target="#modalValorarLibro<?= $libro->id_libro ?>">
                            Valorar
                        </a>
                    </p>
                <?php }  ?>

            </div>
        </div>
        <div class="modal fade" id="modalEditarLibro<?= $libro->id_libro ?>">
            <div class="modal-dialog">
                <div class="modal-content text-start">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5"><?php echo $libro->titulo ?></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">

                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalValorarLibro<?= $libro->id_libro ?>">
            <div class="modal-dialog">
                <div class="modal-content text-start">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Valorar "<?php echo $libro->titulo ?>"</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">

                    </div>
                </div>
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