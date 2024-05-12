<?php
require_once 'bd.php';

class Usuario {
    public $id_usuario;
    public $nombre_completo;
    public $usuario;
    public $contrasena;
    public $administrador;

    public function insertar() {
        $bd = abrirBD();
        $st = $bd->prepare("INSERT INTO usuario
                (nombre_completo,usuario,contrasena) 
                VALUES (?,?,?)");
        if ($st === FALSE) {
            die("Error SQL: " . $bd->error);
        }
        $st->bind_param("sss", 
                $this->nombre_completo, 
                $this->usuario, 
                $this->contrasena);
        $res = $st->execute();
        if ($res === FALSE) {
            die("Error de ejecución: " . $bd->error);
        }
        $this->id_usuario = $bd->insert_id;
        
        $st->close();
        $bd->close();
    }

    public static function cargaLogin($usuario) {
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
        SET nombre_completo=?,usuario=?,contrasena=? where id_usuario=?");

        if ($st === FALSE) {
            die("ERROR SQL: " . $bd->error);
        }

        $st->bind_param(
            "sssi",
            $this->nombre_completo,
            $this->usuario,
            $this->contrasena,
            $this->id_usuario
        );

        $res = $st->execute();

        if ($res === FALSE) {
            die("ERROR de ejecucion: " . $bd->error);
        }

        $st->close();
        $bd->close();
    }
}