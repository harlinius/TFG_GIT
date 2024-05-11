<?php

require_once '../lib/funciones.php';
require_once '../bd/bd.php';
session_start();

$tituloPagina = "Read&Meet | Login";
require_once "../include/cabecera_login.php";
?>

<div id="bloque_form" class="row">
    <div class="col-md-12 col-sm-12 offset-md-3">
        <p>Bienvenido a</p>
        <h1>Read&Meet</h1>
    </div>
    <div class="col-md-5 col-sm-12 offset-md-3 ">
        <p>Rellena estos datos para registrarte</p>
        <form action="doLogin.php" method="POST" class="row">
            <?php
            if (isset($_SESSION['error-login'])) :  ?>
                <div class="alert alert-danger">
                    <?= e($_SESSION['error-login']) ?>
                </div>
            <?php
                unset($_SESSION['error-login']);
            endif; ?>
            <div class="mb-3">
                <label class="form-label" for="login">
                    Nombre de usuario
                </label>
                <input type="text" id="login" name="login" class="form-control" placeholder="" />
            </div>
            <div class="mb-3">
                <label class="form-label" for="pwd">
                    Contraseña
                </label>
                <input type="password" id="pwd" name="pwd" class="form-control" placeholder="" />
            </div>
            <div class="mb-3 text-center">
                <a href="crearCuenta.php" class="btn btn-secondary">Crear cuenta</a>
                <button type="submit" class="btn btn-primary btn-outline-light">
                    Iniciar sesión
                </button>
            </div>
        </form>
    </div>
</div>

<div id="carrusel" class="row">
    <div class="col-md-7 col-sm-12 offset-md-2">
        <div id="carouselExampleCaptions" class="carousel slide " data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active" data-bs-interval="3000">
                    <img src="../css/imagenes/slider1.jpg" class="imagen_carrusel d-block w-100 carousel-fade " alt="Libro abierto">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Lee</h5>
                        <p>tus propios libros online.</p>
                    </div>
                </div>
                <div class="carousel-item" data-bs-interval="3000">
                    <img src="../css/imagenes/slider2.jpg" class="imagen_carrusel d-block w-100 carousel-fade " alt="Gato asomando en una estantería de libros">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Descubre</h5>
                        <p>nuevos libros y géneros.</p>
                    </div>
                </div>
                <div class="carousel-item" data-bs-interval="3000">
                    <img src="../css/imagenes/slider3.jpg" class="imagen_carrusel d-block w-100 carousel-fade " alt="Manos agarradas con una biblioteca de fondo">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Conecta</h5>
                        <p>con personas con tus mismos gustos.</p>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</div>
<?php
require_once "../include/script.php";
?>
<?php
require_once "../include/pie_login.php";
?>