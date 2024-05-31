<?php
require_once 'bd.php';
require_once 'publicacion.php';
require_once 'usuario.php';
require_once 'libro.php';
require_once 'biblioteca.php';
require_once '../lib/funciones.php';

class Biblioteca
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

}