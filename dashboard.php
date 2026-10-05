<?php

require_once "config/conexion.php";

/*
|--------------------------------------------------------------------------
| Estadísticas del sistema
|--------------------------------------------------------------------------
*/

// Total de productos
$consultaProductos = $conexion->query(
    "SELECT COUNT(*) FROM productos"
);

$totalProductos = $consultaProductos->fetchColumn();


// Stock total
$consultaStock = $conexion->query(
    "SELECT COALESCE(SUM(stock), 0) FROM productos"
);

$totalStock = $consultaStock->fetchColumn();


// Total de ventas
$consultaVentas = $conexion->query(
    "SELECT COUNT(*) FROM ventas"
);

$totalVentas = $consultaVentas->fetchColumn();


// Ingresos totales
$consultaIngresos = $conexion->query(
    "SELECT COALESCE(SUM(total), 0) FROM ventas"
);

$totalIngresos = $consultaIngresos->fetchColumn();


// Productos con bajo stock
$consultaBajoStock = $conexion->query(
    "SELECT COUNT(*) 
     FROM productos 
     WHERE stock <= 5"
);

$productosBajoStock = $consultaBajoStock->fetchColumn();

?>

<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Dashboard - VentaFlujo</title>


    <!-- Bootstrap -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">


    <!-- Iconos -->

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">


    <style>

        body {
            background-color: #f5f7fb;
            font-family: Arial, sans-serif;
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 24px;
        }

        .dashboard-title {
            font-weight: bold;
        }

        .card-estadistica {
            border: none;
            border-radius: 15px;
            transition: 0.2s;
        }

        .card-estadistica:hover {
            transform: translateY(-3px);
        }

        .icono {
            width: 55px;
            height: 55px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            background-color: #e9f2ff;
            color: #0d6efd;
        }

        .numero {
            font-size: 28px;
            font-weight: bold;
        }

        .acceso {
            text-decoration: none;
        }

        .acceso .card {
            transition: 0.2s;
        }

        .acceso .card:hover {
            transform: translateY(-3px);
        }

        footer {
            margin-top: 50px;
        }

    </style>

</head>


<body>


<!-- NAVBAR -->

<nav class="navbar navbar-dark bg-dark">

    <div class="container-fluid px-4">

        <a class="navbar-brand" href="dashboard.php">

            <i class="fa-solid fa-store"></i>

            VentaFlujo

        </a>


        <div class="d-flex">

            <a
                href="dashboard.php"
                class="btn btn-outline-light me-2">

                <i class="fa-solid fa-house"></i>

                Dashboard

            </a>


            <a
                href="productos/listar.php"
                class="btn btn-outline-light me-2">

                <i class="fa-solid fa-box"></i>

                Productos

            </a>


            <a
                href="ventas/listar.php"
                class="btn btn-outline-light">

                <i class="fa-solid fa-cart-shopping"></i>

                Ventas

            <a href="logout.php" class="btn btn-outline-light">
                <i class="fa-solid fa.right-from-bracket"></i>
                
                Cerrar sesion
                
            </a>

            </a>

        </div>

    </div>

</nav>


<!-- CONTENIDO -->

<div class="container py-5">


    <div class="mb-4">

        <h1 class="dashboard-title">

            Dashboard

        </h1>

        <p class="text-muted">

            Resumen general del sistema VentaFlujo

        </p>

    </div>


    <!-- ESTADÍSTICAS -->

    <div class="row g-4 mb-4">


        <!-- PRODUCTOS -->

        <div class="col-md-6 col-lg-3">

            <div class="card card-estadistica shadow-sm">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <p class="text-muted mb-1">
                                Productos
                            </p>

                            <div class="numero">

                                <?php echo $totalProductos; ?>

                            </div>

                        </div>


                        <div class="icono">

                            <i class="fa-solid fa-box"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- STOCK -->

        <div class="col-md-6 col-lg-3">

            <div class="card card-estadistica shadow-sm">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <p class="text-muted mb-1">
                                Stock disponible
                            </p>

                            <div class="numero">

                                <?php echo $totalStock; ?>

                            </div>

                        </div>


                        <div class="icono">

                            <i class="fa-solid fa-warehouse"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- VENTAS -->

        <div class="col-md-6 col-lg-3">

            <div class="card card-estadistica shadow-sm">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <p class="text-muted mb-1">
                                Ventas
                            </p>

                            <div class="numero">

                                <?php echo $totalVentas; ?>

                            </div>

                        </div>


                        <div class="icono">

                            <i class="fa-solid fa-cart-shopping"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- INGRESOS -->

        <div class="col-md-6 col-lg-3">

            <div class="card card-estadistica shadow-sm">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <p class="text-muted mb-1">
                                Ingresos
                            </p>

                            <div class="numero">

                                $<?php echo number_format($totalIngresos, 0, ',', '.'); ?>

                            </div>

                        </div>


                        <div class="icono">

                            <i class="fa-solid fa-dollar-sign"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


    </div>


    <!-- SEGUNDA SECCIÓN -->

    <div class="row g-4">


        <!-- INVENTARIO -->

        <div class="col-lg-6">

            <div class="card shadow-sm border-0">

                <div class="card-body p-4">

                    <h4 class="mb-3">

                        <i class="fa-solid fa-boxes-stacked text-primary"></i>

                        Estado del inventario

                    </h4>


                    <hr>


                    <div class="d-flex justify-content-between mb-3">

                        <span>
                            Productos registrados
                        </span>

                        <strong>
                            <?php echo $totalProductos; ?>
                        </strong>

                    </div>


                    <div class="d-flex justify-content-between mb-3">

                        <span>
                            Unidades disponibles
                        </span>

                        <strong>
                            <?php echo $totalStock; ?>
                        </strong>

                    </div>


                    <div class="d-flex justify-content-between">

                        <span>
                            Productos con bajo stock
                        </span>

                        <strong class="text-danger">

                            <?php echo $productosBajoStock; ?>

                        </strong>

                    </div>


                </div>

            </div>

        </div>


        <!-- ACCESOS RÁPIDOS -->

        <div class="col-lg-6">

            <div class="card shadow-sm border-0">

                <div class="card-body p-4">

                    <h4 class="mb-3">

                        <i class="fa-solid fa-bolt text-primary"></i>

                        Accesos rápidos

                    </h4>


                    <hr>


                    <div class="row g-3">


                        <div class="col-md-6">

                            <a
                                href="productos/crear.php"
                                class="acceso">

                                <div class="card border">

                                    <div class="card-body">

                                        <i class="fa-solid fa-plus text-primary"></i>

                                        <strong class="ms-2">
                                            Nuevo producto
                                        </strong>

                                    </div>

                                </div>

                            </a>

                        </div>


                        <div class="col-md-6">

                            <a
                                href="ventas/registrar.php"
                                class="acceso">

                                <div class="card border">

                                    <div class="card-body">

                                        <i class="fa-solid fa-cart-plus text-primary"></i>

                                        <strong class="ms-2">
                                            Registrar venta
                                        </strong>

                                    </div>

                                </div>

                            </a>

                        </div>


                        <div class="col-md-6">

                            <a
                                href="productos/listar.php"
                                class="acceso">

                                <div class="card border">

                                    <div class="card-body">

                                        <i class="fa-solid fa-list text-primary"></i>

                                        <strong class="ms-2">
                                            Ver productos
                                        </strong>
                                        
                                    </div>

                                </div>

                            </a>

                        </div>


                        <div class="col-md-6">

                            <a
                                href="reportes/ventas.php"
                                class="acceso">

                                <div class="card border">

                                    <div class="card-body">

                                        <i class="fa-solid fa-chart-column text-primary"></i>

                                        <strong class="ms-2">
                                            Ver reportes
                                        </strong>


                                    </div>

                                </div>

                            </a>

                        </div>


                    </div>

                </div>

            </div>

        </div>


    </div>


</div>


<!-- FOOTER -->

<footer class="bg-dark text-white text-center p-3">

    <p class="mb-0">

        VentaFlujo © 2026 |

        Sistema de gestión de productos,
        inventario y ventas

    </p>

</footer>


</body>

</html>