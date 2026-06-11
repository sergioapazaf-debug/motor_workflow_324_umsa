<h4>
    <?= $proceso['nombre'] ?>
</h4>

<?php if ($_SESSION['rol'] == $proceso['rol']) { ?>

    <form method="POST">

        <label class="mb-2">

            Observación

        </label>

        <textarea
            name="contenido"
            class="form-control"
            rows="4"
            placeholder="Escriba observaciones..."
        ><?= isset($contenido['contenido'])
                ? $contenido['contenido']
                : '' ?></textarea>

        <button
            class="btn btn-primary mt-3">

            Guardar

        </button>

    </form>

<?php } ?>