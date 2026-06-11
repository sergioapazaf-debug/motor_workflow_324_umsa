<h4>Requisitos</h4>

<form method="POST">

    <label class="mb-2">

        Documentación presentada

    </label>

    <textarea
        name="contenido"
        class="form-control"
        rows="4"
        placeholder="Ej: Certificado de egreso, historial académico, comprobante de pago..."
    ><?= isset($contenido['contenido'])
            ? $contenido['contenido']
            : '' ?></textarea>

    <button
        class="btn btn-primary mt-3">

        Guardar

    </button>

</form>