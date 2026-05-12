<?php
//Cambio de moneda segun select
if (isset($_GET['moneda'])) {
    $moneda = $_GET['moneda'];
} else {
    $moneda = "dolar"; 
}
$cotizacion = 1500;

require_once "includes/funciones.php";
require_once "datos/productos.php";

$cantVentaWeb   = 0;   // Contador de productos para venta web
$totalMonetario = 0;   // Total

$filas = [];
foreach ($productos as $num => $prod) {

    $diferencia  = calcularDiferencia($prod["stockActual"], $prod["stockMin"]);
    $color       = obtenerColor($diferencia);
    $monetario   = calcularMonetario($prod["stockActual"], $prod["precio"], $moneda, $cotizacion);

    // Acumuladores
    if ($diferencia > 10) {
        $cantVentaWeb++;
    }
    $totalMonetario += $monetario;

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

    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
          rel="stylesheet">

    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

<?php require_once "includes/encabezado.php"; ?>

<?php require_once "includes/lateral.php"; ?>

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
        </div>

        <section class="section dashboard">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">

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
                        </div>
                        <?php require_once "includes/fichas_inferiores.php"; ?>

                    </div>
                </div>
            </div>
        </section>

    </main>

<?php require_once "includes/pie.php"; ?>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>

    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="assets/js/main.js"></script>

</body>
</html>
