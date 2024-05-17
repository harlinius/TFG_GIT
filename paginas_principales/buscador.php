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

$tituloPagina = "Read&Meet | Buscar";
$activoBuscador = 'active';
$HojaCSS = "../css/estilo_buscador.css";
if ($usuario->administrador == 1) {
    require_once '../include/cabecera_home_admin.php';
} else {
    require_once '../include/cabecera_home_usuario.php';
}
?>
<div id="bloque_busqueda" class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <input class="input" name="text" type="text" placeholder="¿Buscas una nueva aventura?">
    </div>
    <?php foreach ($libros as $l) : ?>
        <div class="col-lg-3 col-md-6">
            <div href="#" class="card">
                <img class="img-cover" src="<?= e(Contenido::getRutaFotoAssoc($c)) ?>">
                <div class="card-body">
                    <h5 class="card-title">
                        <?= e($l['titulo']) ?>
                    </h5>
                    <p class="card-text">
                        <?= e($l['titulo']) ?>
                    </p>
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