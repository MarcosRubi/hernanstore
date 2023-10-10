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

    public function ObtenerIngresosAnualesPorSemanas()
    {
        $query = "SELECT
        calendar.semana,
        COALESCE(SUM(vta_listar_pagos.pago_cuota), 0) AS suma_cuotas,
        MIN(fecha_inicial_semana) AS fecha_inicial_semana,
        MAX(fecha_final_semana) AS fecha_final_semana
        FROM (
            SELECT
                (n + 1) AS semana,
                DATE_ADD(DATE_FORMAT(NOW(), '%Y-01-01'), INTERVAL n WEEK) AS fecha_inicial_semana,
                DATE_ADD(DATE_ADD(DATE_FORMAT(NOW(), '%Y-01-01'), INTERVAL n WEEK), INTERVAL 6 DAY) AS fecha_final_semana
            FROM (
                SELECT 0 AS n UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10 UNION SELECT 11 UNION SELECT 12 UNION SELECT 13 UNION SELECT 14 UNION SELECT 15 UNION SELECT 16 UNION SELECT 17 UNION SELECT 18 UNION SELECT 19 UNION SELECT 20 UNION SELECT 21 UNION SELECT 22 UNION SELECT 23 UNION SELECT 24 UNION SELECT 25 UNION SELECT 26 UNION SELECT 27 UNION SELECT 28 UNION SELECT 29 UNION SELECT 30 UNION SELECT 31 UNION SELECT 32 UNION SELECT 33 UNION SELECT 34 UNION SELECT 35 UNION SELECT 36 UNION SELECT 37 UNION SELECT 38 UNION SELECT 39 UNION SELECT 40 UNION SELECT 41 UNION SELECT 42 UNION SELECT 43 UNION SELECT 44 UNION SELECT 45 UNION SELECT 46 UNION SELECT 47 UNION SELECT 48 UNION SELECT 49 UNION SELECT 50 UNION SELECT 51 UNION SELECT 52 UNION SELECT 53 UNION SELECT 54 UNION SELECT 55 UNION SELECT 56
            ) AS numbers
        ) AS calendar
        LEFT JOIN vta_listar_pagos
            ON DATE(vta_listar_pagos.fecha_pago) BETWEEN fecha_inicial_semana AND fecha_final_semana
        GROUP BY calendar.semana
        ORDER BY calendar.semana;
        ";
        return $this->EjecutarQuery($query);
    }
}
