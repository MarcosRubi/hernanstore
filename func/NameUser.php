<?php
function procesarCadena($cadena)
{
    $elementos = explode(' ', $cadena);

    if (strlen($elementos[0]) < 20) {
        $resultado = $elementos[0];
        if (isset($elementos[1]) && strlen($resultado . ' ' . $elementos[1]) < 20) {
            $resultado .= ' ' . $elementos[1];
            if (isset($elementos[2]) && strlen($resultado . ' ' . $elementos[2]) <= 20) {
                $resultado .= ' ' . $elementos[2];
            }
        }
    } else {
        $resultado = implode(' ', $elementos);
    }

    return $resultado;
}
