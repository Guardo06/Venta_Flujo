<?php

require_once "../config/conexion.php";

$mensaje = "";
$tipo = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = trim($_POST["nombre"]);
    $descripcion = trim($_POST["descripcion"]);
    $precio = $_POST["precio"];
    $stock = $_POST["stock"];
    $categoria = trim($_POST["categoria"]);

    if (
        empty($nombre) ||
        empty($precio) ||
        $stock === ""
    ) {

        $mensaje = "Por favor complete los campos obligatorios.";
        $tipo = "danger";

    } elseif ($precio < 0 || $stock < 0) {

        $mensaje = "El precio y el stock no pueden ser negativos.";
        $tipo = "danger";

    } else {

        $consulta = $conexion->prepare(
            "INSERT INTO productos
            (nombre, descripcion, precio, stock, categoria)
            VALUES (?, ?, ?, ?, ?)"
        );

        $consulta->execute([
            $nombre,
            $descripcion,
            $precio,
            $stock,
            $categoria
        ]);

        $mensaje = "Producto registrado correctamente.";
        $tipo = "success";

        // Limpiar campos
        $nombre = "";
        $descripcion = "";
        $precio = "";
        $stock = "";
        $categoria = "";
    }
}

?>

<!DOCTYPE html>

<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Nuevo producto - VentaFlujo</title>

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

        .form-container {
            max-width: 800px;
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
                href="listar.php"
                class="btn btn-outline-light">

                <i class="fa-solid fa-box"></i>

                Productos

            </a>

        </div>

    </div>

</nav>


<!-- FORMULARIO -->

<div class="container">

    <div class="form-container">

        <div class="card shadow">

            <div class="card-body p-4">

                <h2 class="titulo mb-1">

                    <i class="fa-solid fa-plus text-primary"></i>

                    Nuevo producto

                </h2>

                <p class="text-muted">
                    Registre un nuevo producto en el inventario.
                </p>


                <?php if (!empty($mensaje)): ?>

                    <div class="alert alert-<?php echo $tipo; ?>">

                        <?php echo $mensaje; ?>

                    </div>

                <?php endif; ?>


                <form method="POST">


                    <!-- NOMBRE -->

                    <div class="mb-3">

                        <label class="form-label">
                            Nombre del producto *
                        </label>

                        <input
                            type="text"
                            name="nombre"
                            class="form-control"
                            placeholder="Ej: Arroz Diana 500g"
                            value="<?php echo htmlspecialchars($nombre ?? ''); ?>"
                            required>

                    </div>


                    <!-- DESCRIPCIÓN -->

                    <div class="mb-3">

                        <label class="form-label">
                            Descripción
                        </label>

                        <textarea
                            name="descripcion"
                            class="form-control"
                            rows="3"
                            placeholder="Descripción del producto"><?php echo htmlspecialchars($descripcion ?? ''); ?></textarea>

                    </div>


                    <div class="row">


                        <!-- PRECIO -->

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Precio *
                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    $
                                </span>

                                <input
                                    type="number"
                                    name="precio"
                                    class="form-control"
                                    min="0"
                                    step="0.01"
                                    placeholder="0.00"
                                    value="<?php echo htmlspecialchars($precio ?? ''); ?>"
                                    required>

                            </div>

                        </div>


                        <!-- STOCK -->

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Stock *
                            </label>

                            <input
                                type="number"
                                name="stock"
                                class="form-control"
                                min="0"
                                placeholder="Cantidad disponible"
                                value="<?php echo htmlspecialchars($stock ?? ''); ?>"
                                required>

                        </div>


                    </div>


                    <!-- CATEGORÍA -->

                    <div class="mb-4">

                        <label class="form-label">
                            Categoría
                        </label>

                        <select
                            name="categoria"
                            class="form-select">

                            <option value="">
                                Seleccione una categoría
                            </option>

                            <option value="Alimentos">
                                Alimentos
                            </option>

                            <option value="Bebidas">
                                Bebidas
                            </option>

                            <option value="Aseo">
                                Aseo
                            </option>

                            <option value="Hogar">
                                Hogar
                            </option>

                            <option value="Otros">
                                Otros
                            </option>

                        </select>

                    </div>


                    <!-- BOTONES -->

                    <div class="d-flex gap-2">

                        <button
                            type="submit"
                            class="btn btn-primary">

                            <i class="fa-solid fa-save"></i>

                            Guardar producto

                        </button>


                        <a
                            href="listar.php"
                            class="btn btn-secondary">

                            <i class="fa-solid fa-arrow-left"></i>

                            Volver

                        </a>

                    </div>


                </form>

            </div>

        </div>

    </div>

</div>


</body>

</html>