<?php

session_start();

require_once __DIR__ . "/../models/Solicitud.php";

class SolicitudController
{

    public function index()
    {

        if (isset($_GET['accion'])) {
            $this->avanzar();
        } else if (isset($_GET['id'])) {
            $this->ver();
        } else {
            $this->crear();
        }
    }

    public function crear()
    {
        if (!isset($_SESSION['usuario'])) {
            header("Location: index.php");
            exit;
        }

        $flujo = $_GET['flujo'];

        $solicitudModel = new Solicitud();

        if (!$solicitudModel->crear($flujo, $_SESSION['usuario'])) {

            $_SESSION['error'] =
                "No tiene permisos para iniciar este flujo";

            header("Location: index.php?controller=dashboard");
            exit;
        }

        header("Location: index.php?controller=dashboard");

        exit;
    }

    public function ver()
    {
        $solicitudModel = new Solicitud();

        // solicitudes = s, flujos = f --> solo un registro como resultado
        // [s.id, s.flujo, s.usuario_creador, s.proceso_actual, s.fecha_inicio, s.fecha_fin]
        // [f.nombre AS nombre_flujo]
        $solicitud = $solicitudModel->obtenerPorId($_GET['id']);

        if (!$solicitud) {
            header("Location: index.php?controller=dashboard");
            exit;
        }

        // solicitudes = s, historial = h, procesos = pd, procesos = po
        // [h.id, h.id_solicitud, h.proceso_origen, h.proceso, h.accion, h.usuario, h.fecha]
        // [pd.nombre AS nombre_proceso, po.nombre AS nombre_proceso_origen]
        $historial = $solicitudModel->obtenerHistorial($_GET['id']);

        //transiciones[id, flujo, proceso_actual, proceso_siguiente, accion]
        $transiciones = $solicitudModel->obtenerTransiciones(
            $solicitud['flujo'],
            $solicitud['proceso_actual']
        );

        // procesos [id, flujo, proceso, nombre, descripcion, rol, vista, tipo, revisable, genera_resultado]
        $proceso = $solicitudModel->obtenerProceso(
            $solicitud['flujo'],
            $solicitud['proceso_actual']
        );

        // datos_proceso [id, id_solicitud, proceso, contenido, fecha] --> del proceso en específico
        $contenido = $solicitudModel->obtenerContenido(
            $solicitud['id'],
            $solicitud['proceso_actual']
        );

        // datos_proceso [id, id_solicitud, proceso, contenido, fecha] --> grupo de procesos que tienen contenido
        $datosSolicitud = $solicitudModel->obtenerDatosSolicitud(
            $solicitud['id']
        );

        // solicitudes = s, datos_proceso = dp, procesos = p --> grupo de procesos que tienen contenido y son revisables
        // [dp.id, dp.id_solicitud, dp.proceso, dp.contenido, dp.fecha]
        // [p.nombre AS nombre_proceso]
        $datosRevisables = $solicitudModel->obtenerDatosRevisables(
            $solicitud['id']
        );

        // solicitudes = s, datos_proceso = dp, procesos = p -- > grupo de procesos que tienen contenido y generan resultado
        // [dp.id, dp.id_solicitud, dp.proceso, dp.contenido, dp.fecha]
        // [p.nombre AS nombre_proceso]
        $resultados = $solicitudModel->obtenerResultados($solicitud['id']);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $solicitudModel->guardarContenido(
                $solicitud['id'],
                $solicitud['proceso_actual'],
                $_POST['contenido']
            );

            header("Location:index.php?controller=solicitud&id=" . $solicitud['id']);
            exit;
        }

        require_once __DIR__ . "/../views/SolicitudView.php";
    }

    // actualiza db si es valido, luego 'refresca' la pagina de la solicitud con el mismo id, si la db cambio la vista se actualiza con los nuevos datos
    public function avanzar()
    {
        $solicitudModel = new Solicitud();
        $solicitudModel->avanzar($_GET['id'], $_GET['accion']);

        header("Location:index.php?controller=solicitud&id=" . $_GET['id']);

        exit;
    }
}
