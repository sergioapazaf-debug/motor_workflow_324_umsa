<?php

session_start();

class LogoutController {

    public function index() {

        session_destroy();

        header("Location: index.php");

        exit;
    }
}