<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Login</title>

    <link rel="stylesheet" href="/workflow_2/public/assets/css/bootstrap.min.css">

</head>

<body class="bg-light">

    <div class="container">

        <div class="row justify-content-center mt-5">

            <div class="col-md-4">

                <div class="card shadow">

                    <div class="card-body">

                        <h3 class="text-center mb-4">
                            Iniciar Sesión
                        </h3>

                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label"> Usuario </label>
                                <input type="text" name="usuario" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Contraseña</label>
                                <input type="password" name="password" class="form-control">
                            </div>

                            <button type="submit" class="btn btn-primary w-100"> Ingresar</button>
                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>
    <script src="/workflow_2/public/assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>