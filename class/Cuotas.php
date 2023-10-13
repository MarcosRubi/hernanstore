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
        $query = "SELECT id_cuota, fecha_pago FROM tbl_cuotas WHERE id_prestamo='" . $id . "' AND eliminado='N' ORDER BY id_cuota DESC LIMIT 1";
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
    public function ObtenerIngresosPorSemanas()
    {
        $query = "SELECT
        calendar.semana,
        COALESCE(SUM(vta_listar_pagos.pago_cuota), 0) AS suma_cuotas
            FROM (
                SELECT WEEK(DATE_ADD(DATE_FORMAT(NOW(), '%Y-%m-01'), INTERVAL (n-1) WEEK)) AS semana
                FROM (
                    SELECT 1 AS n UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5
                ) AS numbers
            ) AS calendar
            LEFT JOIN vta_listar_pagos
            ON WEEK(vta_listar_pagos.fecha_pago) = calendar.semana
            GROUP BY calendar.semana
            ORDER BY calendar.semana;
        ";
        return $this->EjecutarQuery($query);
    }
    public function ObtenerIngresosPorSemanaActual()
    {
        $query = "SELECT
        DATE(calendar.dia_semana) AS dia,
        COALESCE(SUM(vta_listar_pagos.pago_cuota), 0) AS suma_cuotas
            FROM (
                SELECT
                    DATE_ADD(NOW(), INTERVAL 1 - DAYOFWEEK(NOW()) DAY) + INTERVAL (n-1) DAY AS dia_semana
                FROM (
                    SELECT 1 AS n UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7
                ) AS numbers
            ) AS calendar
            LEFT JOIN vta_listar_pagos
                ON DATE(vta_listar_pagos.fecha_pago) = DATE(calendar.dia_semana)
            GROUP BY dia
            ORDER BY dia;
        ";
        return $this->EjecutarQuery($query);
    }

    public function ObtenerIngresosAnualesPorSemanas($fechaInicio, $fechaFin)
    {
        $query = "SELECT
        DATE_FORMAT(DATE_ADD(vta_listar_pagos.fecha_pago, INTERVAL 1-DAYOFWEEK(vta_listar_pagos.fecha_pago) DAY), '%Y-%U') AS semana,
        COALESCE(SUM(vta_listar_pagos.pago_cuota), 0) AS suma_cuotas,
        MIN(DATE_ADD(vta_listar_pagos.fecha_pago, INTERVAL 1-DAYOFWEEK(vta_listar_pagos.fecha_pago) DAY)) AS fecha_inicial_semana,
        MAX(DATE_ADD(vta_listar_pagos.fecha_pago, INTERVAL 7-DAYOFWEEK(vta_listar_pagos.fecha_pago) DAY)) AS fecha_final_semana
        FROM vta_listar_pagos
        WHERE DATE(vta_listar_pagos.fecha_pago) >= '" . $fechaInicio . "' AND DATE(vta_listar_pagos.fecha_pago) <= '" . $fechaFin . "'
        GROUP BY semana
        ORDER BY semana;
        ";
        return $this->EjecutarQuery($query);
    }

    public function ObtenerIngresosPorFechas($fechaInicio, $fechaFin)
    {
        $query = "SELECT
        tbl_cuotas.pago_cuota, 
        tbl_cuotas.fecha_pago, 
        tbl_prestamos.id_prestamo, 
        tbl_clientes.nombre_cliente
    FROM
        tbl_cuotas
        INNER JOIN
        tbl_prestamos
        ON 
            tbl_cuotas.id_prestamo = tbl_prestamos.id_prestamo
        INNER JOIN
        tbl_clientes
        ON 
            tbl_prestamos.id_cliente = tbl_clientes.id_cliente
    WHERE
        tbl_cuotas.eliminado = 'N' AND
        tbl_cuotas.fecha_pago BETWEEN '" . $fechaInicio . "' AND '" . $fechaFin . "'";
        return $this->EjecutarQuery($query);
    }
}
