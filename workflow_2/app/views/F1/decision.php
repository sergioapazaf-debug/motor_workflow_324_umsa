<h4>Decisión Kardex</h4>

<form method="POST">

    <label class="mb-2">

        Observación

    </label>

    <textarea
        name="contenido"
        class="form-control"
        rows="4"
        placeholder="Escriba observaciones..."><?= isset($contenido['contenido'])
                                                    ? $contenido['contenido']
                                                    : '' ?></textarea>

    <button
        class="btn btn-primary mt-3">

        Guardar

    </button>

</form>