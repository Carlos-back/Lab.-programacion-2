<?php
// ============================================================
// listado.php  —  Script principal
// ============================================================

// ------------------------------------------------------------
// 1. CONFIGURACIÓN DE MONEDA
//    Cambiar el valor de $moneda para alternar entre vistas:
//      "dolar"  →  muestra precios en dólares (U$S)
//      "peso"   →  muestra precios en pesos argentinos ($)
// ------------------------------------------------------------
$moneda     = "dolar";   // <-- cambiá aquí: "dolar" o "peso"
$cotizacion = 1500;      // Cotización estimativa dólar → peso

// ------------------------------------------------------------
// 2. INCLUIR ARCHIVOS EXTERNOS
//    require_once detiene la ejecución si el archivo no existe
// ------------------------------------------------------------
require_once "includes/funciones.php";
require_once "datos/productos.php";

// ------------------------------------------------------------
// 3. PROCESAMIENTO: recorrer el array y acumular totales
//    (se hace aquí para tener los acumuladores listos antes
//     de incluir el HTML de las fichas inferiores)
// ------------------------------------------------------------
$cantVentaWeb   = 0;   // Contador de productos disponibles para venta web
$totalMonetario = 0;   // Sumatoria del monetario en stock de todos los productos

// Pre-calculamos los datos de cada producto para usarlos
// tanto en la tabla como en las fichas inferiores
$filas = [];
foreach ($productos as $num => $prod) {

    $diferencia  = calcularDiferencia($prod["stockActual"], $prod["stockMin"]);
    $color       = obtenerColor($diferencia);
    $monetario   = calcularMonetario($prod["stockActual"], $prod["precio"], $moneda, $cotizacion);

    // Acumuladores (proceso optimizado: se calculan en el mismo recorrido)
    if ($diferencia > 10) {
        $cantVentaWeb++;
    }
    $totalMonetario += $monetario;

    // Guardamos los datos procesados para el renderizado
    $filas[] = [
        "num"        => $num + 1,
        "prod"       => $prod,
        "diferencia" => $diferencia,
        "color"      => $color,
        "monetario"  => $monetario
    ];
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>1er Desempeño</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
          rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

<?php require_once "includes/header.php"; ?>

<?php require_once "includes/sidebar.php"; ?>

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Listado de Productos</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="#">Productos</a></li>
                    <li class="breadcrumb-item active">Los mas vendidos</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">

                        <!-- ===== TABLA DE PRODUCTOS ===== -->
                        <div class="col-12">
                            <div class="card top-selling overflow-auto">
                                <div class="card-body pb-0">
                                    <h5 class="card-title">Los mas vendidos</h5>

                                    <table class="table table-borderless">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Imagen</th>
                                                <th scope="col">Descripción</th>
                                                <th scope="col">Stock Min.</th>
                                                <th scope="col" title="Stock Actual - Stock Min.">Diferencia Stock</th>
                                                <th scope="col">Precio Unit.</th>
                                                <th scope="col">Venta Web</th>
                                                <th scope="col">Monetario en stock</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php foreach ($filas as $fila) :
                                            $num        = $fila["num"];
                                            $prod       = $fila["prod"];
                                            $diferencia = $fila["diferencia"];
                                            $color      = $fila["color"];
                                            $monetario  = $fila["monetario"];
                                        ?>
                                            <tr>

                                                <!-- # Número de fila -->
                                                <th scope="row"><?php echo $num; ?></th>

                                                <!-- Imagen con tooltip del código -->
                                                <th scope="row">
                                                    <a href="#">
                                                        <img src="<?php echo $prod["imagen"]; ?>"
                                                             title="#<?php echo $prod["codigo"]; ?>">
                                                    </a>
                                                </th>

                                                <!-- Descripción + barra de stock actual -->
                                                <td>
                                                    <a href="#" class="text-primary fw-bold">
                                                        <?php echo $prod["descripcion"]; ?>
                                                    </a>
                                                    <div class="progress mt-3">
                                                        <div class="progress-bar progress-bar-striped bg-<?php echo $color; ?> progress-bar-animated"
                                                             role="progressbar"
                                                             style="width: <?php echo $prod["stockActual"]; ?>%"
                                                             title="Stock Actual <?php echo $prod["stockActual"]; ?>">
                                                        </div>
                                                    </div>
                                                </td>

                                                <!-- Stock Mínimo -->
                                                <td>
                                                    <h4>
                                                        <span class="badge border-info border-1 text-info">
                                                            <?php echo $prod["stockMin"]; ?>
                                                        </span>
                                                    </h4>
                                                </td>

                                                <!-- Diferencia de Stock (con tooltip mostrando el cálculo) -->
                                                <td>
                                                    <h4>
                                                        <span class="badge border-info border-1 text-info"
                                                              title="<?php echo $prod["stockActual"]; ?> - <?php echo $prod["stockMin"]; ?>">
                                                            <?php echo $diferencia; ?>
                                                        </span>
                                                    </h4>
                                                </td>

                                                <!-- Precio Unitario (con color según condición) -->
                                                <td>
                                                    <h4>
                                                        <span class="badge border-<?php echo $color; ?> border-1 text-<?php echo $color; ?>">
                                                            <?php echo mostrarPrecio($prod["precio"], $moneda, $cotizacion); ?>
                                                        </span>
                                                    </h4>
                                                </td>

                                                <!-- Ícono de Venta Web (con color y tooltip) -->
                                                <td>
                                                    <?php echo mostrarIconoVenta($diferencia, $color); ?>
                                                </td>

                                                <!-- Monetario en Stock -->
                                                <td>
                                                    <h4>
                                                        <span class="badge border-info border-1 text-info">
                                                            <?php echo mostrarSimboloMoneda($moneda) . " " . formatearMonto($monetario, $moneda); ?>
                                                        </span>
                                                    </h4>
                                                </td>

                                            </tr>
                                        <?php endforeach; ?>

                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div><!-- End Top Selling -->

                        <!-- ===== FICHAS INFERIORES ===== -->
                        <?php require_once "includes/fichas.php"; ?>

                    </div>
                </div>
            </div>
        </section>

    </main><!-- End #main -->

<?php require_once "includes/footer.php"; ?>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

</body>
</html>
