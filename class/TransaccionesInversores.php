<?php
class TransaccionesInversores extends DB
{
    public $monto;
    public $id_inversor;
    public $id_tipo_movimiento;
    public $detalles;
    public $fecha;


    public function Insertar()
    {
        $query = "INSERT INTO tbl_movimientos_inversores(
            monto,
            id_inversor,
            id_tipo_movimiento,
            fecha,
            detalles )
            VALUES (
            '" . $this->monto . "',
            '" . $this->id_inversor . "',
            '" . $this->id_tipo_movimiento . "',
            '" . $this->fecha . "',
            '" . $this->detalles . "' ) ";
        return $this->EjecutarQuery($query);
    }

    public function listarMovimientosInversor($id)
    {
        $query = "SELECT * FROM vta_movimientos_inversor ";
        return $this->EjecutarQuery($query);
    }
    public function buscarMovimientoPorId($id)
    {
        $query = "SELECT * FROM vta_movimientos_inversor WHERE id_movimiento_inversor = '" . $id . "' ";
        return $this->EjecutarQuery($query);
    }

    public function Actualizar($id)
    {
        $query = "UPDATE tbl_movimientos_inversores SET 
        monto = '" . $this->monto . "',
        id_tipo_movimiento = '" . $this->id_tipo_movimiento . "', 
        fecha = '" . $this->fecha . "', 
        detalles = '" . $this->detalles . "' 
        WHERE id_movimiento_inversor='" . $id . "' ";

        return $this->EjecutarQuery($query);
    }

    public function Eliminar($id)
    {
        $query = "UPDATE tbl_movimientos_inversores SET eliminado='S' WHERE id_movimiento_inversor='" . $id . "'";
        return $this->EjecutarQuery($query);
    }
}
