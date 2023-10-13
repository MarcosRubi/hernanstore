<?php
class TransaccionesAdicionales extends DB
{
    public $monto;
    public $id_tipo_movimiento;
    public $descripcion;
    public $fecha;


    public function Insertar()
    {
        $query = "INSERT INTO tbl_transacciones_adicionales(
            monto,
            id_tipo_movimiento,
            fecha,
            descripcion )
            VALUES (
            '" . $this->monto . "',
            '" . $this->id_tipo_movimiento . "',
            '" . $this->fecha . "',
            '" . $this->descripcion . "' ) ";
        return $this->EjecutarQuery($query);
    }

    public function ListarTodo()
    {
        $query = "SELECT
        tbl_transacciones_adicionales.id_transaccion_adicional, 
        tbl_transacciones_adicionales.monto, 
        tbl_tipos_movimientos.id_tipo_movimiento, 
        tbl_tipos_movimientos.nombre_tipo_movimiento, 
        tbl_transacciones_adicionales.fecha, 
        tbl_transacciones_adicionales.descripcion
        FROM
            tbl_transacciones_adicionales
            INNER JOIN
            tbl_tipos_movimientos
            ON 
                tbl_transacciones_adicionales.id_tipo_movimiento = tbl_tipos_movimientos.id_tipo_movimiento
        WHERE
            tbl_transacciones_adicionales.eliminado = 'N'";
        return $this->EjecutarQuery($query);
    }

    public function Actualizar($id)
    {
        $query = "UPDATE tbl_transacciones_adicionales SET 
        monto = '" . $this->monto . "',
        id_tipo_movimiento = '" . $this->id_tipo_movimiento . "', 
        fecha = '" . $this->fecha . "', 
        descripcion = '" . $this->descripcion . "' 
        WHERE id_transaccion_adicional='" . $id . "' ";

        return $this->EjecutarQuery($query);
    }

    public function Eliminar($id)
    {
        $query = "UPDATE tbl_transacciones_adicionales SET eliminado='S' WHERE id_transaccion_adicional='" . $id . "'";
        return $this->EjecutarQuery($query);
    }

    public function ObtenerEstadisticasPorMes()
    {
        $query = "SELECT
        calendar.mes,
        COALESCE(SUM(CASE WHEN t.id_tipo_movimiento = 2 THEN t.monto ELSE 0 END), 0) AS total_ingresos,
        COALESCE(SUM(CASE WHEN t.id_tipo_movimiento = 3 THEN t.monto ELSE 0 END), 0) AS total_egresos,
        COALESCE(SUM(CASE WHEN t.id_tipo_movimiento = 4 THEN t.monto ELSE 0 END), 0) AS total_ganancias
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
        LEFT JOIN tbl_transacciones_adicionales t
            ON DATE_FORMAT(t.fecha, '%Y-%m') = calendar.mes
            AND t.eliminado = 'N'
        GROUP BY calendar.mes
        ORDER BY calendar.mes;";
        return $this->EjecutarQuery($query);
    }

    public function ObtenerEstadisticasPorSemanaActual()
    {
        $query = "SELECT
        DATE(calendar.dia_semana) AS dia,
        COALESCE(SUM(CASE WHEN t.id_tipo_movimiento = 2 THEN t.monto ELSE 0 END), 0) AS total_ingresos,
        COALESCE(SUM(CASE WHEN t.id_tipo_movimiento = 3 THEN t.monto ELSE 0 END), 0) AS total_egresos,
        COALESCE(SUM(CASE WHEN t.id_tipo_movimiento = 4 THEN t.monto ELSE 0 END), 0) AS total_ganancias
        FROM (
            SELECT DATE_ADD(NOW(), INTERVAL 1 - DAYOFWEEK(NOW()) DAY) + INTERVAL (n-1) DAY AS dia_semana
            FROM (
                SELECT 1 AS n UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7
            ) AS numbers
        ) AS calendar
        LEFT JOIN tbl_transacciones_adicionales t
            ON DATE(t.fecha) = DATE(calendar.dia_semana)
            AND t.eliminado = 'N'
        GROUP BY dia
        ORDER BY dia;
        ";
        return $this->EjecutarQuery($query);
    }

    public function ObtenerEstadisticasPorSemanas()
    {
        $query = "SELECT
        calendar.semana,
        COALESCE(SUM(CASE WHEN t.id_tipo_movimiento = 2 THEN t.monto ELSE 0 END), 0) AS total_ingresos,
        COALESCE(SUM(CASE WHEN t.id_tipo_movimiento = 3 THEN t.monto ELSE 0 END), 0) AS total_egresos,
        COALESCE(SUM(CASE WHEN t.id_tipo_movimiento = 4 THEN t.monto ELSE 0 END), 0) AS total_ganancias
        FROM (
            SELECT WEEK(DATE_ADD(DATE_FORMAT(NOW(), '%Y-%m-01'), INTERVAL (n-1) WEEK)) AS semana
            FROM (
                SELECT 1 AS n UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5
            ) AS numbers
        ) AS calendar
        LEFT JOIN tbl_transacciones_adicionales t
            ON WEEK(t.fecha) = calendar.semana
            AND t.eliminado = 'N'
        GROUP BY calendar.semana
        ORDER BY calendar.semana;
        ";
        return $this->EjecutarQuery($query);
    }

    public function ObtenerEgresosAnualesPorSemanas($fechaInicio, $fechaFin)
    {
        $query = "SELECT
        DATE_FORMAT(DATE_ADD(tbl_transacciones_adicionales.fecha, INTERVAL 1 - DAYOFWEEK(tbl_transacciones_adicionales.fecha) DAY), '%Y-%U') AS semana,
        
        COALESCE(SUM(CASE WHEN tbl_transacciones_adicionales.id_tipo_movimiento IN (3, 4) THEN tbl_transacciones_adicionales.monto ELSE 0 END), 0) AS total_egresos,
        COALESCE(SUM(CASE WHEN tbl_transacciones_adicionales.id_tipo_movimiento = 2 THEN tbl_transacciones_adicionales.monto ELSE 0 END), 0) AS total_ingresos,
        MIN(DATE_ADD(tbl_transacciones_adicionales.fecha, INTERVAL 1 - DAYOFWEEK(tbl_transacciones_adicionales.fecha) DAY)) AS fecha_inicial_semana,
        MAX(DATE_ADD(tbl_transacciones_adicionales.fecha, INTERVAL 7 - DAYOFWEEK(tbl_transacciones_adicionales.fecha) DAY)) AS fecha_final_semana
        FROM tbl_transacciones_adicionales
        WHERE DATE(tbl_transacciones_adicionales.fecha) >= '" . $fechaInicio . "' AND DATE(tbl_transacciones_adicionales.fecha) <= '" . $fechaFin . "' AND tbl_transacciones_adicionales.eliminado = 'N'
        GROUP BY semana
        ORDER BY semana;
        ";
        return $this->EjecutarQuery($query);
    }
    public function ObtenerEstadisticasPorFechas($fechaInicio, $fechaFin)
    {
        $query = "SELECT
        tbl_transacciones_adicionales.descripcion, 
        tbl_transacciones_adicionales.fecha, 
        tbl_transacciones_adicionales.monto, 
        tbl_tipos_movimientos.id_tipo_movimiento, 
        tbl_tipos_movimientos.nombre_tipo_movimiento, 
        tbl_transacciones_adicionales.id_transaccion_adicional
    FROM
        tbl_transacciones_adicionales
        INNER JOIN
        tbl_tipos_movimientos
        ON 
            tbl_transacciones_adicionales.id_tipo_movimiento = tbl_tipos_movimientos.id_tipo_movimiento
    WHERE
        tbl_transacciones_adicionales.eliminado = 'N' AND
        tbl_transacciones_adicionales.fecha BETWEEN '" . $fechaInicio . "' AND '" . $fechaFin . "' 
        ORDER BY tbl_transacciones_adicionales.fecha
        ";
        return $this->EjecutarQuery($query);
    }
}
