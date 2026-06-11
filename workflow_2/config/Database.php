<?php

class Database {

    private $host = "localhost";
    private $user = "sergio";
    private $password = "123456";
    private $database = "workflow2";

    public function connect() {

        $conexion = mysqli_connect(
            $this->host,
            $this->user,
            $this->password,
            $this->database
        );

        if (!$conexion) {
            die("Error de conexión workflow");
        }

        mysqli_set_charset($conexion, "utf8mb4");

        return $conexion;
    }
}