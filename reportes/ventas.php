<?php

require_once "../config/conexion.php";

// ===============================
// RESUMEN DE VENTAS
// ===============================

// Cantidad de ventas
$consulta = $conexion->query("
    SELECT COUNT(*) 
    FROM ventas
");

$totalVentas = $consulta->fetchColumn();


// Total de unidades vendidas
$consulta = $conexion->query("
    SELECT COALESCE(SUM(cantidad), 0)
    FROM ventas
");

$totalUnidades = $consulta->fetchColumn();


// Total de ingresos
$consulta = $conexion->query("
    SELECT COALESCE(SUM(total), 0)
    FROM ventas
");

$totalIngresos = $consulta->fetchColumn();


// Venta promedio
$consulta = $conexion->query("
    SELECT COALESCE(AVG(total), 0)
    FROM ventas
");

$ventaPromedio = $consulta->fetchColumn();


// ===============================
// LISTADO DE VENTAS
// ===============================

$consulta = $conexion->query("
    SELECT
        v.id,
        v.fecha_venta,
        p.nombre AS producto,
        v.cantidad,
        v.precio_unitario,
        v.total
    FROM ventas v
    INNER JOIN productos p
        ON v.producto_id = p.id
    ORDER BY v.fecha_venta DESC
");

$ventas = $consulta->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Reporte de ventas - VentaFlujo</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>

        body {
            background-color: #f5f7fb;
        }

        .contenedor {
            max-width: 1250px;
            margin: 40px auto;
        }

        .card {
            border: none;
            border-radius: 15px;
        }

        .titulo {
            font-weight: bold;
        }

        .numero {
            font-size: 28px;
            font-weight: bold;
        }

        .icono {
            font-size: 28px;
        }

    </style>

</head>

<body>


<!-- =============================== -->
<!-- NAVBAR -->
<!-- =============================== -->

<nav class="navbar navbar-dark bg-dark">

    <div class="container-fluid px-4">

        <a
            class="navbar-brand fw-bold"
            href="../dashboard.php">

            <i class="fa-solid fa-store"></i>

            VentaFlujo

        </a>


        <div>

            <a
                href="../dashboard.php"
                class="btn btn-outline-light me-2">

                <i class="fa-solid fa-house"></i>

                Dashboard

            </a>


            <a
                href="../ventas/registrar.php"
                class="btn btn-primary">

                <i class="fa-solid fa-cart-plus"></i>

                Nueva venta

            </a>

        </div>

    </div>

</nav>


<!-- =============================== -->
<!-- CONTENIDO -->
<!-- =============================== -->

<div class="container">

    <div class="contenedor">


        <!-- TITULO -->

        <div class="mb-4">

            <h1 class="titulo">

                <i class="fa-solid fa-chart-column text-primary"></i>

                Reporte de ventas

            </h1>

            <p class="text-muted">

                Resumen de las ventas registradas en VentaFlujo.

            </p>

        </div>


        <!-- =============================== -->
        <!-- TARJETAS DE RESUMEN -->
        <!-- =============================== -->

        <div class="row g-4 mb-4">


            <!-- VENTAS -->

            <div class="col-md-3">

                <div class="card shadow-sm h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <p class="text-muted mb-1">
                                    Ventas realizadas
                                </p>

                                <div class="numero">

                                    <?php echo $totalVentas; ?>

                                </div>

                            </div>


                            <div class="icono text-primary">

                                <i class="fa-solid fa-cart-shopping"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <!-- UNIDADES -->

            <div class="col-md-3">

                <div class="card shadow-sm h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <p class="text-muted mb-1">
                                    Unidades vendidas
                                </p>

                                <div class="numero">

                                    <?php echo $totalUnidades; ?>

                                </div>

                            </div>


                            <div class="icono text-primary">

                                <i class="fa-solid fa-box"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <!-- INGRESOS -->

            <div class="col-md-3">

                <div class="card shadow-sm h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <p class="text-muted mb-1">
                                    Ingresos totales
                                </p>

                                <div class="numero">

                                    $
                                    <?php
                                    echo number_format(
                                        $totalIngresos,
                                        0,
                                        ",",
                                        "."
                                    );
                                    ?>

                                </div>

                            </div>


                            <div class="icono text-success">

                                <i class="fa-solid fa-dollar-sign"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <!-- PROMEDIO -->

            <div class="col-md-3">

                <div class="card shadow-sm h-100">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div>

                                <p class="text-muted mb-1">
                                    Venta promedio
                                </p>

                                <div class="numero">

                                    $
                                    <?php
                                    echo number_format(
                                        $ventaPromedio,
                                        0,
                                        ",",
                                        "."
                                    );
                                    ?>

                                </div>

                            </div>


                            <div class="icono text-primary">

                                <i class="fa-solid fa-chart-line"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- =============================== -->
        <!-- TABLA -->
        <!-- =============================== -->

        <div class="card shadow">

            <div class="card-body p-4">


                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div>

                        <h3 class="mb-1">

                            <i class="fa-solid fa-table-list text-primary"></i>

                            Detalle de ventas

                        </h3>

                        <p class="text-muted mb-0">

                            Historial de las ventas realizadas.

                        </p>

                    </div>


                    <button
                        onclick="window.print()"
                        class="btn btn-secondary">

                        <i class="fa-solid fa-print"></i>

                        Imprimir reporte

                    </button>

                </div>


                <?php if (count($ventas) > 0): ?>


                    <div class="table-responsive">

                        <table class="table table-hover align-middle">

                            <thead class="table-dark">

                                <tr>

                                    <th>ID</th>

                                    <th>Fecha</th>

                                    <th>Producto</th>

                                    <th>Cantidad</th>

                                    <th>Precio unitario</th>

                                    <th>Total</th>

                                </tr>

                            </thead>


                            <tbody>

                                <?php foreach ($ventas as $venta): ?>

                                    <tr>

                                        <td>

                                            <?php
                                            echo $venta["id"];
                                            ?>

                                        </td>


                                        <td>

                                            <?php
                                            echo date(
                                                "d/m/Y H:i",
                                                strtotime(
                                                    $venta["fecha_venta"]
                                                )
                                            );
                                            ?>

                                        </td>


                                        <td>

                                            <?php
                                            echo htmlspecialchars(
                                                $venta["producto"]
                                            );
                                            ?>

                                        </td>


                                        <td>

                                            <span class="badge bg-primary">

                                                <?php
                                                echo $venta["cantidad"];
                                                ?>

                                            </span>

                                        </td>


                                        <td>

                                            $
                                            <?php
                                            echo number_format(
                                                $venta["precio_unitario"],
                                                0,
                                                ",",
                                                "."
                                            );
                                            ?>

                                        </td>


                                        <td class="fw-bold">

                                            $
                                            <?php
                                            echo number_format(
                                                $venta["total"],
                                                0,
                                                ",",
                                                "."
                                            );
                                            ?>

                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            </tbody>

                        </table>

                    </div>


                <?php else: ?>


                    <div class="alert alert-info text-center">

                        <i class="fa-solid fa-circle-info"></i>

                        No hay ventas registradas todavía.

                    </div>


                <?php endif; ?>


            </div>

        </div>


    </div>

</div>


</body>

</html>