<?php

require_once "../config/Database.php";

class Solicitud
{

    private $conexion;

    public function __construct()
    {
        $db = new Database();
        $this->conexion = $db->connect();
    }

    public function crear($flujo, $usuario)
    {
        $sql = "SELECT * FROM procesos
                WHERE flujo='$flujo' AND tipo='I'";

        $resultado = mysqli_query($this->conexion, $sql);

        $procesoInicial = mysqli_fetch_assoc($resultado);

        if (!$procesoInicial)
            return false;

        if ($procesoInicial['rol'] != $_SESSION['rol'])
            return false;
        
        $sql = "INSERT INTO solicitudes (flujo, usuario_creador, proceso_actual)
                VALUES ('$flujo', '$usuario', 'P1')";

        $resultado = mysqli_query($this->conexion, $sql);

        // Obtener el ID de la solicitud recién creada
        $idSolicitud = mysqli_insert_id($this->conexion);

        $this->agregarHistorial($idSolicitud, null, "P1", "Creó solicitud", $_SESSION['usuario']);

        $sql = "INSERT INTO seguimiento_proceso(id_solicitud,flujo,proceso,usuario,estado
                )VALUES('$idSolicitud','$flujo','P1','$usuario','En proceso')";

        mysqli_query($this->conexion, $sql);

        if (!$resultado) {

            die(mysqli_error($this->conexion));
        }

        return $resultado;
    }
    // solicitudes = s, procesos = p, flujos = f
    // [s.id, s.flujo, s.usuario_creador, s.proceso_actual, s.fecha_inicio, s.fecha_fin]
    // [p.nombre AS nombre_proceso]
    // [f.nombre AS nombre_flujo]
    // [s.*, nombre_proceso, nombre_flujo]
    public function listarPorUsuario($usuario)
    {
        $sql = "SELECT s.*, p.nombre AS nombre_proceso, f.nombre AS nombre_flujo
            FROM solicitudes s
            INNER JOIN procesos p
            ON s.proceso_actual = p.proceso
            AND s.flujo = p.flujo
            INNER JOIN flujos f
            ON s.flujo = f.flujo
            WHERE s.usuario_creador='$usuario'
            ";

        $resultado = mysqli_query($this->conexion, $sql);

        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    }

    // solicitudes = s, flujos = f --> solo un registro como resultado
    // [s.id, s.flujo, s.usuario_creador, s.proceso_actual, s.fecha_inicio, s.fecha_fin]
    // [f.nombre AS nombre_flujo]
    public function obtenerPorId($id)
    {
        $sql = "SELECT s.*,f.nombre AS nombre_flujo
            FROM solicitudes s
            INNER JOIN flujos f
            ON s.flujo=f.flujo
            WHERE s.id=$id";

        $resultado = mysqli_query($this->conexion, $sql);

        return mysqli_fetch_assoc($resultado);
    }
    // solicitudes = s, historial = h, procesos = pd, procesos = po
    // [h.id, h.id_solicitud, h.proceso_origen, h.proceso, h.accion, h.usuario, h.fecha]
    // [pd.nombre AS nombre_proceso, po.nombre AS nombre_proceso_origen]
    public function obtenerHistorial($id)
    {
        $sql = "SELECT  h.*, pd.nombre AS nombre_proceso, po.nombre AS nombre_proceso_origen
            FROM historial h
            INNER JOIN solicitudes s
            ON h.id_solicitud=s.id
            LEFT JOIN procesos pd
            ON h.proceso=pd.proceso
            AND s.flujo=pd.flujo
            LEFT JOIN procesos po
            ON h.proceso_origen=po.proceso
            AND s.flujo=po.flujo
            WHERE h.id_solicitud=$id
            ORDER BY h.fecha";

        $resultado = mysqli_query($this->conexion, $sql);

        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    }

    public function agregarHistorial($idSolicitud, $procesoOrigen, $proceso, $accion, $usuario)
    {

        $sql = "INSERT INTO historial(

            id_solicitud,

            proceso_origen,

            proceso,

            accion,

            usuario

            )VALUES(

            '$idSolicitud',

            '$procesoOrigen',

            '$proceso',

            '$accion',

            '$usuario'

         )";

        return mysqli_query($this->conexion, $sql);
    }

    //[id, flujo, proceso_actual, proceso_siguiente, accion]
    public function obtenerTransiciones($flujo, $proceso)
    {

        $sql = "SELECT * FROM transiciones
            WHERE flujo='$flujo' AND proceso_actual='$proceso'";

        $resultado = mysqli_query($this->conexion, $sql);

        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    }

    public function avanzar($idSolicitud, $accion)
    {

        $solicitud = $this->obtenerPorId($idSolicitud);
        $flujo = $solicitud['flujo'];
        $procesoActual = $solicitud['proceso_actual'];
        $proceso = $this->obtenerProceso($flujo, $procesoActual);

        // validar rol
        if ($proceso['rol'] != $_SESSION['rol']) return false;

        // revisa si la accion es valida
        $sql = "SELECT * FROM transiciones
                WHERE flujo='$flujo'
                AND proceso_actual='$procesoActual'
                AND accion='$accion'";

        $resultado = mysqli_query($this->conexion, $sql);

        $transicion = mysqli_fetch_assoc($resultado);

        if (!$transicion) return false;


        $procesoSiguiente = $transicion['proceso_siguiente'];

        // revisar si el proceso siguiente es final o no
        $procesoFinal = $this->obtenerProceso($flujo, $procesoSiguiente);

        // actualizar seguimiento_proceso
        $sql = "UPDATE seguimiento_proceso
                SET fecha_fin = NOW(),estado='Finalizado'
                WHERE id_solicitud='$idSolicitud'
                AND fecha_fin IS NULL";

        mysqli_query($this->conexion, $sql);

        // actualizar solicitud o seguimiento por flujo
        $sql = "UPDATE solicitudes SET proceso_actual='$procesoSiguiente'";

        if ($procesoFinal['tipo'] == 'F')
            $sql .= ", fecha_fin=NOW()";

        $sql .= " WHERE id=$idSolicitud";

        mysqli_query($this->conexion, $sql);

        // ($idSolicitud, $procesoOrigen, $proceso, $accion, $usuario)
        $this->agregarHistorial(
            $idSolicitud,
            $procesoActual,
            $procesoSiguiente,
            $accion,
            $_SESSION['usuario']
        );

        // insertar nuevo seguimiento_proceso
        $sql = "INSERT INTO seguimiento_proceso(
                    id_solicitud,
                    flujo,
                    proceso,
                    usuario,
                    fecha_fin,
                    estado
                )VALUES(
                    '$idSolicitud',
                    '$flujo',
                    '$procesoSiguiente',
                    '" . $_SESSION['usuario'] . "',
                    " . ($procesoFinal['tipo'] == 'F' ? "NOW()" : "NULL") . ",
                    '" . ($procesoFinal['tipo'] == 'F' ? 'Finalizado' : 'En proceso') . "'
                )";

        mysqli_query($this->conexion, $sql);

        return true;
    }

    // [id, flujo, proceso, nombre, descripcion, rol, vista, tipo, revisable, genera_resultado]
    public function obtenerProceso($flujo, $proceso)
    {
        $sql = "SELECT * FROM procesos
            WHERE flujo='$flujo' AND proceso='$proceso'";

        $resultado = mysqli_query($this->conexion, $sql);

        return mysqli_fetch_assoc($resultado);
    }

    // solicitudes = s, procesos = p, flujos = f
    // [s.id, s.flujo, s.usuario_creador, s.proceso_actual, s.fecha_inicio, s.fecha_fin]
    // [p.nombre AS nombre_proceso]
    // [f.nombre AS nombre_flujo]
    // [s.*, nombre_proceso, nombre_flujo]  
    public function listarPorRol($rol)
    {
        $sql = "SELECT s.*,p.nombre AS nombre_proceso,f.nombre AS nombre_flujo
            FROM solicitudes s
            INNER JOIN procesos p
            ON s.proceso_actual=p.proceso
            AND s.flujo=p.flujo
            INNER JOIN flujos f
            ON s.flujo=f.flujo
            WHERE p.rol='$rol'
            ";

        $resultado = mysqli_query($this->conexion, $sql);

        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    }

    // actualiza si existe pero si no existe lo crea
    public function guardarContenido($idSolicitud, $proceso, $contenido)
    {
        // [id, id_solicitud, proceso, contenido, fecha]
        $sql = "SELECT * FROM datos_proceso
                WHERE id_solicitud='$idSolicitud' AND proceso='$proceso'";

        $resultado = mysqli_query($this->conexion, $sql);

        if (mysqli_num_rows($resultado) > 0) {
            $sql = "UPDATE datos_proceso
                    SET contenido='$contenido'
                    WHERE id_solicitud='$idSolicitud' AND proceso='$proceso'";
        } else {
            $sql = "INSERT INTO datos_proceso(id_solicitud,proceso,contenido)
                    VALUES('$idSolicitud','$proceso','$contenido')";
        }

        return mysqli_query($this->conexion, $sql);
    }

    // [id, id_solicitud, proceso, contenido, fecha] --> del proceso en específico
    public function obtenerContenido($idSolicitud, $proceso)
    {
        $sql = "SELECT * FROM datos_proceso
            WHERE id_solicitud='$idSolicitud' AND proceso='$proceso'";

        $resultado = mysqli_query($this->conexion, $sql);

        return mysqli_fetch_assoc($resultado);
    }

    // [id, id_solicitud, proceso, contenido, fecha] --> pero del grupo de procesos que tienen contenido
    public function obtenerDatosSolicitud($idSolicitud)
    {
        $sql = "SELECT * FROM datos_proceso 
                WHERE id_solicitud='$idSolicitud'
                ORDER BY proceso";

        $resultado = mysqli_query($this->conexion, $sql);

        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    }

    // solicitudes = s, datos_proceso = dp, procesos = p --> grupo de procesos que tienen contenido y son revisables
    // [dp.id, dp.id_solicitud, dp.proceso, dp.contenido, dp.fecha]
    // [p.nombre AS nombre_proceso]
    public function obtenerDatosRevisables($idSolicitud)
    {
        $sql = "SELECT dp.*, p.nombre FROM datos_proceso dp
                INNER JOIN solicitudes s
                ON dp.id_solicitud=s.id
                INNER JOIN procesos p
                ON dp.proceso=p.proceso
                AND s.flujo=p.flujo
                WHERE dp.id_solicitud='$idSolicitud'
                AND p.revisable=1";

        $resultado = mysqli_query($this->conexion, $sql);

        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    }

    // solicitudes = s, datos_proceso = dp, procesos = p -- > grupo de procesos que tienen contenido y generan resultado
    // [dp.id, dp.id_solicitud, dp.proceso, dp.contenido, dp.fecha]
    // [p.nombre AS nombre_proceso]
    public function obtenerResultados($idSolicitud)
    {
        $sql = "SELECT dp.*, p.nombre FROM datos_proceso dp
                INNER JOIN solicitudes s
                ON dp.id_solicitud=s.id
                INNER JOIN procesos p
                ON dp.proceso=p.proceso
                AND s.flujo=p.flujo
                WHERE dp.id_solicitud='$idSolicitud'
                AND p.genera_resultado=1";

        $resultado = mysqli_query($this->conexion, $sql);

        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    }

    // flujos[id, flujo, nombre, descripcion]
    public function listarFlujos()
    {
        $sql = "SELECT * FROM flujos";
        $resultado = mysqli_query($this->conexion, $sql);

        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    }

    // historial completo por usuario
    public function obtenerHistorialUsuario($usuario)
    {
        $sql = "SELECT
                h.*,
                s.flujo,
                pd.nombre AS nombre_proceso,
                po.nombre AS nombre_proceso_origen

            FROM historial h

            INNER JOIN solicitudes s
            ON h.id_solicitud=s.id

            LEFT JOIN procesos pd
            ON h.proceso=pd.proceso
            AND s.flujo=pd.flujo

            LEFT JOIN procesos po
            ON h.proceso_origen=po.proceso
            AND s.flujo=po.flujo

            WHERE h.usuario='$usuario'

            ORDER BY h.fecha DESC";

        $resultado = mysqli_query($this->conexion, $sql);

        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    }
    // seguimiento por procesos completo por usuario
    public function obtenerSeguimientoUsuario($usuario)
    {
        $sql = "SELECT
                sp.*,
                p.nombre AS nombre_proceso

            FROM seguimiento_proceso sp

            INNER JOIN procesos p
            ON sp.flujo=p.flujo
            AND sp.proceso=p.proceso

            WHERE sp.usuario='$usuario'

            ORDER BY sp.fecha_inicio DESC";

        $resultado = mysqli_query($this->conexion, $sql);

        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    }

    public function obtenerSeguimiento($idSolicitud)
    {
        $sql = "SELECT
                sp.*,
                p.nombre AS nombre_proceso

            FROM seguimiento_proceso sp

            INNER JOIN procesos p
            ON sp.flujo=p.flujo
            AND sp.proceso=p.proceso

            WHERE sp.id_solicitud='$idSolicitud'

            ORDER BY sp.id";

        $resultado = mysqli_query($this->conexion, $sql);

        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    }

    public function obtenerSolicitudesParticipadas($usuario)
    {
        $sql = "SELECT DISTINCT
                s.id,
                s.flujo,
                f.nombre AS nombre_flujo

            FROM solicitudes s

            INNER JOIN historial h
            ON s.id = h.id_solicitud

            INNER JOIN flujos f
            ON s.flujo = f.flujo

            WHERE h.usuario = '$usuario'

            ORDER BY s.id DESC";

        $resultado = mysqli_query($this->conexion, $sql);

        return mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    }
}
