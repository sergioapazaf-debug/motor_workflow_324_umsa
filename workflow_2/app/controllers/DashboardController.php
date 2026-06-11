<?php

session_start();

class DashboardController
{

    public function index()
    {

        if (!isset($_SESSION['usuario'])) {
            header("Location: index.php");
            exit;
        }

        require_once __DIR__ . "/../models/Solicitud.php";

        $solicitudModel = new Solicitud();
        // flujos[id, flujo, nombre, descripcion]
        $flujos = $solicitudModel->listarFlujos();

        if ($_SESSION['rol'] == 'alumno') {
            // [s.*, nombre_proceso, nombre_flujo]
            $solicitudes = $solicitudModel->listarPorUsuario($_SESSION['usuario']);
        } else {
            // [s.*, nombre_proceso, nombre_flujo]
            $solicitudes = $solicitudModel->listarPorRol($_SESSION['rol']);
        }

        if (!isset($solicitudes)) $solicitudes = [];

        $historialUsuario = $solicitudModel->obtenerHistorialUsuario($_SESSION['usuario']);
        $seguimientoUsuario = $solicitudModel->obtenerSeguimientoUsuario($_SESSION['usuario']);
        $solicitudesParticipadas = $solicitudModel->obtenerSolicitudesParticipadas($_SESSION['usuario']);
        foreach ($solicitudesParticipadas as &$solicitudParticipada) {

            $solicitudParticipada['historial'] =
                $solicitudModel->obtenerHistorial(
                    $solicitudParticipada['id']
                );

            $solicitudParticipada['seguimiento'] =
                $solicitudModel->obtenerSeguimiento(
                    $solicitudParticipada['id']
                );
        }

        require_once __DIR__ . "/../views/DashboardView.php";
    }
}
