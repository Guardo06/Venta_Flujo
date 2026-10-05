<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Iniciar sesión - VentaFlujo</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

</head>

<body class="bg-light">

<div class="container">

    <div class="row justify-content-center mt-5">

        <div class="col-md-5">

            <div class="card shadow">

                <div class="card-body p-4">

                    <h2 class="text-center mb-4">
                        VentaFlujo
                    </h2>

                    <p class="text-center text-muted">
                        Iniciar sesión
                    </p>

                    <form action="dashboard.php" method="POST">

                        <div class="mb-3">

                            <label class="form-label">
                                Usuario
                            </label>

                            <input
                                type="text"
                                name="usuario"
                                class="form-control"
                                placeholder="Ingrese su usuario"
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
                                placeholder="Ingrese su contraseña"
                                required>

                        </div>

                        <button
                            type="submit"
                            class="btn btn-primary w-100">

                            Ingresar

                        </button>

                    </form>

                    <div class="text-center mt-3">

                        <span>
                            ¿No tienes cuenta?
                        </span>

                        <a href="registro.php">
                            Registrarte
                        </a>

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

</div>

</body>
</html>