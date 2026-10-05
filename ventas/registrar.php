<?php

require_once "../config/conexion.php";

$mensaje = "";
$tipo = "";

// Obtener productos con stock disponible
$consulta = $conexion->query("
    SELECT id, nombre, precio, stock
    FROM productos
    WHERE stock > 0
    ORDER BY nombre ASC
");

$productos = $consulta->fetchAll(PDO::FETCH_ASSOC);


// Procesar venta
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $producto_id = $_POST["producto_id"];
    $cantidad = (int) $_POST["cantidad"];

    // Validar datos
    if (empty($producto_id) || $cantidad <= 0) {

        $mensaje = "Seleccione un producto e ingrese una cantidad válida.";
        $tipo = "danger";

    } else {

        // Buscar producto
        $consulta = $conexion->prepare("
            SELECT id, nombre, precio, stock
            FROM productos
            WHERE id = ?
        ");

        $consulta->execute([$producto_id]);

        $producto = $consulta->fetch(PDO::FETCH_ASSOC);


        if (!$producto) {

            $mensaje = "El producto no existe.";
            $tipo = "danger";

        } elseif ($cantidad > $producto["stock"]) {

            $mensaje = "No hay suficiente stock disponible. Stock actual: "
                     . $producto["stock"];

            $tipo = "danger";

        } else {

            // Calcular valores
            $precio_unitario = $producto["precio"];
            $total = $precio_unitario * $cantidad;


            try {

                // Iniciar transacción
                $conexion->beginTransaction();


                // 1. Registrar la venta
                $insertarVenta = $conexion->prepare("
                    INSERT INTO ventas
                    (producto_id, cantidad, precio_unitario, total)
                    VALUES (?, ?, ?, ?)
                ");

                $insertarVenta->execute([
                    $producto_id,
                    $cantidad,
                    $precio_unitario,
                    $total
                ]);


                // Obtener ID de la venta
                $venta_id = $conexion->lastInsertId();


                // 2. Registrar detalle de la venta
                $insertarDetalle = $conexion->prepare("
                    INSERT INTO detalle_ventas
                    (venta_id, producto_id, cantidad, precio_unitario, subtotal)
                    VALUES (?, ?, ?, ?, ?)
                ");

                $insertarDetalle->execute([
                    $venta_id,
                    $producto_id,
                    $cantidad,
                    $precio_unitario,
                    $total
                ]);


                // 3. Descontar stock
                $actualizarStock = $conexion->prepare("
                    UPDATE productos
                    SET stock = stock - ?
                    WHERE id = ?
                ");

                $actualizarStock->execute([
                    $cantidad,
                    $producto_id
                ]);


                // Confirmar todos los cambios
                $conexion->commit();


                $mensaje = "Venta registrada correctamente. "
                         . "Total: $"
                         . number_format($total, 0, ",", ".");

                $tipo = "success";


                // Volver a cargar productos
                $consulta = $conexion->query("
                    SELECT id, nombre, precio, stock
                    FROM productos
                    WHERE stock > 0
                    ORDER BY nombre ASC
                ");

                $productos = $consulta->fetchAll(PDO::FETCH_ASSOC);


            } catch (Exception $e) {

                // Deshacer cambios si ocurre algún error
                if ($conexion->inTransaction()) {
                    $conexion->rollBack();
                }

                $mensaje = "Error al registrar la venta: "
                         . $e->getMessage();

                $tipo = "danger";
            }
        }
    }
}

?>

<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Registrar venta - VentaFlujo</title>

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
            max-width: 850px;
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


<!-- BARRA DE NAVEGACIÓN -->

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
                href="listar.php"
                class="btn btn-outline-light">

                <i class="fa-solid fa-cart-shopping"></i>

                Ventas

            </a>

        </div>

    </div>

</nav>


<!-- CONTENIDO -->

<div class="container">

    <div class="contenedor">

        <div class="card shadow">

            <div class="card-body p-4">


                <h2 class="titulo mb-1">

                    <i class="fa-solid fa-cart-plus text-primary"></i>

                    Registrar venta

                </h2>


                <p class="text-muted mb-4">

                    Seleccione un producto y registre la cantidad vendida.

                </p>


                <!-- MENSAJE -->

                <?php if (!empty($mensaje)): ?>

                    <div class="alert alert-<?php echo $tipo; ?>">

                        <?php echo htmlspecialchars($mensaje); ?>

                    </div>

                <?php endif; ?>


                <?php if (count($productos) > 0): ?>


                    <form method="POST">


                        <!-- PRODUCTO -->

                        <div class="mb-4">

                            <label class="form-label fw-bold">

                                Producto *

                            </label>


                            <select
                                name="producto_id"
                                class="form-select"
                                required>

                                <option value="">

                                    Seleccione un producto

                                </option>


                                <?php foreach ($productos as $producto): ?>

                                    <option
                                        value="<?php echo $producto["id"]; ?>">

                                        <?php
                                        echo htmlspecialchars(
                                            $producto["nombre"]
                                        );
                                        ?>

                                        -
                                        $

                                        <?php
                                        echo number_format(
                                            $producto["precio"],
                                            0,
                                            ",",
                                            "."
                                        );
                                        ?>

                                        - Stock:

                                        <?php echo $producto["stock"]; ?>

                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>


                        <!-- CANTIDAD -->

                        <div class="mb-4">

                            <label class="form-label fw-bold">

                                Cantidad *

                            </label>


                            <input
                                type="number"
                                name="cantidad"
                                class="form-control"
                                min="1"
                                required>

                        </div>


                        <!-- BOTONES -->

                        <div class="d-flex gap-2">

                            <button
                                type="submit"
                                class="btn btn-primary">

                                <i class="fa-solid fa-cart-plus"></i>

                                Registrar venta

                            </button>


                            <a
                                href="../dashboard.php"
                                class="btn btn-secondary">

                                <i class="fa-solid fa-arrow-left"></i>

                                Volver

                            </a>

                        </div>


                    </form>


                <?php else: ?>

                    <div class="alert alert-warning">

                        <i class="fa-solid fa-triangle-exclamation"></i>

                        No hay productos disponibles en inventario.

                    </div>


                    <a
                        href="../productos/crear.php"
                        class="btn btn-primary">

                        <i class="fa-solid fa-plus"></i>

                        Registrar producto

                    </a>

                <?php endif; ?>


            </div>

        </div>

    </div>

</div>


</body>

</html>