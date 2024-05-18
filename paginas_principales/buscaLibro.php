<?php
require_once '../bd/libro.php';

if (isset($_POST['buscador'])) {
    $titulo = $_POST['buscador'];
    $libros_coinciden = Libro::busca_por_titulo($titulo);
    
    header('Content-Type: application/json');
    echo json_encode($libros_coinciden);
} else {
    header('Content-Type: application/json');
    echo json_encode([]);
}
?>