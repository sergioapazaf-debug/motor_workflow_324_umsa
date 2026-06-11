<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>

    <link rel="stylesheet"
        href="/workflow_2/public/assets/css/bootstrap.min.css">
</head>

<body class="bg-light">

    <div class="container mt-4">

        <div class="card shadow">

            <div class="card-body">

                <h1 class="mb-3">Dashboard</h1>

                <p>
                    <strong>Bienvenido:</strong><?= $_SESSION['usuario']; ?>
                </p>

                <p>
                    <strong>Rol:</strong><?= $_SESSION['rol']; ?>
                </p>
                <?php if (isset($_SESSION['error'])) { ?>
                
                    <div class="alert alert-danger">
                        <?= $_SESSION['error'] ?>
                    </div>

                    <?php unset($_SESSION['error']); ?>
                <?php } ?>

                <?php if ($_SESSION['rol'] == 'alumno' || $_SESSION['rol'] == 'recepcionista') { ?>
                    <form action="index.php" method="GET" class="mb-3">
                        <input type="hidden" name="controller" value="solicitud">
                        <div class="mb-2">

                            <label> Flujo </label>

                            <select name="flujo" class="form-control">
                                <?php foreach ($flujos as $flujo) { ?>
                                    <option value="<?= $flujo['flujo'] ?>">
                                        <?= $flujo['flujo'] ?> : <?= $flujo['nombre'] ?>
                                    </option>
                                <?php } ?>
                            </select>

                        </div>
                        <button class="btn btn-primary">Nueva Solicitud</button>
                    </form>
                <?php } ?>

                <a href="index.php?controller=logout" class="btn btn-danger mb-3">Cerrar sesión</a>

                <h4>

                    <?php if ($_SESSION['rol'] == 'alumno') { ?>
                        Mis solicitudes
                    <?php } else { ?>
                        Bandeja pendientes
                    <?php } ?>

                </h4>
                <div class="border rounded p-3 mb-4">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Flujo</th>
                                <?php if ($_SESSION['rol'] != 'alumno') { ?>
                                    <th>Solicitante</th>
                                <?php } ?>
                                <th>Etapa actual</th>
                                <th>Inicio</th>
                                <th>Fin</th>
                                <th>Estado</th>
                                <th>Accion</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php foreach ($solicitudes as $solicitud) { ?>

                                <tr>
                                    <!-- ID -->
                                    <td><?= $solicitud['id'] ?></td>
                                    <!-- Flujo -->
                                    <td><?= $solicitud['flujo'] ?>:<?= $solicitud['nombre_flujo'] ?> </td>
                                    <!-- Solicitante -->
                                    <?php if ($_SESSION['rol'] != 'alumno') { ?>
                                        <td>
                                            <?= $solicitud['usuario_creador'] ?>
                                        </td>
                                    <?php } ?>
                                    <!-- Etapa actual -->
                                    <td><?= $solicitud['proceso_actual'] ?>:<?= $solicitud['nombre_proceso'] ?></td>
                                    <!-- Inicio -->
                                    <td><?= $solicitud['fecha_inicio'] ?></td>
                                    <!-- Fin -->
                                    <td><?= $solicitud['fecha_fin'] ?? '-' ?></td>
                                    <!-- Estado -->
                                    <td>
                                        <?php if ($solicitud['fecha_fin']) { ?>
                                            Finalizado
                                        <?php } else { ?>
                                            En proceso
                                        <?php } ?>
                                    </td>
                                    <!-- Accion -->
                                    <td>
                                        <a href="index.php?controller=solicitud&id=<?= $solicitud['id'] ?>" class="btn btn-sm btn-primary">
                                            Abrir
                                        </a>
                                    </td>
                                </tr>

                            <?php } ?>

                        </tbody>

                    </table>
                </div>
                <h4 class="mt-4">
                    Historial y Seguimiento
                </h4>

                <?php if (!empty($solicitudesParticipadas)) { ?>

                    <?php foreach ($solicitudesParticipadas as $solicitud) { ?>
                        <hr>
                        <div class="card mt-3">

                            <div class="card-header">

                                <strong>

                                    Solicitud #<?= $solicitud['id'] ?>

                                </strong>

                                -

                                <?= $solicitud['flujo'] ?>

                                :

                                <?= $solicitud['nombre_flujo'] ?>

                            </div>

                            <div class="card-body">

                                <h6>
                                    Historial
                                </h6>

                                <div
                                    class="table-responsive"
                                    style="max-height:250px; overflow-y:auto;">

                                    <table class="table table-bordered table-sm">

                                        <thead class="table-light">

                                            <tr>

                                                <th class="sticky-top bg-light">Origen</th>

                                                <th class="sticky-top bg-light">Proceso</th>

                                                <th class="sticky-top bg-light">Acción</th>

                                                <th class="sticky-top bg-light">Usuario</th>

                                                <th class="sticky-top bg-light">Fecha</th>

                                            </tr>

                                        </thead>

                                        <tbody>

                                            <?php foreach ($solicitud['historial'] as $item) { ?>

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

                                </div>

                                <hr>

                                <h6>
                                    Seguimiento
                                </h6>

                                <div
                                    class="table-responsive"
                                    style="max-height:250px; overflow-y:auto;">

                                    <table class="table table-bordered table-sm">

                                        <thead class="table-light">

                                            <tr>

                                                <th class="sticky-top bg-light">Proceso</th>

                                                <th class="sticky-top bg-light">Responsable</th>

                                                <th class="sticky-top bg-light">Inicio</th>

                                                <th class="sticky-top bg-light">Fin</th>

                                                <th class="sticky-top bg-light">Estado</th>

                                            </tr>

                                        </thead>

                                        <tbody>

                                            <?php foreach ($solicitud['seguimiento'] as $item) { ?>

                                                <tr>

                                                    <td>

                                                        <?= $item['proceso'] ?>

                                                        :

                                                        <?= $item['nombre_proceso'] ?>

                                                    </td>

                                                    <td>

                                                        <?= $item['usuario'] ?>

                                                    </td>

                                                    <td>

                                                        <?= $item['fecha_inicio'] ?>

                                                    </td>

                                                    <td>

                                                        <?= $item['fecha_fin']
                                                            ? $item['fecha_fin']
                                                            : '—' ?>

                                                    </td>

                                                    <td>

                                                        <?= $item['estado'] ?>

                                                    </td>

                                                </tr>

                                            <?php } ?>

                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>

                    <?php } ?>

                <?php } else { ?>

                    <p>
                        Sin participaciones registradas
                    </p>

                <?php } ?>
            </div>

        </div>

    </div>
    <script src="/workflow_2/public/assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>