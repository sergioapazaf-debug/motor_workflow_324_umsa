<h4>
    <?= $proceso['nombre'] ?>
</h4>

<hr>

<h5>
    Información registrada
</h5>

<?php if (!empty($datosRevisables)) { ?>

    <?php foreach ($datosRevisables as $dato) { ?>

        <div class="card mb-3">

            <div class="card-body">

                <strong>

                    <?= $dato['proceso'] ?>

                    :

                    <?= $dato['nombre'] ?>

                </strong>

                <hr>

                <?= nl2br($dato['contenido']) ?>

            </div>

        </div>

    <?php } ?>

<?php } else { ?>

    <p>

        Sin información registrada

    </p>

<?php } ?>

<hr>

<?php if ($_SESSION['rol'] == $proceso['rol']) { ?>

    <form method="POST">

        <label class="mb-2">

            Medicamentos entregados

        </label>

        <textarea
            name="contenido"
            class="form-control"
            rows="6"
            placeholder="Indique los medicamentos entregados, dosis y observaciones..."><?= isset($contenido['contenido'])
                                                                                            ? $contenido['contenido']
                                                                                            : '' ?></textarea>

        <button class="btn btn-primary mt-3"> Guardar</button>

    </form>

<?php } ?>