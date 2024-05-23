

<?php
require_once 'bd.php';

class Biblioteca
{
    public $id_libro;
    public $id_usuario;
    public $progreso;
    public $valoracion;
    public $estado;

    public static function BuscaLibroEnBiblioteca($libro){
        $bd = abrirBD();
        $st = $bd->prepare("SELECT * FROM biblioteca
                WHERE id_libro=?");
        if ($st === FALSE) {
            die("Error SQL: " . $bd->error);
        }
        $st->bind_param("i", $libro->id_libro);
        $ok = $st->execute();
        if ($ok === FALSE) {
            die("Error de ejecución: " . $bd->error);
        }
        $res = $st->get_result();
        $biblioteca = $res->fetch_object('Biblioteca');
        $res->free();
        $st->close();
        $bd->close();
        return $biblioteca;

    }

    public static function insertar_en_biblioteca_pendiente($libro,$usuario)
    {
        $bd = abrirBD();
        $st = $bd->prepare('INSERT INTO biblioteca
                (id_usuario,progreso,estado,id_libro) values (?,0,"Pendiente",?)');
        if ($st === FALSE) {
            die("Error SQL: " . $bd->error);
        }
        $st->bind_param(
            "ii",
            $usuario->id_usuario,
            $libro->id_libro
        );
        $res = $st->execute();
        if ($res === FALSE) {
            die("Error de ejecución: " . $bd->error);
        }
        $st->close();
        $bd->close();
    }

    public static function insertar_en_biblioteca_leyendo($libro,$usuario)
    {
        $bd = abrirBD();
        $st = $bd->prepare('INSERT INTO biblioteca
                (id_usuario,progreso,estado,id_libro) values (?,0,"Leyendo",?)');
        if ($st === FALSE) {
            die("Error SQL: " . $bd->error);
        }
        $st->bind_param(
            "ii",
            $usuario->id_usuario,
            $libro->id_libro
        );
        $res = $st->execute();
        if ($res === FALSE) {
            die("Error de ejecución: " . $bd->error);
        }
        $st->close();
        $bd->close();
    }

    public static function insertar_en_biblioteca_acabado($libro,$usuario)
    {
        $bd = abrirBD();
        $st = $bd->prepare('INSERT INTO biblioteca
                (id_usuario,progreso,estado,id_libro) values (?,?,"Acabado",?)');
        if ($st === FALSE) {
            die("Error SQL: " . $bd->error);
        }
        $st->bind_param(
            "iii",
            $usuario->id_usuario,
            $libro->paginas,
            $libro->id_libro
        );
        $res = $st->execute();
        if ($res === FALSE) {
            die("Error de ejecución: " . $bd->error);
        }
        $st->close();
        $bd->close();
    }

    public static function borrar_biblioteca($libro,$usuario)
    {
        $bd = abrirBD();
        $st = $bd->prepare('delete from biblioteca
                where id_libro=? and id_usuario=?');
        if ($st === FALSE) {
            die("Error SQL: " . $bd->error);
        }
        $st->bind_param(
            "ii",
            $libro->id_libro,
            $usuario->id_usuario
        );
        $res = $st->execute();
        if ($res === FALSE) {
            die("Error de ejecución: " . $bd->error);
        }
        $st->close();
        $bd->close();
    }
}