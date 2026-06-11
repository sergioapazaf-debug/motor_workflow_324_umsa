<h4><?= $proceso['nombre'] ?></h4>

<form method="POST">

    <label class="mb-2">

        Datos del paciente

    </label>

    <textarea
        name="contenido"
        class="form-control"
        rows="6"
        placeholder="Nombre:&#10;DNI:&#10;Edad:&#10;Teléfono:"
    ><?= isset($contenido['contenido'])
            ? $contenido['contenido']
            : '' ?></textarea>

    <button
        class="btn btn-primary mt-3">

        Guardar

    </button>

</form>