<?php
class Cuotas extends DB
{
    public $pago_cuota;
    public $fecha_pago;
    public $id_prestamo;
    public $num_cuota;
    public $id_estado_cuota;


    public function buscarPorIdPrestamo($id)
    {
        $query = "SELECT * FROM vta_listar_cuotas_prestamos WHERE id_prestamo='" . $id . "'";
        return $this->EjecutarQuery($query);
    }
    public function buscarPorIdCuota($id)
    {
        $query = "SELECT * FROM vta_listar_cuotas_prestamos WHERE id_cuota='" . $id . "'";
        return $this->EjecutarQuery($query);
    }

    public function ObtenerUltimoPagoCuota($id)
    {
        $query = "SELECT * FROM vta_listar_cuotas_prestamos WHERE id_prestamo='" . $id . "' ORDER BY id_cuota DESC LIMIT 1";
        return $this->EjecutarQuery($query);
    }

    public function Insertar()
    {
        $query = "INSERT INTO tbl_cuotas(
            pago_cuota,
            fecha_pago,
            num_cuota,
            id_prestamo,
            id_estado_cuota,
            Eliminado )
            VALUES (
            '" . $this->pago_cuota . "',
            '" . $this->fecha_pago . "',
            '" . $this->num_cuota . "',
            '" . $this->id_prestamo . "',
            '" . $this->id_estado_cuota . "',
            'N' ) ";
        return $this->EjecutarQuery($query);
    }

    public function CapitalPagado($id)
    {
        $query = "SELECT
        COALESCE(SUM(pago_cuota), 0) AS total
        FROM
        vta_listar_cuotas_prestamos
        WHERE
            id_prestamo = '" . $id . "'";
        return $this->EjecutarQuery($query);
    }

    public function Actualizar($id)
    {
        $query = "UPDATE tbl_cuotas SET 
        pago_cuota = '" . $this->pago_cuota . "',
        fecha_pago = '" . $this->fecha_pago . "', 
        id_estado_cuota = '" . $this->id_estado_cuota . "' 
        WHERE id_cuota='" . $id . "' ";

        return $this->EjecutarQuery($query);
    }

    public function Eliminar($id)
    {
        $query = "UPDATE tbl_cuotas SET Eliminado='S' WHERE id_cuota='" . $id . "'";
        return $this->EjecutarQuery($query);
    }

    public function ObtenerIngresosPorMes()
    {
        $query = "SELECT
                calendar.mes,
                COALESCE(SUM(vta_listar_pagos.pago_cuota), 0) AS suma_cuotas
            FROM (
                SELECT CONCAT(YEAR(CURDATE()), '-01') AS mes
                UNION SELECT CONCAT(YEAR(CURDATE()), '-02')
                UNION SELECT CONCAT(YEAR(CURDATE()), '-03')
                UNION SELECT CONCAT(YEAR(CURDATE()), '-04')
                UNION SELECT CONCAT(YEAR(CURDATE()), '-05')
                UNION SELECT CONCAT(YEAR(CURDATE()), '-06')
                UNION SELECT CONCAT(YEAR(CURDATE()), '-07')
                UNION SELECT CONCAT(YEAR(CURDATE()), '-08')
                UNION SELECT CONCAT(YEAR(CURDATE()), '-09')
                UNION SELECT CONCAT(YEAR(CURDATE()), '-10')
                UNION SELECT CONCAT(YEAR(CURDATE()), '-11')
                UNION SELECT CONCAT(YEAR(CURDATE()), '-12')
            ) AS calendar
            LEFT JOIN vta_listar_pagos
            ON DATE_FORMAT(vta_listar_pagos.fecha_pago, '%Y-%m') = calendar.mes
            GROUP BY calendar.mes
            ORDER BY calendar.mes;";
        return $this->EjecutarQuery($query);
    }
}
