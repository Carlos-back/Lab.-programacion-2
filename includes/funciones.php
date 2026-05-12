<?php
// Calcula la diferencia entre stock actual y stock minimo

function calcularDiferencia($stockActual, $stockMin) {
    return $stockActual - $stockMin;
}


// Devuelve la clase de bootstrap segun la dif de stock
function obtenerColor($diferencia) {
    if ($diferencia <= 10) {
        return "danger";
    } elseif ($diferencia < 30) {
        return "warning";
    } else {
        return "success";
    }
}



// Devuelve el HTML del ícono de carrito según disponibilidad
function mostrarIconoVenta($diferencia, $color) {
    if ($diferencia <= 10) {
        $icono   = "bi-cart-x-fill";
        $tooltip = "No se permite venta web";
    } else {
        $icono   = "bi-cart4";
        $tooltip = "Se permite venta web";
    }

    return '<h3>
                <span class="badge border-' . $color . ' border-1 text-' . $color . '" title="' . $tooltip . '">
                    <i class="bi ' . $icono . '"></i>
                </span>
            </h3>';
}


// calcular el valor monetario del stock
function calcularMonetario($stockActual, $precio, $moneda, $cotizacion) {
    $total = $stockActual * $precio;
    if ($moneda === "peso" || $moneda === "pesos") {
        $total = $total * $cotizacion;
    }
    return $total;
}

// muestra el precio segun la moneda
function mostrarPrecio($precio, $moneda, $cotizacion) {
    if ($moneda === "peso" || $moneda === "pesos") {
        $simbolo = "$";
        $valor   = $precio * $cotizacion;
        // Sin decimales para pesos
        return $simbolo . " " . number_format($valor, 0, ",", ".");
    } else {
        $simbolo = "U\$S";
        return $simbolo . " " . number_format($precio, 2, ".", "");
    }
}


// devuelve el simbolo de la moneda
function mostrarSimboloMoneda($moneda) {
    return ($moneda === "peso") ? "$" : "U\$S";
}


// Formatea un numero segun la moneda (con o sin decimales)
function formatearMonto($monto, $moneda) {
    if ($moneda === "peso") {
        return number_format($monto, 0, ",", ".");
    } else {
        return number_format($monto, 1, ".", "");
    }
}
