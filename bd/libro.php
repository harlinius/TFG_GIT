<?php
require_once 'bd.php';

class Libro
{
    public $id_libro;
    public $titulo;
    public $portada;
    public $sinopsis;
    public $autor;
    public $media_valoraciones;
    public $paginas;

    public function getRutaFoto()
    {
        return '../portadas_libros/' . $this->id_libro . '.jpg';
    }

    public static function getRutaFotoArray($fila) //para array
    {
        return '../portadas_libros/' . $fila['id_libro'] . '.jpg';
    }

    public static function getRutaFotoObjeto($fila) //para objeto
    {
        return '../portadas_libros/' . $fila->id_libro . '.jpg';
    }

    public static function listadolibros()
    {
        $bd = abrirBD();
        $st = $bd->prepare("select * from libro");

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

    public static function busca_por_titulo($titulo)
    {
        $titulo = "%" . $titulo . "%";
        $bd = abrirBD();
        $st = $bd->prepare("select * from libro where titulo like (?)");

        if ($st === FALSE) {
            die("ERROR SQL: " . $bd->error);
        }

        $st->bind_param(
            "s",
            $titulo
        );

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

    public static function cargaLibroId($id_libro)
    {
        $bd = abrirBD();
        $st = $bd->prepare("SELECT * FROM libro
                WHERE id_libro=?");
        if ($st === FALSE) {
            die("Error SQL: " . $bd->error);
        }
        $st->bind_param("i", $id_libro);
        $ok = $st->execute();
        if ($ok === FALSE) {
            die("Error de ejecución: " . $bd->error);
        }
        $res = $st->get_result();
        $libro = $res->fetch_object('Libro');
        $res->free();
        $st->close();
        $bd->close();
        return $libro;
    }

    public function anade_libro()
    {
        $bd = abrirBD();
        $st = $bd->prepare("INSERT INTO libro
                (titulo,sinopsis,autor,paginas) 
                VALUES (?,?,?,?)");
        if ($st === FALSE) {
            die("Error SQL: " . $bd->error);
        }
        $st->bind_param(
            "sssi",
            $this->titulo,
            $this->sinopsis,
            $this->autor,
            $this->paginas
        );
        $res = $st->execute();
        if ($res === FALSE) {
            die("Error de ejecución: " . $bd->error);
        }
        $this->id_libro = $bd->insert_id;

        $st->close();
        $bd->close();
    }

    public static function anade_portada($id_libro)
    {
        $ruta = $id_libro . '.jpg';
        $bd = abrirBD();
        $st = $bd->prepare('update libro set portada=? where id_libro=?');
        if ($st === FALSE) {
            die("Error SQL: " . $bd->error);
        }
        $st->bind_param(
            "si",
            $ruta,
            $id_libro
        );
        $res = $st->execute();
        if ($res === FALSE) {
            die("Error de ejecución: " . $bd->error);
        }
        $st->close();
        $bd->close();
    }
}
