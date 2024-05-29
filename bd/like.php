<?php
require_once 'bd.php';

class Likes
{

    public $id_publicacion;
    public $id_usuario;

    public static function dar_like($id_publicacion, $id_usuario)
    {
        $bd = abrirBD();
        $st = $bd->prepare("INSERT INTO likes
                (id_usuario,id_publicacion) 
                VALUES (?,?)");
        if ($st === FALSE) {
            die("Error SQL: " . $bd->error);
        }
        $st->bind_param(
            "ii",
            $id_usuario,
            $id_publicacion
        );
        $res = $st->execute();
        if ($res === FALSE) {
            die("Error de ejecución: " . $bd->error);
        }

        $st->close();
        $bd->close();
    }

    public static function quitar_like($id_publicacion, $id_usuario)
    {
        $bd = abrirBD();
        $st = $bd->prepare("delete from likes
        where id_publicacion=? and id_usuario=?");
        if ($st === FALSE) {
            die("Error SQL: " . $bd->error);
        }
        $st->bind_param(
            "ii",
            $id_publicacion,
            $id_usuario
        );
        $res = $st->execute();
        if ($res === FALSE) {
            die("Error de ejecución: " . $bd->error);
        }

        $st->close();
        $bd->close();
    }

}
