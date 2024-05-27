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
                        <a href="../gestion_biblioteca/empezar_a_leer.php?id_libro=<?php echo $libro->id_libro ?>" class="boton_empezar btn btn-primary btn-outline-light">
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
                        <form action="../gestion_biblioteca/actualizar_paginas.php?id_libro=<?php echo $libro->id_libro ?>" method="POST" class="row">
                            <label for="paginas_nuevo">Página actual</label>
                            <p></p>
                            <input type="number" class="form-control" id="paginas_nuevo" name="paginas_nuevo" min="0" max="<?php echo $libro->paginas ?>">
                            <p></p>
                            Páginas totales:
                            <p></p>
                            <?php echo $libro->paginas ?>
                            <button type="submit" class="boton_guardar_paginas btn btn-primary btn-outline-light">
                                Guardar
                            </button>
                        </form>
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
                    <div class="modal-body modal_valoracion">
                        <?php echo '<img class="img_portada_biblioteca" src="../portadas_libros/' . Libro::getRutaFotoArray($biblioteca) . '">' ?>
                        <div class="rating">
                            <input type="radio" id="star5" name="rate" value="5" />
                            <label for="star5" title="text">
                                <svg viewBox="0 0 576 512" height="1em" xmlns="http://www.w3.org/2000/svg" class="star-solid">
                                    <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                </svg>
                            </label>
                            <input type="radio" id="star4" name="rate" value="4" />
                            <label for="star4" title="text">
                                <svg viewBox="0 0 576 512" height="1em" xmlns="http://www.w3.org/2000/svg" class="star-solid">
                                    <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                </svg>
                            </label>
                            <input checked="" type="radio" id="star3" name="rate" value="3" />
                            <label for="star3" title="text">
                                <svg viewBox="0 0 576 512" height="1em" xmlns="http://www.w3.org/2000/svg" class="star-solid">
                                    <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                </svg>
                            </label>
                            <input type="radio" id="star2" name="rate" value="2" />
                            <label for="star2" title="text">
                                <svg viewBox="0 0 576 512" height="1em" xmlns="http://www.w3.org/2000/svg" class="star-solid">
                                    <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                </svg>
                            </label>
                            <input type="radio" id="star1" name="rate" value="1" />
                            <label for="star1" title="text">
                                <svg viewBox="0 0 576 512" height="1em" xmlns="http://www.w3.org/2000/svg" class="star-solid">
                                    <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path>
                                </svg>
                            </label>
                        </div>

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