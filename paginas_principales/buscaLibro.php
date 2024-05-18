<?php
require_once '../bd/libro.php';

$titulo = $_POST['buscador'];

$libros_coinciden = Libro::busca_por_titulo($titulo);
if (!empty($libros_coinciden)) {
    header('Content-Type:application/json');
    echo json_encode($libros_coinciden);
}
else{
    header('Content-Type:application/json');
    echo json_encode($codigo);
}
