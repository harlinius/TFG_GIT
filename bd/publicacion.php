<?php
require_once 'bd.php';

class Publicacion
{

    public $id_publicacion;
    public $texto;
    public $id_usuario;
    public $id_libro;

    public static function insertar_publicacion($texto, $id_usuario, $id_libro)
    {
        $fecha = date('Y-m-d H:i:s');
        $bd = abrirBD();
        $st = $bd->prepare("INSERT INTO publicacion
                (texto,id_usuario,id_libro,fecha) 
                VALUES (?,?,?,?)");
        if ($st === FALSE) {
            die("Error SQL: " . $bd->error);
        }
        $st->bind_param(
            "siis",
            $texto,
            $id_usuario,
            $id_libro,
            $fecha
        );
        $res = $st->execute();
        if ($res === FALSE) {
            die("Error de ejecución: " . $bd->error);
        }

        $st->close();
        $bd->close();
    }

    public function borrar_publicacion()
    {
        $bd = abrirBD();
        $st = $bd->prepare('delete from publicacion
                where id_publicacion=?');
        if ($st === FALSE) {
            die("Error SQL: " . $bd->error);
        }
        $st->bind_param(
            "ii",
            $this->id_publicacion,
        );
        $res = $st->execute();
        if ($res === FALSE) {
            die("Error de ejecución: " . $bd->error);
        }
        $st->close();
        $bd->close();
    }

    public static function todas_las_publicaciones()
    {
        $bd = abrirBD();
        $st = $bd->prepare('select * from publicacion');

        if ($st === FALSE) {
            die("ERROR SQL: " . $bd->error);
        }

        $ok = $st->execute();
        if ($ok === false) {
            die("ERROR: " . $bd->error);
        }
        $res = $st->get_result();

        $publicaciones = [];
        while ($publicacion = $res->fetch_assoc()) {
            $publicaciones[] = $publicacion;
        }
        $res->free();
        $st->close();
        $bd->close();
        return $publicaciones;
    }
}
