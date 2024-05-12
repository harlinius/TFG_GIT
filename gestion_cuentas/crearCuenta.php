<?php

require_once '../lib/funciones.php';
require_once '../bd/bd.php';
require_once '../bd/usuario.php';
session_start();

if (isset($_SESSION['errores'])) { // si hay errores
    $errores = $_SESSION['errores']; //pasan a la variable errores
    $usuario = $_SESSION['datos']; //los datos pasan a la variable datos
    unset($_SESSION['errores']); //se borran los errores de la session
    unset($_SESSION['datos']); //se borran los datos de la session
} else {
    $errores = []; //esto es al entrar por primera vez a la pagina al no haber errores y creas un nuevo usuario
    $usuario = new Usuario();
}

$tituloPagina = "Read&Meet | Registro";
require_once "../include/cabecera_registro.php";
?>

<div id="bloque_form" class="row">
    <div class="col-12">
        </br>
        </br>
        </br>
        </br>
        </br>
    </div>
    <div class="col-6 offset-md-4 ">
        <p>Bienvenido a</p>
        <h1>Read&Meet</h1>
    </div>
    <div class="col-md-3 col-sm-12 offset-md-4 ">
        <p>Rellena estos datos para registrarte</p>
        <form action="guardarRegistro.php" method="POST" class="row">
            <label class="form-label" for="nombre">
                Nombre completo
            </label>
            <input type="text" id="nombre_completo" name="nombre_completo" class="form-control 
                <?php if (isset($errores['nombre'])) //si errores['nombre'] no es null
                    echo 'is-invalid'; ?>" placeholder="Nombre" value="<?= e($usuario->nombre_completo) ?>" />
            <?php if (isset($errores['nombre_completo'])) : ?>
                <div class="invalid-feedback">
                    <?= e($errores['nombre_completo']) ?><!-- lo que pone cuando es invalid -->
                </div>
            <?php endif; ?>
            <label class="form-label" for="usuario">
                Nombre de usuario
            </label>
            <input type="text" id="usuario" name="usuario" class="form-control 
                <?php if (isset($errores['usuario'])) echo 'is-invalid'; ?>" placeholder="Nombre de usuario" value="<?= e($usuario->usuario) ?>" />
            <?php if (isset($errores['usuario'])) : ?>
                <div class="invalid-feedback">
                    <?= e($errores['usuario']) ?>
                </div>
            <?php endif; ?>
            <label class="form-label" for="contrasena">
                Contraseña
            </label>
            <input type="password" id="contrasena" name="contrasena" class="form-control 
                <?php if (isset($errores['contrasena'])) echo 'is-invalid'; ?>" placeholder="Contraseña" />
            <?php if (isset($errores['contrasena'])) : ?>
                <div class="invalid-feedback">
                    <?= e($errores['contrasena']) ?>
                </div>
            <?php endif; ?>
            </br>
            <div class="col-md-12 text-center">
                <a href="login.php" class="btn btn-secondary">Volver</a>
                <button type="submit" class="btn btn-primary btn-outline-light">Crear cuenta</button>
            </div>
        </form>
    </div>
</div>

<?php
require_once "../include/script.php";
?>
<?php
require_once "../include/pie_login.php";
?>