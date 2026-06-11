<?php
$usuarios = [
    'recepcionista1',
    'medico1',
    'farmaceutico1',
    'cajero1'
];

foreach ($usuarios as $usuario) {

    echo $usuario . "<br>";

    echo password_hash(
        "123",
        PASSWORD_DEFAULT
    );

    echo "<br><br>";
}