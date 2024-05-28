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
        $bd = abrirBD();
        $st = $bd->prepare("INSERT INTO publicacion
                (texto,id_usuario,id_libro,fecha) 
                VALUES (?,?,?,now())");
        if ($st === FALSE) {
            die("Error SQL: " . $bd->error);
        }
        $st->bind_param(
            "sii",
            $texto,
            $id_usuario,
            $id_libro
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



}