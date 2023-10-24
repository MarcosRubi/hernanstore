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
        $query = "SELECT * FROM vta_movimientos_inversor WHERE id_inversor = '" . $id . "' ";
        return $this->EjecutarQuery($query);
    }
    public function listarDatosInversores()
    {
        $query = "SELECT * FROM vta_inversores ";
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

    public function ObtenerEstadisticasPorMes()
    {
        $query = "SELECT
        calendar.mes,
        COALESCE(SUM(CASE WHEN m.id_tipo_movimiento = 2 THEN monto ELSE 0 END), 0) AS total_ingresos,
        COALESCE(SUM(CASE WHEN m.id_tipo_movimiento = 3 THEN monto ELSE 0 END), 0) AS total_egresos,
        COALESCE(SUM(CASE WHEN m.id_tipo_movimiento = 4 THEN monto ELSE 0 END), 0) AS total_ganancias
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
        LEFT JOIN tbl_inversores i
        ON 1 = 1
        LEFT JOIN tbl_movimientos_inversores m
        ON i.id_inversor = m.id_inversor
            AND DATE_FORMAT(m.fecha, '%Y-%m') = calendar.mes
            AND m.eliminado = 'N'
        WHERE i.eliminado = 'N'
        GROUP BY calendar.mes
        ORDER BY calendar.mes;";
        return $this->EjecutarQuery($query);
    }
    public function ObtenerEstadisticasPorSemana()
    {
        $query = "SELECT
            calendar.semana,
            COALESCE(SUM(CASE WHEN m.id_tipo_movimiento = 2 THEN monto ELSE 0 END), 0) AS total_ingresos,
            COALESCE(SUM(CASE WHEN m.id_tipo_movimiento = 3 THEN monto ELSE 0 END), 0) AS total_egresos,
            COALESCE(SUM(CASE WHEN m.id_tipo_movimiento = 4 THEN monto ELSE 0 END), 0) AS total_ganancias
        FROM (
            SELECT WEEK(DATE_ADD(DATE_FORMAT(NOW(), '%Y-%m-01'), INTERVAL (n-1) WEEK)) AS semana
            FROM (
                SELECT 1 AS n UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5
            ) AS numbers
        ) AS calendar
        LEFT JOIN tbl_inversores i
        ON 1 = 1
        LEFT JOIN tbl_movimientos_inversores m
        ON i.id_inversor = m.id_inversor
            AND WEEK(m.fecha) = calendar.semana
            AND m.eliminado = 'N'
        WHERE i.eliminado = 'N'
        GROUP BY calendar.semana
        ORDER BY calendar.semana;
        ";
        return $this->EjecutarQuery($query);
    }
    public function ObtenerEstadisticasPorSemanaActual()
    {
        $query = "SELECT
        calendar.semana,
        COALESCE(SUM(CASE WHEN m.id_tipo_movimiento = 2 THEN m.monto ELSE 0 END), 0) AS total_ingresos,
        COALESCE(SUM(CASE WHEN m.id_tipo_movimiento = 3 THEN m.monto ELSE 0 END), 0) AS total_egresos,
        COALESCE(SUM(CASE WHEN m.id_tipo_movimiento = 4 THEN m.monto ELSE 0 END), 0) AS total_ganancias
        FROM (
            SELECT WEEK(DATE_ADD(DATE_FORMAT(NOW(), '%Y-%m-01'), INTERVAL (n-1) WEEK)) AS semana
            FROM (
                SELECT 1 AS n UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5
            ) AS numbers
        ) AS calendar
        LEFT JOIN tbl_inversores i
            ON 1 = 1
        LEFT JOIN tbl_movimientos_inversores m
            ON i.id_inversor = m.id_inversor
            AND WEEK(m.fecha) = calendar.semana
            AND m.eliminado = 'N'
        WHERE i.eliminado = 'N'
        GROUP BY calendar.semana
        ORDER BY calendar.semana;
        ";
        return $this->EjecutarQuery($query);
    }

    public function ObtenerEstadisticasDeInversores($fechaInicio, $fechaFin)
    {
        $query = "SELECT
        i.id_inversor,
        i.nombre_inversor,
        COALESCE(SUM(CASE WHEN m.id_tipo_movimiento = 2 THEN monto ELSE 0 END), 0) AS total_ingresos,
        COALESCE(SUM(CASE WHEN m.id_tipo_movimiento = 3 THEN monto ELSE 0 END), 0) AS total_egresos,
        COALESCE(SUM(CASE WHEN m.id_tipo_movimiento = 4 THEN monto ELSE 0 END), 0) AS total_ganancias
        FROM
            tbl_inversores i
        LEFT JOIN
            tbl_movimientos_inversores m
        ON
            i.id_inversor = m.id_inversor
            AND m.fecha BETWEEN '" . $fechaInicio . "' AND '" . $fechaFin . "'
            AND m.eliminado = 'N'
        WHERE
            i.eliminado = 'N'
        GROUP BY
            i.id_inversor,
            i.nombre_inversor
        ORDER BY
            i.id_inversor;
        ";
        return $this->EjecutarQuery($query);
    }

    public function ObtenerEgresosAnualesPorSemanas($fechaInicio, $fechaFin)
    {
        $query = "SELECT
            DATE_FORMAT( DATE_ADD( tbl_movimientos_inversores.fecha, INTERVAL 1 - DAYOFWEEK( tbl_movimientos_inversores.fecha ) DAY ), '%Y-%U' ) AS semana,
            COALESCE ( SUM( CASE WHEN tbl_movimientos_inversores.id_tipo_movimiento IN ( 3, 4 ) THEN tbl_movimientos_inversores.monto ELSE 0 END ), 0 ) AS total_egresos,
            COALESCE ( SUM( CASE WHEN tbl_movimientos_inversores.id_tipo_movimiento = 2 THEN tbl_movimientos_inversores.monto ELSE 0 END ), 0 ) AS total_ingresos,
            MIN(
            DATE_ADD( tbl_movimientos_inversores.fecha, INTERVAL 1 - DAYOFWEEK( tbl_movimientos_inversores.fecha ) DAY )) AS fecha_inicial_semana,
            MAX(
            DATE_ADD( tbl_movimientos_inversores.fecha, INTERVAL 7 - DAYOFWEEK( tbl_movimientos_inversores.fecha ) DAY )) AS fecha_final_semana 
        FROM
            tbl_movimientos_inversores 
        WHERE
            DATE ( tbl_movimientos_inversores.fecha ) >= '" . $fechaInicio . "' 
            AND DATE ( tbl_movimientos_inversores.fecha ) <= '" . $fechaFin . "' 
            AND tbl_movimientos_inversores.eliminado = 'N' 
            GROUP BY
                semana 
            ORDER BY
                semana;
        ";
        return $this->EjecutarQuery($query);
    }
    public function ObtenerEstadisticasPorFechas($fechaInicio, $fechaFin)
    {
        $query = "SELECT
        tbl_movimientos_inversores.monto, 
        tbl_tipos_movimientos.nombre_tipo_movimiento, 
        tbl_movimientos_inversores.fecha, 
        tbl_inversores.nombre_inversor
        FROM
            tbl_inversores
            INNER JOIN
            tbl_movimientos_inversores
            ON 
                tbl_inversores.id_inversor = tbl_movimientos_inversores.id_inversor
            INNER JOIN
            tbl_tipos_movimientos
            ON 
                tbl_movimientos_inversores.id_tipo_movimiento = tbl_tipos_movimientos.id_tipo_movimiento
        WHERE
            tbl_movimientos_inversores.eliminado = 'N' AND
            tbl_movimientos_inversores.fecha BETWEEN '" . $fechaInicio . "' AND '" . $fechaFin . "' 
        ORDER BY tbl_movimientos_inversores.fecha
        ";
        return $this->EjecutarQuery($query);
    }

    public function ObtenerTotalInvertido()
    {
        $query = "SELECT SUM(
            CASE
                WHEN id_tipo_movimiento = 3 THEN -monto
                ELSE monto
            END
        ) AS saldo
        FROM tbl_movimientos_inversores
        WHERE eliminado = 'N' AND id_tipo_movimiento = 2;
        ";
        return $this->EjecutarQuery($query);
    }
}
