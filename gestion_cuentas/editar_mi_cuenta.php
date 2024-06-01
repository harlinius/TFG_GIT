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
        'nombre_completo' => $usuario->nombre_completo,
        'foto_perfil' => $usuario->foto_perfil,
        'usuario' => $usuario->usuario,
        'contrasena' => ''
    ];
}

$tituloPagina = "Read&Meet | Editar cuenta";
$HojaCSS = "../css/estilo_editar_cuenta.css";

if ($usuario->administrador == 1) {
    require_once '../include/cabecera_home_admin.php';
} else {
    require_once '../include/cabecera_home_usuario.php';
}
?>

<form action="modifica_usuario.php" method="POST" class="row g-3" enctype="multipart/form-data">
    <div class="col-md-10 offset-md-1">
        <h1>Edita tus datos</h1>
        <label class="form-label" for="nombre_completo">Nombre completo</label>
        <input type="text" id="nombre_completo" name="nombre_completo" class="form-control <?php if (isset($errores['nombre_completo'])) echo 'is-invalid'; ?>" placeholder="Nombre completo" value="<?= e($datos['nombre_completo']) ?>" />
        <?php if (isset($errores['nombre_completo'])) : ?>
            <div class="invalid-feedback">
                <?= e($errores['nombre_completo']) ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="col-md-10 offset-md-1">
        <label class="form-label" for="usuario">Usuario</label>
        <input type="text" id="usuario" name="usuario" class="form-control <?php if (isset($errores['usuario'])) echo 'is-invalid'; ?>" placeholder="Nombre de usuario" value="<?= e($datos['usuario']) ?>" />
        <?php if (isset($errores['usuario'])) : ?>
            <div class="invalid-feedback">
                <?= e($errores['usuario']) ?>
            </div>
        <?php endif; ?>
        <div class="alert alert-danger alert-dismissible fade show d-none" role="alert" id="error-duplicado">Ya existe alguien con este usuario</div>
    </div>

    <div class="col-md-10 offset-md-1">
        <label class="form-label" for="contrasena">Contraseña (deja en blanco para no cambiar)</label>
        <input type="text" id="contrasena" name="contrasena" class="form-control" placeholder="Contraseña" />
    </div>

    <div class="col-md-10 offset-md-1">
        <label for="foto" class="form-label">Foto:</label>
        <input type="file" class="form-control <?php if (isset($errores['foto_perfil'])) echo 'is-invalid'; ?>" id="foto_perfil" name="foto_perfil" />
        <?php if (isset($errores['foto_perfil'])) : ?>
            <div class="invalid-feedback">
                <?= e($errores['foto_perfil']) ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="col-md-12 text-center">
        <button type="submit" class="btn_guardar btn btn-primary btn-outline-light">Guardar</button>
    </div>
</form>

<?php
require_once "../include/script.php";
?>

<script>
    const txtusuario = document.getElementById("usuario");
    const error = document.getElementById("error-duplicado");

    txtusuario.addEventListener("change", function() {
        let formData = new FormData();
        formData.append("usuario", txtusuario.value);
        fetch("validarLogin.php", {
                method: "POST",
                body: formData
            })
            .then(res => res.text())
            .then(msg => {
                if (msg == "DUPLICADO") {
                    error.classList.remove("d-none");
                } else {
                    error.classList.add("d-none");
                }
            });
    });
</script>
<?php
require_once "../include/pie_normal.php";
?>