<?php
class Excedente extends DB
{
    public $fecha;
    public $descripcion;
    public $notas;
    public $monto;

    public function listarTodo()
    {
        $query = "SELECT * FROM vta_listar_excedentes";
        return $this->EjecutarQuery($query);
    }

    public function Insertar()
    {
        $query = "INSERT INTO tbl_excedentes(
            fecha,
            descripcion,
            monto,
            Eliminado )
            VALUES (
            '" . $this->fecha . "',
            '" . $this->descripcion . "',
            '" . $this->monto . "',
            'N' ) ";
        return $this->EjecutarQuery($query);
    }

    public function Actualizar($id)
    {
        $query = "UPDATE tbl_excedentes SET 
        notas = '" . $this->notas . "',
        monto = '" . $this->monto . "' 
        WHERE id_excedente='" . $id . "' ";

        return $this->EjecutarQuery($query);
    }

    public function Eliminar($id)
    {
        $query = "UPDATE tbl_excedentes SET Eliminado='S' WHERE id_excedente='" . $id . "'";
        return $this->EjecutarQuery($query);
    }
    public function ObtenerBalance()
    {
        $query = "SELECT SUM(vta_listar_excedentes.monto) as balance FROM vta_listar_excedentes";
        return $this->EjecutarQuery($query);
    }
}
