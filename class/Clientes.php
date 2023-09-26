<?php
class Clientes extends DB
{
    public $nombre_cliente;
    public $direccion;
    public $correo;
    public $telefono;
    public $descripcion;


    public function listarTodo()
    {
        $query = "SELECT * FROM vta_listar_clientes ORDER BY id_cliente DESC";
        return $this->EjecutarQuery($query);
    }

    public function buscarPorId($id)
    {
        $query = "SELECT * FROM vta_listar_clientes WHERE id_cliente='" . $id . "'";
        return $this->EjecutarQuery($query);
    }
    public function buscarCliente($content)
    {
        $query = "SELECT * FROM vta_listar_clientes WHERE 
        id_cliente LIKE'%" . $content . "%' OR 
        nombre_cliente LIKE'%" . $content . "%' OR 
        telefono LIKE'%" . $content . "%' OR 
        correo LIKE'%" . $content . "%' OR 
        direccion LIKE'%" . $content . "%'";
        return $this->EjecutarQuery($query);
    }

    public function Insertar()
    {
        $query = "INSERT INTO tbl_clientes(
            nombre_cliente,
            telefono,
            direccion,
            correo,
            descripcion,
            Eliminado )
            VALUES (
            '" . $this->nombre_cliente . "',
            '" . $this->telefono . "',
            '" . $this->direccion . "',
            '" . $this->correo . "',
            '" . $this->descripcion . "',
            'N' ) ";
        return $this->EjecutarQuery($query);
    }

    public function Actualizar($id)
    {
        $query = "UPDATE tbl_clientes SET 
        nombre_cliente = '" . $this->nombre_cliente . "',
        direccion = '" . $this->direccion . "', 
        correo = '" . $this->correo . "', 
        telefono = '" . $this->telefono . "', 
        descripcion = '" . $this->descripcion . "'  
        WHERE id_cliente='" . $id . "' ";

        return $this->EjecutarQuery($query);
    }

    public function Eliminar($id)
    {
        $query = "UPDATE tbl_clientes SET Eliminado='S' WHERE id_cliente='" . $id . "'";
        return $this->EjecutarQuery($query);
    }

    public function ObtenerClientesCreados($fechaInicio, $fechaFin)
    {
        $query = "SELECT
        COALESCE(COUNT(tbl_clientes.id_cliente), 0) AS clientes_creados
        FROM tbl_clientes
        WHERE tbl_clientes.fecha_creado BETWEEN '" . $fechaInicio . "' AND '" . $fechaFin . "';";
        return $this->EjecutarQuery($query);
    }
}
