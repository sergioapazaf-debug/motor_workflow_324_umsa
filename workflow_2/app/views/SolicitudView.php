<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>

    <link rel="stylesheet" href="/workflow_2/public/assets/css/bootstrap.min.css">
</head>

<body class="bg-light">

    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-body">

                <h2> Solicitud #<?= $solicitud['id'] ?></h2>

                <hr>

                <p>
                    <strong>Flujo:</strong><?= $solicitud['flujo'] ?>:<?= $solicitud['nombre_flujo'] ?>
                </p>

                <p>
                    <strong>Proceso actual:</strong><?= $proceso['proceso'] ?>:<?= $proceso['nombre'] ?>
                </p>

                <p>
                    <strong>Solicitante:</strong> <?= $solicitud['usuario_creador'] ?>
                </p>

                <hr>

                <?php require_once __DIR__ . "/" . $solicitud['flujo'] . "/" . $proceso['vista'] . ".php"; ?>

                <hr>
                <?php if ($_SESSION['rol'] == $proceso['rol']) {
                    foreach ($transiciones as $t) { ?>

                        <a
                            class="btn btn-primary"

                            href="index.php?controller=solicitud&id=<?= $solicitud['id'] ?>&accion=<?= $t['accion'] ?>">

                            <?= $t['accion'] ?>

                        </a>

                    <?php }
                } else { ?>
                    <p>
                        No tiene permisos para actuar en este proceso
                    </p>
                <?php } ?>

                <h4>
                    Historial
                </h4>

                <?php if (!empty($historial)) { ?>

                    <table class="table table-bordered">

                        <thead>

                            <tr>

                                <th>Origen</th>

                                <th>Proceso</th>

                                <th>Acción</th>

                                <th>Usuario</th>

                                <th>Fecha</th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php foreach ($historial as $item) { ?>

                                <tr>

                                    <td>

                                        <?= $item['proceso_origen'] ?>

                                        <?php if ($item['proceso_origen']) { ?>

                                            :

                                            <?= $item['nombre_proceso_origen'] ?>

                                        <?php } ?>

                                    </td>

                                    <td>

                                        <?= $item['proceso'] ?>

                                        :

                                        <?= $item['nombre_proceso'] ?>

                                    </td>

                                    <td>

                                        <?= $item['accion'] ?>

                                    </td>

                                    <td>

                                        <?= $item['usuario'] ?>

                                    </td>

                                    <td>

                                        <?= $item['fecha'] ?>

                                    </td>

                                </tr>

                            <?php } ?>

                        </tbody>

                    </table>

                <?php } else { ?>

                    <p>
                        Sin historial
                    </p>

                <?php } ?>

                <a href="index.php?controller=dashboard"
                    class="btn btn-secondary">

                    Volver

                </a>

            </div>

        </div>

    </div>

    <script src="/workflow_2/public/assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>