<h4>
    <?= $proceso['nombre'] ?>
</h4>

<p>
    <strong>Trámite:</strong>
    <?= $solicitud['nombre_flujo'] ?>
</p>

<hr>

<h5>Resultado</h5>

<?php if (!empty($resultados)) { ?>

    <?php foreach ($resultados as $resultado) { ?>

        <div class="alert alert-success">
            <strong><?= $resultado['nombre'] ?></strong><br>
            <?= nl2br($resultado['contenido']) ?>

        </div>

    <?php } ?>

<?php } else { ?>

    <p>
        Solicitud aprobada correctamente
    </p>

<?php } ?>