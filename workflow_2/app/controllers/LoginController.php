<?php
session_start();
if (isset($_SESSION['usuario'])) {
    header("Location: index.php?controller=dashboard");
    exit;
}

require_once "../app/models/User.php";

class LoginController
{

    public function index()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $usuario = $_POST['usuario'];
            $password = $_POST['password'];

            $userModel = new User();

            $user = $userModel->login($usuario, $password);

            if ($user) {
                $_SESSION['usuario'] = $user['usuario'];
                $_SESSION['rol'] = $user['rol'];

                header("Location: index.php?controller=dashboard");
                
                exit;
            } else {
                echo "Usuario o contraseña incorrectos";
            }
        }

        require_once "../app/views/LoginView.php";
    }
}
