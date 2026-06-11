<h4>Solicitud Rechazada</h4>

<hr>

<h5>Observación Kardex</h5>

<?php if (!empty($resultados)) { ?>

    <?php foreach ($resultados as $resultado) { ?>

        <div class="alert alert-danger">

            <?= nl2br(
                $resultado['contenido']
            ) ?>

        </div>

    <?php } ?>

<?php } else { ?>

    <p>

        Sin observaciones

    </p>

<?php } ?>