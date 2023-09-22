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

        $valor = floatval(str_replace(',', '', $content));
        return "$" . number_format($valor, 2);
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
    function PlazoEntrePagos($id_plazo)
    {
        $plazoDePagos = array(
            2 => 1,
            3 => 7,
            4 => 15,
            5 => 30,
            6 => 90,
            7 => 180,
            8 => 365,
        );

        if (isset($plazoDePagos[$id_plazo])) {
            return $plazoDePagos[$id_plazo];
        } else {
            // Valor predeterminado si no se encuentra en el diccionario
            return null;
        }
    }

    function CalcularMontoCuotas($valorPrestamo, $numeroCuotas, $porcentajeInteres)
    {

        $ganancia = ($valorPrestamo * $porcentajeInteres) / 100;
        $valorCuotaRestante[] = $valorPrestamo;
        $valorBase = $valorPrestamo / $numeroCuotas;

        $saldoRestante = $valorPrestamo;


        // Calcula el monto de cada cuota y almacénalo en arreglos numéricos
        for ($i = 1; $i <= $numeroCuotas; $i++) {
            $saldoRestante -= $valorBase;
            $valorCuotaRestante[] = number_format($saldoRestante, 2);
        }

        return array('valor' => $valorCuotaRestante, 'interes' => $ganancia);
    }
    function calcularMontoCuotasConInteresMensual($valorPrestamo, $numeroCuotas, $porcentajeInteres, $cuotasElegidas, $valorCuotasRestantes = 0)
    {
        $interes = [];
        $saldo = [$valorPrestamo];

        // Calcula el valor base para cada cuota (igualmente dividido)
        $valorBase = $valorPrestamo / $numeroCuotas;

        // Inicializa el saldo restante
        $saldoRestante = $valorPrestamo + $valorCuotasRestantes;

        // Calcula el monto de cada cuota y almacénalo en arreglos numéricos
        for ($i = 1; $i <= $numeroCuotas; $i++) {
            if (in_array($i, $cuotasElegidas)) {
                $interes[] = number_format(($saldoRestante * $porcentajeInteres) / 100, 2);
            } else {
                $interes[] = number_format(0, 2);
            }
            $saldoRestante -= $valorBase;
            $saldo[] = number_format($saldoRestante, 2);
        }

        return array('interes' => $interes, 'valor' => $saldo);
    }
    function calcularInteresMensual($valorPrestamo, $numeroCuotas, $porcentajeInteres, $cuotasElegidas)
    {
        $interes = [];

        // Calcula el valor base para cada cuota (igualmente dividido)
        $valorBase = $valorPrestamo / $numeroCuotas;

        // Inicializa el saldo restante
        $saldoRestante = $valorPrestamo;

        // Calcula el monto de cada cuota y almacénalo en un arreglo
        for ($i = 1; $i <= $numeroCuotas; $i++) {
            if (in_array($i, $cuotasElegidas)) {
                $interes[] = ($saldoRestante * $porcentajeInteres) / 100;
            }
            $saldoRestante -= $valorBase;
        }

        return number_format(array_sum($interes), 2);
    }
    function GenerarFechasCuotas($fechaPrimerPago, $numeroCuotas, $diasEntrePlazos)
    {
        $fechasCuotas = array();
        $fechaActual = strtotime($fechaPrimerPago); // Convierte la fecha inicial a un timestamp

        // Agrega la fecha inicial al array de fechas
        $fechasCuotas[] = date('Y-m-d', $fechaActual);

        // Genera las fechas para las cuotas restantes
        for ($i = 1; $i < $numeroCuotas; $i++) {
            // Aumenta la fecha actual en el número de días entre plazos
            $fechaActual = strtotime("+$diasEntrePlazos days", $fechaActual);

            // Si la fecha resultante es un domingo, suma un día adicional
            if (date('w', $fechaActual) == 0) {
                $fechaActual = strtotime('+1 day', $fechaActual);
            }

            // Agrega la fecha al array de fechas
            $fechasCuotas[] = date('Y-m-d', $fechaActual);
        }

        return $fechasCuotas;
    }
}
