<?php

require_once "config/conexion.php";

$mensaje = "";
$tipo = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = trim($_POST["nombre"]);
    $usuario = trim($_POST["usuario"]);
    $password = $_POST["password"];
    $confirmar_password = $_POST["confirmar_password"];

    if (empty($nombre) || empty($usuario) || empty($password)) {

        $mensaje = "Todos los campos son obligatorios.";
        $tipo = "danger";

    } elseif ($password !== $confirmar_password) {

        $mensaje = "Las contraseñas no coinciden.";
        $tipo = "danger";

    } else {

        // Comprobar si el usuario ya existe
        $consulta = $conexion->prepare(
            "SELECT id FROM usuarios WHERE usuario = ?"
        );

        $consulta->execute([$usuario]);

        if ($consulta->fetch()) {

            $mensaje = "El nombre de usuario ya está registrado.";
            $tipo = "danger";

        } else {

            // Encriptar contraseña
            $password_segura = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            // Registrar usuario
            $insertar = $conexion->prepare(
                "INSERT INTO usuarios 
                (nombre, usuario, password)
                VALUES (?, ?, ?)"
            );

            $insertar->execute([
                $nombre,
                $usuario,
                $password_segura
            ]);

            $mensaje = "Cuenta creada correctamente. Ahora puedes iniciar sesión.";
            $tipo = "success";
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

    <title>Crear cuenta - VentaFlujo</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

</head>

<body class="bg-light">

<div class="container">

    <div class="row justify-content-center mt-5">

        <div class="col-md-6">

            <div class="card shadow">

                <div class="card-body p-4">

                    <h2 class="text-center mb-2">
                        VentaFlujo
                    </h2>

                    <p class="text-center text-muted mb-4">
                        Crear una cuenta
                    </p>

                    <?php if (!empty($mensaje)): ?>

                        <div class="alert alert-<?php echo $tipo; ?>">
                            <?php echo $mensaje; ?>
                        </div>

                    <?php endif; ?>


                    <form method="POST">

                        <div class="mb-3">

                            <label class="form-label">
                                Nombre completo
                            </label>

                            <input
                                type="text"
                                name="nombre"
                                class="form-control"
                                placeholder="Ingrese su nombre"
                                required>

                        </div>


                        <div class="mb-3">

                            <label class="form-label">
                                Usuario
                            </label>

                            <input
                                type="text"
                                name="usuario"
                                class="form-control"
                                placeholder="Ingrese un usuario"
                                required>

                        </div>


                        <div class="mb-3">

                            <label class="form-label">
                                Contraseña
                            </label>

                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                placeholder="Ingrese una contraseña"
                                required>

                        </div>


                        <div class="mb-3">

                            <label class="form-label">
                                Confirmar contraseña
                            </label>

                            <input
                                type="password"
                                name="confirmar_password"
                                class="form-control"
                                placeholder="Repita su contraseña"
                                required>

                        </div>


                        <button
                            type="submit"
                            class="btn btn-primary w-100">

                            Crear cuenta

                        </button>

                    </form>


                    <div class="text-center mt-3">

                        <span>
                            ¿Ya tienes una cuenta?
                        </span>

                        <a href="login.php">
                            Iniciar sesión
                        </a>

                    </div>


                    <div class="text-center mt-2">

                        <a href="index.php">
                            Volver al inicio
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>