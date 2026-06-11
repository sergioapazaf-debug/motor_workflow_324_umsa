<h4>
    <?= $proceso['nombre'] ?>
</h4>

<div class="alert alert-success">

    La atención clínica ha finalizado correctamente.

</div>

<hr>

<h5>
    Resultados de la atención
</h5>

<?php if (!empty($resultados)) { ?>

    <?php foreach ($resultados as $resultado) { ?>

        <div class="card mb-3">

            <div class="card-body">

                <strong>

                    <?= $resultado['proceso'] ?>

                    :

                    <?= $resultado['nombre_proceso'] ?>

                </strong>

                <hr>

                <?= nl2br($resultado['contenido']) ?>

            </div>

        </div>

    <?php } ?>

<?php } else { ?>

    <p>

        Sin resultados registrados

    </p>

<?php } ?>