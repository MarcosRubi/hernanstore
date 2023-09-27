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
    public function buscarEstadoCuotaPorId($id)
    {
        $query = "SELECT estado_cuota FROM vta_listar_estados_cuotas WHERE id_estado_cuota = '" . $id . "'";
        return $this->EjecutarQuery($query);
    }

    public function listarPrestamosPorcliente($id)
    {
        $query = "SELECT * FROM vta_listar_prestamos WHERE id_cliente = '" . $id . "' ORDER BY fecha_prestamo DESC";
        return $this->EjecutarQuery($query);
    }
    public function listarPrestamosPorEstado($id_estado, $order = 'fecha_siguiente_pago')
    {
        $query = "SELECT * FROM vta_prestamos WHERE id_estado = '" . $id_estado . "' ORDER BY
        $order ";
        return $this->EjecutarQuery($query);
    }
    public function listarPrestamosAtrasados()
    {
        $query = "SELECT * FROM vta_prestamos WHERE id_estado = '3' AND  vta_prestamos.fecha_siguiente_pago < CURDATE() ORDER BY
        fecha_siguiente_pago ";
        return $this->EjecutarQuery($query);
    }
    public function listarPrestamosProximosPago()
    {
        $query = "SELECT * FROM vta_prestamos WHERE id_estado = '3'  AND vta_prestamos.fecha_siguiente_pago >= CURDATE() 
        AND vta_prestamos.fecha_siguiente_pago <= CURDATE() + INTERVAL 5 DAY ORDER BY
        fecha_siguiente_pago ";
        return $this->EjecutarQuery($query);
    }
    public function listarUltimosprestamos()
    {
        $query = "SELECT * FROM vta_listar_ultimos_prestamos";
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
    public function ObtenerGananciasPorCliente($id)
    {
        $query = "SELECT
        COALESCE(SUM(ganancias), 0) AS total_ganancias
        FROM
            vta_listar_prestamos
        WHERE
            id_cliente = '" . $id . "'";
        return $this->EjecutarQuery($query);
    }
    public function ObtenerGanancias($fechaInicio, $fechaFin)
    {
        $query = "SELECT
        COALESCE(SUM(tbl_prestamos.ganancias), 0) AS suma_ganancias
            FROM tbl_prestamos
            WHERE tbl_prestamos.eliminado = 'N'
            AND tbl_prestamos.fecha_prestamo BETWEEN '" . $fechaInicio . "' AND '" . $fechaFin . "';";
        return $this->EjecutarQuery($query);
    }
    public function ObtenerPrestamosCreados($fechaInicio, $fechaFin)
    {
        $query = "SELECT
        COALESCE(COUNT(tbl_prestamos.id_prestamo), 0) AS prestamos_activos
            FROM tbl_prestamos
            WHERE tbl_prestamos.eliminado = 'N'
            AND tbl_prestamos.id_estado IN ('3', '4')
            AND tbl_prestamos.fecha_prestamo BETWEEN '" . $fechaInicio . "' AND '" . $fechaFin . "';";
        return $this->EjecutarQuery($query);
    }
    public function ObtenerCapitalPrestado($fechaInicio, $fechaFin, $filter = false)
    {
        if ($filter) {
            $condition = "AND tbl_prestamos.id_estado = 3";
        } else {
            $condition = "AND tbl_prestamos.id_estado IN ('3','4')";
        }
        $query = "SELECT
        COALESCE(SUM(tbl_prestamos.capital_prestamo), 0) AS suma_prestamos
            FROM tbl_prestamos
            WHERE tbl_prestamos.eliminado = 'N'
            $condition
            AND tbl_prestamos.fecha_prestamo BETWEEN '" . $fechaInicio . "' AND '" . $fechaFin . "';";
        return $this->EjecutarQuery($query);
    }
    public function ObtenerTotalPrestamosPorEstado($id_estado)
    {
        $query = "SELECT
        COALESCE(COUNT(tbl_prestamos.id_prestamo), 0) AS total_prestamos
            FROM tbl_prestamos
            WHERE tbl_prestamos.eliminado = 'N'
            AND tbl_prestamos.id_estado = '" . $id_estado . "';";
        return $this->EjecutarQuery($query);
    }

    public function ObtenerTotalPrestamosAtrasados()
    {
        $query = "SELECT
        COALESCE(COUNT(tbl_prestamos.id_prestamo), 0) AS total_prestamos
            FROM
                tbl_prestamos
            WHERE
                tbl_prestamos.eliminado = 'N'
                AND tbl_prestamos.fecha_siguiente_pago < CURDATE()
				AND tbl_prestamos.id_estado = 3;";
        return $this->EjecutarQuery($query);
    }
    public function ObtenerTotalProximosPagos()
    {
        $query = "SELECT
        COALESCE(COUNT(tbl_prestamos.id_prestamo), 0) AS total_prestamos
            FROM
                tbl_prestamos
            WHERE
                tbl_prestamos.eliminado = 'N'
                AND tbl_prestamos.id_estado = 3
                AND tbl_prestamos.fecha_siguiente_pago >= CURDATE() + INTERVAL 1 DAY
                AND tbl_prestamos.fecha_siguiente_pago <= CURDATE() + INTERVAL 5 DAY;
            ";
        return $this->EjecutarQuery($query);
    }

    public function ObtenerEgresosPorMes()
    {
        $query = "SELECT
        calendar.mes,
        COALESCE(SUM(tbl_prestamos.capital_prestamo), 0) AS suma_prestamos
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
            LEFT JOIN tbl_prestamos
            ON DATE_FORMAT(tbl_prestamos.fecha_prestamo, '%Y-%m') = calendar.mes
            AND tbl_prestamos.eliminado = 'N'
            GROUP BY calendar.mes
            ORDER BY calendar.mes;";
        return $this->EjecutarQuery($query);
    }
}
