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
</div>
<div id="resultados" class="row"></div>
<?php
require_once "../include/script.php";
?>
<script>
    const buscador = document.getElementById("buscador");

    buscador.addEventListener("input", function() {
        let formData = new FormData();
        formData.append("buscador", buscador.value);
        fetch("buscaLibro.php", {
                method: "POST",
                body: formData
            })
            .then(res => res.json())
            .then(libros => {
                const resultados = document.getElementById('resultados'); //resultados = div en el k estan dentro los libros
                resultados.innerHTML = ''; //elimina el html de dentro del div
                if (libros.length > 0) {
                    libros.forEach(libro => {
                        const libroDiv = document.createElement('div');
                        libroDiv.classList.add('book');
                        libroDiv.innerHTML = `
                        <p class="titulo_libro">${libro.titulo}</p>
                        <p class="autor_libro">${libro.autor}</p>
                        <a style="--clr: #7808d0" class="button" target="_blank" href="libro.php?titulo=${libro.titulo}">
                            <span class="button__icon-wrapper">
                                <svg width="10" class="button__icon-svg" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 15">
                                    <path fill="currentColor" d="M13.376 11.552l-.264-10.44-10.44-.24.024 2.28 6.96-.048L.2 12.56l1.488 1.488 9.432-9.432-.048 6.912 2.304.024z"></path>
                                </svg>
                                
                                <svg class="button__icon-svg  button__icon-svg--copy" xmlns="http://www.w3.org/2000/svg" width="10" fill="none" viewBox="0 0 14 15">
                                    <path fill="currentColor" d="M13.376 11.552l-.264-10.44-10.44-.24.024 2.28 6.96-.048L.2 12.56l1.488 1.488 9.432-9.432-.048 6.912 2.304.024z"></path>
                                </svg>
                            </span>
                            Ver libro
                        </a>
                        <div class="cover">
                            <img class="img_portada" src="../portadas_libros/${libro.portada}">
                        </div>
                    `;
                        resultados.appendChild(libroDiv);
                    });
                } else {
                    resultados.innerHTML = '<p>No hay resultados de tu búsqueda :(</p>';
                }
            });
    });
</script>
<?php
require_once "../include/pie_normal.php";
?>