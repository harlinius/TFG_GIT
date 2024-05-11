<?php

require_once '../lib/funciones.php';
require_once '../bd/bd.php';
session_start();

$tituloPagina = "Read&Meet | Login";
require_once "../include/cabecera_login.php";
?>

<div id="bloque_form" class="row">
    <div class="col-md-4 offset-md-2">
        <h1>Read&Meet</h1>
    </div>
    <div class="col-md-3">
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
                <input type="text" id="login" name="login" class="form-control" placeholder="Nombre" />
            </div>
            <div class="mb-3">
                <label class="form-label" for="pwd">
                    Contraseña
                </label>
                <input type="password" id="pwd" name="pwd" class="form-control" placeholder="Contraseña" />
            </div>
            <div class="mb-3 text-center">
                <a href="crearCuenta.php" class="btn btn-secondary">Crear cuenta</a>
                <button type="submit" class="btn btn-primary">
                    Iniciar sesión
                </button>
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