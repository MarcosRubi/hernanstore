<?php
class TransaccionesInversores extends DB
{
    public $monto;
    public $id_inversor;
    public $id_tipo_movimiento;
    public $detalles;


    public function Insertar()
    {
        $query = "INSERT INTO tbl_movimientos_inversores(
            monto,
            id_inversor,
            id_tipo_movimiento,
            detalles )
            VALUES (
            '" . $this->monto . "',
            '" . $this->id_inversor . "',
            '" . $this->id_tipo_movimiento . "',
            '" . $this->detalles . "' ) ";
        return $this->EjecutarQuery($query);
    }

    // public function Actualizar($id)
    // {
    //     $query = "UPDATE tbl_inversores SET 
    //     nombre_inversor = '" . $this->nombre_inversor . "',
    //     detalles = '" . $this->detalles . "' 
    //     WHERE id_inversor='" . $id . "' ";

    //     return $this->EjecutarQuery($query);
    // }

    // public function Eliminar($id)
    // {
    //     $query = "UPDATE tbl_inversores SET eliminado='S' WHERE id_inversor='" . $id . "'";
    //     return $this->EjecutarQuery($query);
    // }
}
