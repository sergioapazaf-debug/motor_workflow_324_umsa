<?php

require_once "../config/UserDatabase.php";

class User
{

    private $conexion;

    public function __construct()
    {

        $db = new UserDatabase();

        $this->conexion = $db->connect();
    }

    public function login($usuario, $password)
    {
        $sql = "SELECT *
            FROM usuarios
            WHERE usuario='$usuario'";

        $resultado = mysqli_query($this->conexion, $sql);

        $user = mysqli_fetch_assoc($resultado);

        if ($user && password_verify($password, $user['password']))
            return $user;


        return false;
    }
}
