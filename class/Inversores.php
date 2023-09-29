<?php
class Inversores extends DB
{
    public $nombre_inversor;
    public $detalles;

    public function listarTodo()
    {
        $query = "SELECT id_inversor, nombre_inversor, detalles FROM tbl_inversores WHERE eliminado='N'";
        return $this->EjecutarQuery($query);
    }
    public function listarTiposMovimientos()
    {
        $query = "SELECT id_tipo_movimiento, nombre_tipo_movimiento FROM tbl_tipos_movimientos WHERE eliminado = 'N'";
        return $this->EjecutarQuery($query);
    }

    public function buscarPorId($id)
    {
        $query = "SELECT * FROM tbl_inversores WHERE id_inversor='" . $id . "'";
        return $this->EjecutarQuery($query);
    }


    public function Insertar()
    {
        $query = "INSERT INTO tbl_inversores(
            nombre_inversor,
            detalles )
            VALUES (
            '" . $this->nombre_inversor . "',
            '" . $this->detalles . "' ) ";
        return $this->EjecutarQuery($query);
    }

    public function Actualizar($id)
    {
        $query = "UPDATE tbl_inversores SET 
        nombre_inversor = '" . $this->nombre_inversor . "',
        detalles = '" . $this->detalles . "' 
        WHERE id_inversor='" . $id . "' ";

        return $this->EjecutarQuery($query);
    }

    public function Eliminar($id)
    {
        $query = "UPDATE tbl_inversores SET eliminado='S' WHERE id_inversor='" . $id . "'";
        return $this->EjecutarQuery($query);
    }
}
