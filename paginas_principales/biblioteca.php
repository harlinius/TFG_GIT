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
$bibliotecas = Biblioteca::biblioteca_usuario($usuario);

if ($usuario->administrador == 1) {
    require_once '../include/cabecera_home_admin.php';
} else {
    require_once '../include/cabecera_home_usuario.php';
}
?>

<div class=" table-responsive-md">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Portada</th>
                <th>Titulo</th>
                <th>Autor</th>
                <th>Estado</th>
                <th>Progreso</th>
                <th>Valoración</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bibliotecas as $biblioteca) :
                $libro = Libro::cargaLibroId($biblioteca['id_libro']); ?>
                <tr>
                    <td><?php echo '<img class="img_portada_biblioteca" src="../portadas_libros/' . Libro::getRutaFotoArray($biblioteca) . '">' ?></td>
                    <td><?php echo e($libro->titulo) ?></td>
                    <td><?php echo e($libro->autor) ?></td>
                    <td><?php echo e($biblioteca['estado']) ?></td>
                    <td><?php echo e($biblioteca['progreso']) ?></td>
                    <td><?php echo e($biblioteca['valoracion']) /*?></td>
                <td>
                    <?php if ($con['aprobado'] == 0) { ?>
                        <button class="btn btn-sm btn-primary botonAprobar" data-id="<?= $con['idAdquisicion'] ?>">
                            Aprobar
                        </button>
                        <p id="pedido-aprobado-<?= $con['idAdquisicion'] ?>" class="d-none">

                        </p>
                    <?php } else {
                    ?>
                        <p>
                            <?= formateaFecha(e($con['fechaAprobacion'])) ?>
                        </p>
                    <?php } ?>
                </td>
                <td>
                    <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalBorrar<?= $con['idAdquisicion'] ?>">
                        Borrar
                    </a>
                    <div class="modal fade" id="modalBorrar<?= $con['idAdquisicion'] ?>">
                        <div class="modal-dialog">
                            <div class="modal-content text-start">
                                <div class="modal-header">
                                    <h1 class="modal-title">Borrar adquisicion</h1>
                                </div>
                                <div class="modal-body">
                                    <P>¿Seguro que quieres borrar la adquisicion?
                                    </P>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-sm btn-danger botonBorrar" data-id="<?= $con['idAdquisicion'] ?>" data-bs-dismiss="modal">
                                        Borrar
                                    </button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        Cancelar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </td> 
            </tr>
                    <?php */;
                    endforeach; ?>
        </tbody>
    </table>
</div>


<?php
require_once "../include/script.php";
?>

<?php
require_once "../include/pie_normal.php";
?>