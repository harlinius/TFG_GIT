<?php
require_once 'bd.php';
require_once 'publicacion.php';
require_once 'usuario.php';
require_once 'libro.php';
require_once 'biblioteca.php';
require_once '../lib/funciones.php';

class Seguidores
{
    public $id_seguidor;
    public $id_seguido;

    public static function seguir($id_seguidor, $id_seguido)
    {
        $bd = abrirBD();
        $st = $bd->prepare('INSERT INTO seguidores
                (id_seguidor,id_seguido) values (?,?)');
        if ($st === FALSE) {
            die("Error SQL: " . $bd->error);
        }
        $st->bind_param(
            "ii",
            $id_seguidor,
            $id_seguido
        );
        $res = $st->execute();
        if ($res === FALSE) {
            die("Error de ejecución: " . $bd->error);
        }
        $st->close();
        $bd->close();
    }

    public static function dejar_de_seguir($id_seguidor, $id_seguido)
    {
        $bd = abrirBD();
        $st = $bd->prepare('delete from seguidores
        where id_seguidor=? and id_seguido=?');
        if ($st === FALSE) {
            die("Error SQL: " . $bd->error);
        }
        $st->bind_param(
            "ii",
            $id_seguidor,
            $id_seguido
        );
        $res = $st->execute();
        if ($res === FALSE) {
            die("Error de ejecución: " . $bd->error);
        }
        $st->close();
        $bd->close();
    }

    public static function comprobar_si_sigue($id_seguidor, $id_seguido)
    {

        $bd = abrirBD();
        $st = $bd->prepare("SELECT * FROM seguidores
                WHERE id_seguidor=? and id_seguido=?");
        if ($st === FALSE) {
            die("Error SQL: " . $bd->error);
        }
        $st->bind_param("ii", $id_seguidor, $id_seguido);
        $ok = $st->execute();
        if ($ok === FALSE) {
            die("Error de ejecución: " . $bd->error);
        }
        $res = $st->get_result();
        $seguidos = $res->fetch_object('Seguidores');

        $res->free();
        $st->close();
        $bd->close();
        if ($seguidos){
            return true; //si se siguen
        }
        else{
            return false; //si no se siguen
        }
    }
}
