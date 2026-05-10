<?php
// ============================================================
// includes/fichas.php
// Sección de las fichas/tarjetas inferiores
// Recibe: $cantVentaWeb, $totalMonetario, $moneda
// ============================================================
?>

<!-- Ficha: Cantidad de productos para venta web -->
<div class="col-xxl-4 col-md-6">
    <div class="card info-card revenue-card">
        <div class="card-body">
            <h5 class="card-title">
                PRODUCTOS <span>| Cantidad para la venta web</span>
            </h5>
            <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-patch-check-fill"></i>
                </div>
                <div class="ps-3">
                    <h6><?php echo $cantVentaWeb; ?></h6>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ficha: Total monetario en stock -->
<div class="col-xxl-4 col-md-6">
    <div class="card info-card revenue-card">
        <div class="card-body">
            <h5 class="card-title">
                Total <span>| Monetario en Stock</span>
            </h5>
            <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-currency-dollar"></i>
                </div>
                <div class="ps-3">
                    <h6>
                        <?php echo mostrarSimboloMoneda($moneda) . " " . formatearMonto($totalMonetario, $moneda); ?>
                    </h6>
                </div>
            </div>
        </div>
    </div>
</div>
