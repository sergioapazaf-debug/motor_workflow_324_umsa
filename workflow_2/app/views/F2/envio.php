<h4>Enviar Solicitud</h4>

<form method="POST">

    <label class="mb-2">

        Información complementaria y observaciones

    </label>

    <textarea
        name="contenido"
        class="form-control"
        rows="4"
        placeholder="Ingrese información adicional relevante para la solicitud..."
    ><?= isset($contenido['contenido'])
            ? $contenido['contenido']
            : '' ?></textarea>

    <button
        class="btn btn-primary mt-3">

        Guardar

    </button>

</form>