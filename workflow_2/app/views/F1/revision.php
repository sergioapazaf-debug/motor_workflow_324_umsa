<h4>Revisión Kardex</h4>

<hr>

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

                <hr>

                <?= nl2br(
                    $dato['contenido']
                ) ?>

            </div>

        </div>

    <?php } ?>

<?php } else { ?>

    <p>

        Sin información registrada

    </p>

<?php } ?>