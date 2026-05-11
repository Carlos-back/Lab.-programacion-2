<?php
// ============================================================
// includes/header.php
// Sección del encabezado (<header>) de la página
// Recibe: $moneda (para mostrar bandera e ícono correcto)
// ============================================================

// Configuración visual según moneda activa
if ($moneda === "peso" || $moneda === "pesos") {
    $bandera      = "assets/img/ar.png";
    $textoMoneda  = "PESOS";
} else {
    $bandera      = "assets/img/en.jpg";
    $textoMoneda  = "DÓLARES";
}
?>

<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/"
           target="_blank"
           class="logo d-flex align-items-center"
           title="Puedes descargar la template original desde aquí">
            <img src="assets/img/logo.png" alt="2025">
            <span class="d-none d-lg-block">NiceAdmin</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            <li class="nav-item dropdown pe-3">
                <a class="nav-link nav-profile d-flex align-items-center pe-0"
                   href="#" data-bs-toggle="dropdown">
                    <img src="<?php echo $bandera; ?>" alt="moneda" class="rounded-circle">
                    <span class="d-none d-md-block dropdown-toggle ps-2">
                        <?php echo $textoMoneda; ?>
                    </span>
                </a>
                <!-- Nota: el cambio de moneda se hace modificando $moneda en listado.php -->
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="listado.php?moneda=dolar">
                            <i class="bi bi-currency-dollar"></i>
                            <span>Dólar Estadounidense</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="listado.php?moneda=peso">
                            <i class="bi bi-currency-dollar"></i>
                            <span>Peso Argentino</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav><!-- End Currency -->

</header><!-- End Header -->
