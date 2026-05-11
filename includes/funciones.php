<?php
// ============================================================
// includes/funciones.php
// Funciones propias del proyecto
// ============================================================


// ------------------------------------------------------------
// calcularDiferencia()
// Calcula la diferencia entre Stock Actual y Stock Mínimo
// Retorna: número entero (puede ser negativo)
// ------------------------------------------------------------
function calcularDiferencia($stockActual, $stockMin) {
    return $stockActual - $stockMin;
}


// ------------------------------------------------------------
// obtenerColor()
// Devuelve la clase de Bootstrap según la diferencia de stock
//   <= 10       → "danger"  (rojo)
//   > 10 y < 30 → "warning" (amarillo)
//   >= 30       → "success" (verde)
// ------------------------------------------------------------
function obtenerColor($diferencia) {
    if ($diferencia <= 10) {
        return "danger";
    } elseif ($diferencia < 30) {
        return "warning";
    } else {
        return "success";
    }
}


// ------------------------------------------------------------
// mostrarIconoVenta()
// Devuelve el HTML del ícono de carrito según disponibilidad
//   diferencia <= 10  → carrito con X (no disponible)
//   diferencia > 10   → carrito normal (disponible)
// ------------------------------------------------------------
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


// ------------------------------------------------------------
// calcularMonetario()
// Calcula el valor monetario en stock (Stock Actual × Precio)
// Si la moneda es "peso", multiplica además por la cotización
// Retorna: número float
// ------------------------------------------------------------
function calcularMonetario($stockActual, $precio, $moneda, $cotizacion) {
    $total = $stockActual * $precio;
    if ($moneda === "peso" || $moneda === "pesos") {
        $total = $total * $cotizacion;
    }
    return $total;
}


// ------------------------------------------------------------
// mostrarPrecio()
// Formatea y devuelve el precio con el símbolo de moneda
// Si la moneda es "peso", multiplica por la cotización
// Retorna: string formateado  ej: "U$S 6.99"  o  "$ 10485"
// ------------------------------------------------------------
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


// ------------------------------------------------------------
// mostrarSimboloMoneda()
// Devuelve solo el símbolo según la moneda activa
// ------------------------------------------------------------
function mostrarSimboloMoneda($moneda) {
    return ($moneda === "peso" || $moneda === "pesos") ? "$" : "U\$S";
}


// ------------------------------------------------------------
// formatearMonto()
// Formatea un número según la moneda (con o sin decimales)
// ------------------------------------------------------------
function formatearMonto($monto, $moneda) {
    if ($moneda === "peso" || $moneda === "pesos") {
        return number_format($monto, 0, ",", ".");
    } else {
        return number_format($monto, 1, ".", "");
    }
}
