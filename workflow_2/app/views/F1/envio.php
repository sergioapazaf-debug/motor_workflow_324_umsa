<h4>Enviar Solicitud</h4>

<form method="POST">

    <label class="mb-2">

        Motivo de la solicitud

    </label>

    <textarea
        name="contenido"
        class="form-control"
        rows="4"
        placeholder="Explique el motivo..."><?= isset($contenido['contenido'])
                                                ? $contenido['contenido']
                                                : '' ?></textarea>

    <button
        class="btn btn-primary mt-3">

        Guardar

    </button>

</form>