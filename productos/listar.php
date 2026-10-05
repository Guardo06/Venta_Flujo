<?php

require_once "../config/conexion.php";

$consulta = $conexion->query(
    "SELECT * FROM productos ORDER BY id DESC"
);

$productos = $consulta->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Productos - VentaFlujo</title>

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
            margin-top: 40px;
        }

        .card {
            border: none;
            border-radius: 15px;
        }

        .titulo {
            font-weight: bold;
        }

        .tabla {
            vertical-align: middle;
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
                href="crear.php"
                class="btn btn-primary">

                <i class="fa-solid fa-plus"></i>

                Nuevo producto

            </a>

        </div>

    </div>

</nav>


<!-- CONTENIDO -->

<div class="container contenedor">

    <div class="card shadow-sm">

        <div class="card-body p-4">


            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>

                    <h2 class="titulo mb-1">

                        <i class="fa-solid fa-box text-primary"></i>

                        Productos

                    </h2>

                    <p class="text-muted mb-0">

                        Administración del inventario

                    </p>

                </div>


                <a
                    href="crear.php"
                    class="btn btn-primary">

                    <i class="fa-solid fa-plus"></i>

                    Nuevo producto

                </a>

            </div>


            <?php if (count($productos) > 0): ?>


                <div class="table-responsive">

                    <table class="table table-hover tabla">

                        <thead class="table-dark">

                            <tr>

                                <th>ID</th>

                                <th>Producto</th>

                                <th>Descripción</th>

                                <th>Categoría</th>

                                <th>Precio</th>

                                <th>Stock</th>

                                <th>Acciones</th>

                            </tr>

                        </thead>


                        <tbody>

                            <?php foreach ($productos as $producto): ?>

                                <tr>

                                    <td>
                                        <?php echo $producto["id"]; ?>
                                    </td>


                                    <td>

                                        <strong>
                                            <?php echo htmlspecialchars($producto["nombre"]); ?>
                                        </strong>

                                    </td>


                                    <td>

                                        <?php

                                        echo htmlspecialchars(
                                            $producto["descripcion"]
                                        );

                                        ?>

                                    </td>


                                    <td>

                                        <span class="badge bg-secondary">

                                            <?php

                                            echo htmlspecialchars(
                                                $producto["categoria"]
                                            );

                                            ?>

                                        </span>

                                    </td>


                                    <td>

                                        $<?php

                                        echo number_format(
                                            $producto["precio"],
                                            0,
                                            ",",
                                            "."
                                        );

                                        ?>

                                    </td>


                                    <td>

                                        <?php if ($producto["stock"] <= 5): ?>

                                            <span class="badge bg-danger">

                                                <?php echo $producto["stock"]; ?>

                                            </span>

                                        <?php else: ?>

                                            <span class="badge bg-success">

                                                <?php echo $producto["stock"]; ?>

                                            </span>

                                        <?php endif; ?>

                                    </td>


                                    <td>

                                        <a
                                            href="editar.php?id=<?php echo $producto["id"]; ?>"
                                            class="btn btn-sm btn-warning">

                                            <i class="fa-solid fa-pen"></i>

                                        </a>


                                        <a
                                            href="eliminar.php?id=<?php echo $producto["id"]; ?>"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('¿Está seguro de eliminar este producto?');">

                                            <i class="fa-solid fa-trash"></i>

                                        </a>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>


            <?php else: ?>


                <div class="alert alert-info text-center">

                    <i class="fa-solid fa-box-open"></i>

                    No hay productos registrados todavía.

                </div>


            <?php endif; ?>


        </div>

    </div>

</div>


</body>

</html>