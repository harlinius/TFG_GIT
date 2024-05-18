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
$libros = Libro::listadolibros();

if ($usuario->administrador == 1) {
    require_once '../include/cabecera_home_admin.php';
} else {
    require_once '../include/cabecera_home_usuario.php';
}
?>
<div id="bloque_busqueda" class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <input class="input" id="buscador" name="text" type="text" placeholder="¿Buscas una nueva aventura?">
    </div>
    <?php foreach ($libros as $l) : ?>
        <div class="book">
            <p class="titulo_libro">
                <?= e($l['titulo']) ?>
            </p>
            <p class="autor_libro"><?= e($l['autor']) ?></p>
            <div class="cover">
                <img class="img_portada" src="<?= e(Libro::getRutaFotoArray($l)) ?>">
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php
require_once "../include/script.php";
?>
<script>
    const buscador = document.getElementById("buscador");

    buscador.addEventListener("change", function() {
        let formData = new FormData();
        formData.append("buscador", buscador.value);
        fetch("buscaLibros.php", {
                method: "POST",
                body: formData
            })
            .then(res => res.json())
            .then(libros => {
                if (libros!=empty) {
                    
                } else {
                    //hacer que se vea un mensaje con "No hay resultados de tu búsqueda" o algo asi
                }
            });
    });
</script>
<?php
require_once "../include/pie_normal.php";
?>