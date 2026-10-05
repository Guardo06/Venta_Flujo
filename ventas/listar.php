<?php

require_once "../config/conexion.php";

// Obtener todas las ventas
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
    ORDER BY v.id DESC
");

$ventas = $consulta->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Ventas - VentaFlujo</title>

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
            max-width: 1200px;
            margin: 50px auto;
        }

        .card {
            border: none;
            border-radius: 15px;
        }

        .titulo {
            font-weight: bold;
        }

    </style>

</head>

<body>


<!-- NAVBAR -->

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
                href="registrar.php"
                class="btn btn-primary">

                <i class="fa-solid fa-cart-plus"></i>

                Nueva venta

            </a>

        </div>

    </div>

</nav>


<!-- CONTENIDO -->

<div class="container">

    <div class="contenedor">

        <div class="card shadow">

            <div class="card-body p-4">


                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div>

                        <h2 class="titulo mb-1">

                            <i class="fa-solid fa-cart-shopping text-primary"></i>

                            Historial de ventas

                        </h2>

                        <p class="text-muted mb-0">

                            Consulte las ventas registradas en VentaFlujo.

                        </p>

                    </div>


                    <a
                        href="registrar.php"
                        class="btn btn-primary">

                        <i class="fa-solid fa-plus"></i>

                        Nueva venta

                    </a>

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

                                            <?php echo $venta["id"]; ?>

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

                        Todavía no hay ventas registradas.

                    </div>


                <?php endif; ?>


            </div>

        </div>

    </div>

</div>


</body>

</html>