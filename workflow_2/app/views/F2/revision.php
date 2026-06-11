<h4>
    <?= $proceso['nombre'] ?>
</h4>

<hr>

<?php if (
    $proceso['proceso'] == 'P4'
    && $_SESSION['rol'] == $proceso['rol']
) { ?>

    <form method="POST">

        <label class="mb-2">

            Observaciones de revisión

        </label>

        <textarea
            name="contenido"
            class="form-control"
            rows="4"
            placeholder="Ingrese observaciones sobre la revisión realizada..."><?= isset($contenido['contenido'])
                                                                                    ? $contenido['contenido']
                                                                                    : '' ?></textarea>

        <button
            class="btn btn-primary mt-3">

            Guardar

        </button>

    </form>

    <hr>

<?php } ?>

<h5>Información enviada</h5>

<?php if (!empty($datosRevisables)) { ?>

    <?php foreach ($datosRevisables as $dato) { ?>

        <div class="card mb-3">

            <div class="card-body">

                <strong>

                    <?= $dato['proceso'] ?>

                    :

                    <?= $dato['nombre'] ?>

                </strong>
                </br>
                <?= nl2br($dato['contenido']) ?>
                <hr>


            </div>

        </div>

    <?php } ?>

<?php } else { ?>

    <p>

        Sin información registrada

    </p>

<?php } ?>