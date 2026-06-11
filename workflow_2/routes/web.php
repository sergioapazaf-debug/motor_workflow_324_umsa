<?php

$controller = isset($_GET['controller'])
    ? $_GET['controller']
    : 'login';

switch ($controller) {

    case 'dashboard':

        require_once __DIR__ . "/../app/controllers/DashboardController.php";

        $controller = new DashboardController();

        $controller->index();

        break;

    case 'logout':

        require_once __DIR__ . "/../app/controllers/LogoutController.php";

        $controller = new LogoutController();

        $controller->index();

        break;

    case 'solicitud':

        require_once __DIR__ . "/../app/controllers/SolicitudController.php";

        $controller = new SolicitudController();

        $controller->index();

        break;

    default:

        require_once __DIR__."/../app/controllers/LoginController.php";

        $controller = new LoginController();

        $controller->index();

        break;
}