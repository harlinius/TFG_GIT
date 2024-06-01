<?php
require_once 'bd.php';

class Usuario
{
    public $id_usuario;
    public $nombre_completo;
    public $usuario;
    public $contrasena;
    public $administrador;
    public $foto_perfil;

    public function getRutaFoto()
    {
        return '../imagenes_perfil/' . $this->foto_perfil;
    }

    public static function getRutaFotoArray($fila) //para array
    {
        return '../imagenes_perfil/' . $fila['foto_perfil'];
    }

    public static function getRutaFotoObjeto($fila) //para objeto
    {
        return '../imagenes_perfil/' . $fila->foto_perfil;
    }

    public function insertar()
    {
        $bd = abrirBD();
        $st = $bd->prepare("INSERT INTO usuario
                (nombre_completo,usuario,contrasena,foto_perfil) 
                VALUES (?,?,?,?)");
        if ($st === FALSE) {
            die("Error SQL: " . $bd->error);
        }
        $st->bind_param(
            "ssss",
            $this->nombre_completo,
            $this->usuario,
            $this->contrasena,
            $this->foto_perfil
        );
        $res = $st->execute();
        if ($res === FALSE) {
            die("Error de ejecución: " . $bd->error);
        }
        $this->id_usuario = $bd->insert_id;

        $st->close();
        $bd->close();
    }

    public static function cargaLogin($usuario)
    {
        $bd = abrirBD();
        $st = $bd->prepare("SELECT * FROM usuario
                WHERE usuario=?");
        if ($st === FALSE) {
            die("Error SQL: " . $bd->error);
        }
        $st->bind_param("s", $usuario);
        $ok = $st->execute();
        if ($ok === FALSE) {
            die("Error de ejecución: " . $bd->error);
        }
        $res = $st->get_result();
        $usuario = $res->fetch_object('Usuario');
        $res->free();
        $st->close();
        $bd->close();
        return $usuario;
    }

    public function actualizar()
    {
        $bd = abrirBD();

        $st = $bd->prepare("UPDATE  usuario
        SET nombre_completo=?,usuario=?,contrasena=?,foto_perfil=? where id_usuario=?");

        if ($st === FALSE) {
            die("ERROR SQL: " . $bd->error);
        }

        $st->bind_param(
            "ssssi",
            $this->nombre_completo,
            $this->usuario,
            $this->contrasena,
            $this->foto_perfil,
            $this->id_usuario
        );

        $res = $st->execute();

        if ($res === FALSE) {
            die("ERROR de ejecucion: " . $bd->error);
        }
        $st->close();
        $bd->close();
    }

    public static function cargaUsuarioId($id)
    {
        $bd = abrirBD();
        $st = $bd->prepare("SELECT * FROM usuario
                WHERE id_usuario=?");
        if ($st === FALSE) {
            die("Error SQL: " . $bd->error);
        }
        $st->bind_param("i", $id);
        $ok = $st->execute();
        if ($ok === FALSE) {
            die("Error de ejecución: " . $bd->error);
        }
        $res = $st->get_result();
        $usuario = $res->fetch_object('Usuario');
        $res->free();
        $st->close();
        $bd->close();
        return $usuario;
    }
}
