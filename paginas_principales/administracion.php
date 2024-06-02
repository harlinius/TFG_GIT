<?php
require_once '../bd/usuario.php';
require_once '../lib/funciones.php';
require_once '../bd/publicacion.php';
require_once '../bd/libro.php';
require_once '../bd/like.php';
session_start();

if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];
} else {
    header('Location: ../gestion_cuentas/login.php');
    die();
}

if (isset($_SESSION['errores'])) {
    $errores = $_SESSION['errores'];
    $datos = $_SESSION['datos'];
    unset($_SESSION['errores']);
    unset($_SESSION['datos']);
} else {
    $errores = [];
    $datos = [
        'titulo' => '',
        'portada' => '',
        'sinopsis' => '',
        'autor' => '',
        'paginas' => ''
    ];
}

$tituloPagina = "Read&Meet | Añadir libro";
$HojaCSS = "../css/estilo_editar_cuenta.css";

if ($usuario->administrador == 1) {
    require_once '../include/cabecera_home_admin.php';
} else {
    require_once '../include/cabecera_home_usuario.php';
}
?>

<form action="../gestion_biblioteca/anade_libro.php" method="POST" class="row g-3" enctype="multipart/form-data">
    <div class="col-md-10 offset-md-1">
        <h1>Añade un libro al sitio</h1>
        <label class="form-label" for="titulo">Título</label>
        <input type="text" id="titulo" name="titulo" class="form-control <?php if (isset($errores['titulo'])) echo 'is-invalid'; ?>" placeholder="Título" value="<?= e($datos['titulo']) ?>" />
        <?php if (isset($errores['titulo'])) : ?>
            <div class="invalid-feedback">
                <?= e($errores['titulo']) ?>
            </div>
        <?php endif; ?>
        <p></p>
        <label for="portada" class="form-label">Portada:</label>
        <input type="file" class="form-control <?php if (isset($errores['portada'])) echo 'is-invalid'; ?>" id="portada" name="portada" />
        <?php if (isset($errores['portada'])) : ?>
            <div class="invalid-feedback">
                <?= e($errores['portada']) ?>
            </div>
        <?php endif; ?>
        <p></p>
        <label class="form-label" for="sinopsis">Sinopsis</label>
        <input type="text" id="sinopsis" name="sinopsis" class="form-control <?php if (isset($errores['sinopsis'])) echo 'is-invalid'; ?>" placeholder="Sinopsis" value="<?= e($datos['sinopsis']) ?>" />
        <?php if (isset($errores['sinopsis'])) : ?>
            <div class="invalid-feedback">
                <?= e($errores['sinopsis']) ?>
            </div>
        <?php endif; ?>
        <p></p>
        <label class="form-label" for="autor">Autor</label>
        <input type="text" id="autor" name="autor" class="form-control <?php if (isset($errores['autor'])) echo 'is-invalid'; ?>" placeholder="Autor" value="<?= e($datos['autor']) ?>" />
        <?php if (isset($errores['autor'])) : ?>
            <div class="invalid-feedback">
                <?= e($errores['autor']) ?>
            </div>
        <?php endif; ?>
        <p></p>
        <label class="form-label" for="paginas">Páginas</label>
        <input type="number" min="1" id="paginas" name="paginas" class="form-control <?php if (isset($errores['paginas'])) echo 'is-invalid'; ?>" placeholder="Páginas" value="<?= e($datos['paginas']) ?>" />
        <?php if (isset($errores['paginas'])) : ?>
            <div class="invalid-feedback">
                <?= e($errores['paginas']) ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="col-md-12 text-center">
        <button type="submit" class="btn_guardar btn btn-primary btn-outline-light">Guardar libro</button>
    </div>
</form>

<?php
require_once "../include/script.php";
require_once "../include/pie_normal.php";
?>