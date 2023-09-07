<?php
class Reset extends DB
{

    public function FechaInvertir($fecha)
    {
        $fechaOrdenar = explode('-', $fecha);
        $fechaOrdenada = $fechaOrdenar[2] . "-" . $fechaOrdenar[1] . "-" . $fechaOrdenar[0];
        return $fechaOrdenada;
    }

    public function FechaInvertirGuardar($fecha)
    {
        $fechaOrdenar = explode('-', $fecha);
        $fechaOrdenada = $fechaOrdenar[2] . "-" . $fechaOrdenar[1] . "-" . $fechaOrdenar[0];
        return $fechaOrdenada;
    }

    public function FormatoDinero($content)
    {
        setlocale(LC_MONETARY, 'en_US');
        if ($content === '') {
            return "$0.0";
        }
        return "$" . number_format($content, 2);
    }

    public function ReemplazarMes($fecha)
    {
        // Divide la fecha en día, mes y año
        list($dia, $mes, $anio) = explode('-', $fecha);

        // Nombres de los meses en español
        $mesesEnEspanol = array(
            '01' => 'Enero',
            '02' => 'Febrero',
            '03' => 'Marzo',
            '04' => 'Abril',
            '05' => 'Mayo',
            '06' => 'Junio',
            '07' => 'Julio',
            '08' => 'Agosto',
            '09' => 'Septiembre',
            '10' => 'Octubre',
            '11' => 'Noviembre',
            '12' => 'Diciembre'
        );

        // Obtén el nombre del mes en español
        $nombreMes = $mesesEnEspanol[$mes];

        // Reemplaza solo el mes en la cadena original
        $nuevaFecha = "$dia-$nombreMes-$anio";

        return $nuevaFecha;
    }
}
