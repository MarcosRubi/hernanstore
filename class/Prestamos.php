<?php
class Prestamos extends DB
{
    public $capital_prestamo;
    public $num_cuotas;
    public $porcentaje_interes;
    public $fecha_primer_pago;
    public $ganancias;
    public $recalcular_interes;
    public $id_estado;
    public $id_cliente;
    public $id_plazo_pago;

    public function buscarPorId($id)
    {
        $query = "SELECT id_prestamo FROM tbl_prestamos WHERE id_prestamo = '" . $id . "'";
        return $this->EjecutarQuery($query);
    }
    public function listarPrestamosPorcliente($id)
    {
        $query = "SELECT * FROM vta_listar_prestamos WHERE id_cliente = '" . $id . "'";
        return $this->EjecutarQuery($query);
    }
    public function ListarDatosParaDocumento($id)
    {
        $query = "SELECT * FROM vta_datos_prestamos WHERE id_prestamo = '" . $id . "'";
        return $this->EjecutarQuery($query);
    }
    public function listarEstadosPrestamos()
    {
        $query = "SELECT * FROM vta_listar_estados_prestamos";
        return $this->EjecutarQuery($query);
    }

    public function listarPlazoPrestamos()
    {
        $query = "SELECT * FROM vta_listar_plazos_pagos";
        return $this->EjecutarQuery($query);
    }
    public function listarEstadosCuotas()
    {
        $query = "SELECT * FROM vta_listar_estados_cuotas";
        return $this->EjecutarQuery($query);
    }
    public function buscarEstadoCuotaPorId($id)
    {
        $query = "SELECT estado_cuota FROM vta_listar_estados_cuotas WHERE id_estado_cuota = '" . $id . "'";
        return $this->EjecutarQuery($query);
    }

    // public function buscarPorIdCliente($id)
    // {
    //     $query = "SELECT * FROM vta_listar_prestamos WHERE id_cliente='" . $id . "'";
    //     return $this->EjecutarQuery($query);
    // }

    public function Insertar()
    {
        $query = "INSERT INTO tbl_prestamos(
            capital_prestamo,
            num_cuotas,
            porcentaje_interes,
            fecha_primer_pago,
            ganancias,
            recalcular_interes,
            id_estado,
            id_cliente,
            id_plazo_pago )
            VALUES (
            '" . $this->capital_prestamo . "',
            '" . $this->num_cuotas . "',
            '" . $this->porcentaje_interes . "',
            '" . $this->fecha_primer_pago . "',
            '" . $this->ganancias . "',
            '" . $this->recalcular_interes . "',
            '" . $this->id_estado . "',
            '" . $this->id_cliente . "',
            '" . $this->id_plazo_pago . "' ) ";
        return $this->EjecutarQuery($query);
    }

    public function ObtenerGananciasPorCliete($id)
    {
        $query = "SELECT
        COALESCE(SUM(ganancias), 0) AS total_ganancias
        FROM
            vta_listar_prestamos
        WHERE
            id_cliente = '" . $id . "'";
        return $this->EjecutarQuery($query);
    }
    public function ObtenerTotalCapitalPrestadoPorCliente($id)
    {
        $query = "SELECT
        COALESCE(SUM(capital_prestamo), 0) AS total_monto_prestamos
        FROM
            vta_listar_prestamos
        WHERE
            id_cliente = '" . $id . "'";
        return $this->EjecutarQuery($query);
    }

    // public function Actualizar($id)
    // {
    //     $query = "UPDATE tbl_empleados SET 
    //     nombre_estado = '" . $this->nombre_estado . "',
    //     correo = '" . $this->correo . "',
    //     url_foto = '" . $this->url_foto . "',
    //     contrasenna = '" .  password_hash($this->contrasenna, PASSWORD_DEFAULT) . "',
    //     id_rol = '" . $this->id_rol . "' 
    //     WHERE id_empleado='" . $id . "' ";

    //     return $this->EjecutarQuery($query);
    // }

    public function Eliminar($id)
    {
        $query = "UPDATE tbl_prestamos SET Eliminado='S' WHERE id_prestamo='" . $id . "'";
        return $this->EjecutarQuery($query);
    }
}
