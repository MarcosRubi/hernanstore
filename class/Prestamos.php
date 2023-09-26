<?php
class Prestamos extends DB
{
    public $capital_prestamo;
    public $num_cuotas;
    public $fecha_primer_pago;
    public $fecha_siguiente_pago;
    public $fecha_prestamo;
    public $ganancias;
    public $valor_cuota;
    public $detalles;
    public $id_estado;
    public $id_cliente;
    public $id_plazo_pago;

    public function buscarPorId($id)
    {
        $query = "SELECT * FROM vta_listar_prestamos WHERE id_prestamo = '" . $id . "'";
        return $this->EjecutarQuery($query);
    }

    public function listarPrestamosPorcliente($id)
    {
        $query = "SELECT * FROM vta_listar_prestamos WHERE id_cliente = '" . $id . "' ORDER BY fecha_prestamo DESC";
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
        $query = "SELECT * FROM vta_listar_estados_cuotas ORDER BY estado_cuota DESC";
        return $this->EjecutarQuery($query);
    }

    public function buscarEstadoCuotaPorId($id)
    {
        $query = "SELECT estado_cuota FROM vta_listar_estados_cuotas WHERE id_estado_cuota = '" . $id . "'";
        return $this->EjecutarQuery($query);
    }

    public function Insertar()
    {
        $query = "INSERT INTO tbl_prestamos(
            capital_prestamo,
            num_cuotas,
            fecha_primer_pago,
            fecha_siguiente_pago,
            fecha_prestamo,
            ganancias,
            valor_cuota,
            detalles,
            id_estado,
            id_cliente,
            id_plazo_pago )
            VALUES (
            '" . $this->capital_prestamo . "',
            '" . $this->num_cuotas . "',
            '" . $this->fecha_primer_pago . "',
            '" . $this->fecha_primer_pago . "',
            '" . $this->fecha_prestamo . "',
            '" . $this->ganancias . "',
            '" . $this->valor_cuota . "',
            '" . $this->detalles . "',
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

    public function Actualizar($id)
    {
        $query = "UPDATE tbl_prestamos SET 
        capital_prestamo = '" . $this->capital_prestamo . "',
        num_cuotas = '" . $this->num_cuotas . "',
        detalles = '" . $this->detalles . "',
        fecha_primer_pago = '" . $this->fecha_primer_pago . "',
        fecha_prestamo = '" . $this->fecha_prestamo . "',
        ganancias = '" . $this->ganancias . "',
        id_estado = '" . $this->id_estado . "',
        id_plazo_pago = '" . $this->id_plazo_pago . "',
        valor_cuota = '" . $this->valor_cuota . "' 
        WHERE id_prestamo='" . $id . "' ";

        return $this->EjecutarQuery($query);
    }
    public function ActualizarNumCuotas($id)
    {
        $query = "UPDATE tbl_prestamos SET 
        num_cuotas = '" . $this->num_cuotas . "',
        id_estado = '4'
        WHERE id_prestamo='" . $id . "' ";

        return $this->EjecutarQuery($query);
    }

    public function ActualizarFechaSiguentePago($fecha, $id)
    {
        $query = "UPDATE tbl_prestamos SET 
        fecha_siguiente_pago = '" . $fecha . "'
        WHERE id_prestamo='" . $id . "' ";

        return $this->EjecutarQuery($query);
    }

    public function Eliminar($id)
    {
        $query = "UPDATE tbl_prestamos SET Eliminado='S' WHERE id_prestamo='" . $id . "'";
        return $this->EjecutarQuery($query);
    }
}
