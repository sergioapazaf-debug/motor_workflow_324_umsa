<h4>Documentos</h4>

<form method="POST">

    <label class="mb-2">

        Documentos entregados

    </label>

    <textarea
        name="contenido"
        class="form-control"
        rows="4"
        placeholder="Ej: Certificado de notas, carnet universitario..."
    ><?= isset($contenido['contenido'])
            ? $contenido['contenido']
            : '' ?></textarea>

    <button
        class="btn btn-primary mt-3">

        Guardar

    </button>

</form>