<?php
require_once 'bd.php';
require_once 'publicacion.php';
require_once 'usuario.php';
require_once 'libro.php';
require_once 'biblioteca.php';
require_once '../lib/funciones.php';

class Biblioteca
{
    public $id_libro;
    public $id_usuario;
    public $progreso;
    public $valoracion;
    public $estado;

    public static function BuscaLibroEnBiblioteca($libro, $usuario)
    {
        $bd = abrirBD();
        $st = $bd->prepare("SELECT * FROM biblioteca
                WHERE id_libro=? and id_usuario=?");
        if ($st === FALSE) {
            die("Error SQL: " . $bd->error);
        }
        $st->bind_param("ii", $libro->id_libro, $usuario->id_usuario);
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

    public static function insertar_en_biblioteca_pendiente($libro, $usuario)
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

    public static function insertar_en_biblioteca_leyendo($libro, $usuario)
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

    public static function insertar_en_biblioteca_acabado($libro, $usuario)
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

    public static function borrar_biblioteca($libro, $usuario)
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

    public static function biblioteca_usuario_filtrada($usuario, $estado)
    {

        $bd = abrirBD();
        $st = $bd->prepare("select * from biblioteca where id_usuario=? and estado=?");

        if ($st === FALSE) {
            die("ERROR SQL: " . $bd->error);
        }
        $st->bind_param('is', $usuario->id_usuario, $estado);
        $ok = $st->execute();
        if ($ok === false) {
            die("ERROR: " . $bd->error);
        }
        $res = $st->get_result();
        $biblioteca = [];
        while ($libro = $res->fetch_assoc()) {
            $biblioteca[] = $libro;
        }
        $res->free();
        $st->close();
        $bd->close();
        return $biblioteca;
    }

    public static function biblioteca_usuario($usuario)
    {
        $bd = abrirBD();
        $st = $bd->prepare('select biblioteca.* from biblioteca join libro on biblioteca.id_libro = libro.id_libro
        where biblioteca.id_usuario = ? order by libro.titulo asc');

        if ($st === FALSE) {
            die("ERROR SQL: " . $bd->error);
        }
        $st->bind_param('i', $usuario->id_usuario);
        $ok = $st->execute();
        if ($ok === false) {
            die("ERROR: " . $bd->error);
        }
        $res = $st->get_result();
        $biblioteca = [];
        while ($libro = $res->fetch_assoc()) {
            $biblioteca[] = $libro;
        }
        $res->free();
        $st->close();
        $bd->close();
        return $biblioteca;
    }

    public static function empezar_a_leer($libro, $usuario)
    {
        $bd = abrirBD();
        $st = $bd->prepare('update biblioteca set estado="Leyendo" where id_libro=? and id_usuario=?;');
        if ($st === FALSE) {
            die("Error SQL: " . $bd->error);
        }
        $st->bind_param(
            "ii",
            $libro->id_libro,
            $usuario->id_usuario,
        );
        $res = $st->execute();
        if ($res === FALSE) {
            die("Error de ejecución: " . $bd->error);
        }
        $st->close();
        $bd->close();
    }

    public static function actualizar_paginas($paginas, $libro, $usuario)
    {

        $bd = abrirBD();
        $st = $bd->prepare('update biblioteca set progreso=? where id_libro=? and id_usuario=?;');
        if ($st === FALSE) {
            die("Error SQL: " . $bd->error);
        }
        $st->bind_param(
            "iii",
            $paginas,
            $libro->id_libro,
            $usuario->id_usuario,
        );
        $res = $st->execute();
        if ($res === FALSE) {
            die("Error de ejecución: " . $bd->error);
        }

        if ($paginas == $libro->paginas) {
            $texto = $usuario->nombre_completo . " ha acabado:";
            Publicacion::insertar_publicacion($texto, $usuario->id_usuario, $_GET['id_libro']);
            $st = $bd->prepare('update biblioteca set estado="Acabado" where id_libro=? and id_usuario=?;');
            if ($st === FALSE) {
                die("Error SQL: " . $bd->error);
            }

            $st->bind_param(
                "ii",
                $libro->id_libro,
                $usuario->id_usuario,
            );

            $res = $st->execute();
            if ($res === FALSE) {
                die("Error de ejecución: " . $bd->error);
            }
        }

        $st->close();
        $bd->close();
    }

    public static function actualizar_valoracion($valoracion, $libro, $usuario)
    {
        $bd = abrirBD();
        $st = $bd->prepare('update biblioteca set valoracion=? where id_libro=? and id_usuario=?;');
        if ($st === FALSE) {
            die("Error SQL: " . $bd->error);
        }
        $st->bind_param(
            "iii",
            $valoracion,
            $libro->id_libro,
            $usuario->id_usuario,
        );
        $res = $st->execute();
        if ($res === FALSE) {
            die("Error de ejecución: " . $bd->error);
        }

        $st->close();
        $bd->close();
    }

    public static function saca_media_valoracion($id_libro)
    {
        $bd = abrirBD();
        $st = $bd->prepare("SELECT AVG(valoracion) AS media_valoraciones FROM biblioteca WHERE id_libro = ? AND valoracion IS NOT NULL;");

        if ($st === FALSE) {
            die("Error SQL: " . $bd->error);
        }

        $st->bind_param("i", $id_libro);
        $ok = $st->execute();

        if ($ok === FALSE) {
            die("Error de ejecución: " . $bd->error);
        }

        $res = $st->get_result();
        $media = null;

        if ($row = $res->fetch_assoc()) {
            $media = $row['media_valoraciones'];
        }

        $res->free();
        $st->close();
        $bd->close();

        // formatea la media a 1 decimal
        if ($media !== null) {
            $media = number_format((float)$media, 1, '.', '');
        }

        return $media;
    }
}
