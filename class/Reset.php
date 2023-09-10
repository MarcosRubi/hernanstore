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
        $media = ($valorPrestamo + $ganancia) / $numeroCuotas;

        return number_format($media, 2);
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


    public function DetallesMontoCuotasMensuales($valorPrestamo, $numeroCuotas, $porcentajeInteres, $fechaPrimerPago, $plazoDePagos)
    {
        $diasEntrePlazos = $this->PlazoEntrePagos(5); // 5 representa el plazo de 30 días
        $fechasCuotas = $this->GenerarFechasCuotas($fechaPrimerPago, $numeroCuotas, $diasEntrePlazos);
        $saldoRestante = $valorPrestamo;

        for ($i = 0; $i < $numeroCuotas; $i++) {
            $interes = ($saldoRestante * $porcentajeInteres) / 100;
            $valorBase = $saldoRestante / ($numeroCuotas - $i);
            $montoCuota = $valorBase + $interes;

            // Aquí puedes realizar la acción necesaria con el interés, por ejemplo, guardar en una base de datos o hacer algún cálculo.
            // $interes contiene el interés de esta cuota, $saldoRestante contiene el saldo restante después de pagar la cuota.

            echo "Fecha: {$fechasCuotas[$i]}, Cuota: {$this->FormatoDinero($montoCuota)}, Interés: {$this->FormatoDinero($interes)}, Saldo Restante: {$this->FormatoDinero($saldoRestante)}<br>";

            // Verificar si han pasado 30 días (un mes) y ajustar las fechas de las cuotas restantes.
            if (($i + 1) % 2 == 0 && $i < $numeroCuotas - 1) {
                $diasEntrePlazos = 30; // 30 días representan un mes
                $fechaUltimaCuota = end($fechasCuotas);
                $fechaNueva = date('Y-m-d', strtotime("+$diasEntrePlazos days", strtotime($fechaUltimaCuota)));
                $fechasCuotas[] = $fechaNueva;
            }

            // Restar la cuota del saldo restante
            $saldoRestante -= $valorBase;
        }
    }
    function calcularMontoCuotasMensuales($valorPrestamo, $numeroCuotas, $porcentajeInteres)
    {
        $montoCuotas = [];

        // Calcula el valor base para cada cuota (igualmente dividido)
        $valorBase = $valorPrestamo / $numeroCuotas;

        // Inicializa el saldo restante
        $saldoRestante = $valorPrestamo;

        // Calcula el monto de cada cuota y almacénalo en un arreglo
        for ($i = 1; $i <= $numeroCuotas; $i++) {
            // Calcula el interés para esta cuota
            $interes = ($saldoRestante * $porcentajeInteres) / 100;

            // Calcula el monto de la cuota
            $montoCuota = $valorBase + $interes;

            // Agrega el monto de la cuota al arreglo
            $montoCuotas[] = $montoCuota;

            // Actualiza el saldo restante restando el valor base
            $saldoRestante -= $valorBase;
        }

        // Calcula la media de las cuotas
        $media = array_sum($montoCuotas) / $numeroCuotas;

        return number_format($media, 2);
    }


    public function DetallesMontoCuotasSemanales($valorPrestamo, $numeroCuotas, $porcentajeInteres, $fechaPrimerPago, $plazoDePagos)
    {
        $diasEntrePlazos = $this->PlazoEntrePagos(5); // 5 representa el plazo de 30 días
        $fechasCuotas = $this->GenerarFechasCuotas($fechaPrimerPago, $numeroCuotas, $diasEntrePlazos);
        $saldoRestante = $valorPrestamo;
        $resultados = array();

        for ($i = 0; $i < $numeroCuotas; $i++) {
            $interes = ($saldoRestante * $porcentajeInteres) / 100;
            $valorBase = $saldoRestante / ($numeroCuotas - $i);
            $montoCuota = $valorBase + $interes;

            // Formatea la fecha, monto de cuota, interés y saldo restante
            $fechaCuota = $fechasCuotas[$i];
            $montoCuotaFormateado = $this->FormatoDinero($montoCuota);
            $interesFormateado = $this->FormatoDinero($interes);
            $saldoRestanteFormateado = $this->FormatoDinero($saldoRestante);

            // Agrega los resultados al array de resultados
            $resultados[] = "Fecha: $fechaCuota, Cuota: $montoCuotaFormateado, Interés: $interesFormateado, Saldo Restante: $saldoRestanteFormateado";

            // Verifica si han pasado 30 días (un mes) y ajusta las fechas de las cuotas restantes.
            if (($i + 1) % 4 == 0 && $i < $numeroCuotas - 1) {
                $diasEntrePlazos = 30; // 30 días representan un mes
                $fechaUltimaCuota = end($fechasCuotas);
                $fechaNueva = date('Y-m-d', strtotime("+$diasEntrePlazos days", strtotime($fechaUltimaCuota)));
                $fechasCuotas[] = $fechaNueva;
            }

            // Resta la cuota del saldo restante
            $saldoRestante -= $valorBase;
        }

        // Devuelve los resultados como un array de strings
        return $resultados;
    }

    function calcularMontoCuotasSemanales($valorPrestamo, $numeroCuotas, $porcentajeInteres)
    {
        $montoCuotas = [];

        // Inicializa el saldo restante
        $saldoRestante = $valorPrestamo;

        // Calcula el monto de cada cuota y almacénalo en un arreglo
        for ($i = 1; $i <= $numeroCuotas; $i++) {
            // Calcula el interés para esta cuota
            $interes = ($saldoRestante * $porcentajeInteres) / 100;

            // Calcula el valor base para cada cuota (igualmente dividido)
            $valorBase = $saldoRestante / $numeroCuotas;

            // Calcula el monto de la cuota
            $montoCuota = $valorBase + $interes;

            // Agrega el monto de la cuota al arreglo
            $montoCuotas[] = $montoCuota;

            // Actualiza el saldo restante restando el valor base
            $saldoRestante -= $valorBase;

            // Verifica si han pasado 4 bucles y recalcula el interés sobre el saldo restante
            if ($i % 4 == 0 && $i < $numeroCuotas) {
                $interes = ($saldoRestante * $porcentajeInteres) / 100;
            }
        }

        // Calcula la media de las cuotas
        $media = array_sum($montoCuotas) / $numeroCuotas;

        return number_format($media, 2);
    }
}
