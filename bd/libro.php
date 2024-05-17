<?php
require_once 'bd.php';

class Libro
{
    public $id_libro;
    public $titulo;
    public $portada;
    public $sinopsis;
    public $fecha_publicacion;
    public $autor;
    public $media_valoraciones;

    public function getRutaFoto()
    {
        return '../portadas_libros/' . $this->id_libro .'.jpg';
    }

    public static function getRutaFotoArray($fila) //para array
    {
        return '../portadas_libros/' . $fila['id_libro'].'.jpg';
    }

    public static function getRutaFotoObjeto($fila) //para objeto
    {
        return '../portadas_libros/' . $fila->id_libro.'.jpg';
    }

    public static function listadolibros()
    {
        $bd = abrirBD();
        $st = $bd->prepare("select * from libros");

        if ($st === FALSE) {
            die("ERROR SQL: " . $bd->error);
        }
        $ok = $st->execute();
        if ($ok === false) {
            die("ERROR: " . $bd->error);
        }
        $res = $st->get_result();
        $libros = [];
        while ($libro = $res->fetch_assoc()) {
            $libros[] = $libro;
        }
        $res->free();
        $st->close();
        $bd->close();
        return $libros;
    }

}
