<?php

require_once 'conexionf2.php';
require_once 'fclases.php';

class modificarcliente extends datospersona
{
    const TABLA = 'clientes';

    public function guardar()
    {
        $conexion = new Conexion();

        $consulta = $conexion->prepare(
            'INSERT INTO ' . self::TABLA . '
            (nomcli, direccion, telres_cli, telcel_cli, email_cli)
            VALUES (:nombre, :direccion, :telresidencial, :telcelular, :email)'
        );

        $consulta->bindParam(':nombre', $this->dnombre);
        $consulta->bindParam(':direccion', $this->ddireccion);
        $consulta->bindParam(':telresidencial', $this->dtelresi);
        $consulta->bindParam(':telcelular', $this->dtelcel);
        $consulta->bindParam(':email', $this->demail);

        $consulta->execute();
        $conexion = null;
    }

    public static function listar()
    {
        $conexion = new Conexion();
        $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA . ' ORDER BY idcli DESC');
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function obtenerPorId($id)
    {
        $conexion = new Conexion();
        $consulta = $conexion->prepare('SELECT * FROM ' . self::TABLA . ' WHERE idcli = :id');
        $consulta->bindParam(':id', $id, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->fetch(PDO::FETCH_ASSOC);
    }

    public static function actualizar($id, $nombre, $direccion, $telresidencial, $telcelular, $email)
    {
        $conexion = new Conexion();
        $consulta = $conexion->prepare(
            'UPDATE ' . self::TABLA . ' SET
            nomcli = :nombre,
            direccion = :direccion,
            telres_cli = :telresidencial,
            telcel_cli = :telcelular,
            email_cli = :email
            WHERE idcli = :id'
        );

        $consulta->bindParam(':nombre', $nombre);
        $consulta->bindParam(':direccion', $direccion);
        $consulta->bindParam(':telresidencial', $telresidencial);
        $consulta->bindParam(':telcelular', $telcelular);
        $consulta->bindParam(':email', $email);
        $consulta->bindParam(':id', $id, PDO::PARAM_INT);

        $consulta->execute();
        $conexion = null;
    }

    public static function eliminar($id)
    {
        $conexion = new Conexion();
        $consulta = $conexion->prepare('DELETE FROM ' . self::TABLA . ' WHERE idcli = :id');
        $consulta->bindParam(':id', $id, PDO::PARAM_INT);
        $consulta->execute();
        $conexion = null;
    }
}
?>
