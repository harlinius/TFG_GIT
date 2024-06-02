
<?php
require_once '../bd/libro.php';
require_once '../lib/funciones.php';

$errores = []; // Crea un array para los errores

if (empty($_POST['titulo'])) {
    $errores['titulo'] = "Título requerido";
}

if (empty($_POST['sinopsis'])) {
    $errores['sinopsis'] = "Sinopsis requerida";
}

if (empty($_POST['autor'])) {
    $errores['autor'] = "Autor/a requerido/a";
}

if (empty($_POST['paginas'])) {
    $errores['paginas'] = "Páginas requeridas";
}

// Verificar y manejar la portada del libro
if (!empty($_FILES['portada']['name'])) {
    $allowedTypes = ['image/jpeg'];
    $fileType = $_FILES['portada']['type'];
    if (!in_array($fileType, $allowedTypes)) {
        $errores['portada'] = "Formato de imagen no permitido. Solo se permiten JPG";
    }
} else {
    $errores['portada'] = "Portada requerida";
}

if (count($errores) > 0) {
    $_SESSION['errores'] = $errores;
    $_SESSION['datos'] = [
        'titulo' => $_POST['titulo'],
        'sinopsis' => $_POST['sinopsis'],
        'autor' => $_POST['autor'],
        'paginas' => $_POST['paginas']
    ];
    header("Location: ../paginas_principales/administracion.php");
} else {
    $libro = new Libro();
    $libro->titulo = $_POST['titulo'];
    $libro->sinopsis = $_POST['sinopsis'];
    $libro->autor = $_POST['autor'];
    $libro->paginas = $_POST['paginas'];

    $libro->anade_libro();

    $libroID = $libro->id_libro;

    if (!empty($_FILES['portada']['name'])) {
        $ext = pathinfo($_FILES['portada']['name'], PATHINFO_EXTENSION);
        $portadaPath = "../portadas_libros/{$libroID}.jpg";
        move_uploaded_file($_FILES['portada']['tmp_name'], $portadaPath);
    }

    Libro::anade_portada($libro->id_libro);

    header('Location: ../paginas_principales/home.php');
}
?>