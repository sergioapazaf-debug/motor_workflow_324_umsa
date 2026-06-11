/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.14-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: workflow2
-- ------------------------------------------------------
-- Server version	10.11.14-MariaDB-0+deb12u2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `datos_proceso`
--

DROP TABLE IF EXISTS `datos_proceso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `datos_proceso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_solicitud` int(11) DEFAULT NULL,
  `proceso` varchar(10) DEFAULT NULL,
  `contenido` text DEFAULT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `datos_proceso_ibfk_1` (`id_solicitud`),
  CONSTRAINT `datos_proceso_ibfk_1` FOREIGN KEY (`id_solicitud`) REFERENCES `solicitudes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `datos_proceso`
--

LOCK TABLES `datos_proceso` WRITE;
/*!40000 ALTER TABLE `datos_proceso` DISABLE KEYS */;
/*!40000 ALTER TABLE `datos_proceso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `flujos`
--

DROP TABLE IF EXISTS `flujos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `flujos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `flujo` varchar(10) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `flujo` (`flujo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `flujos`
--

LOCK TABLES `flujos` WRITE;
/*!40000 ALTER TABLE `flujos` DISABLE KEYS */;
INSERT INTO `flujos` VALUES
(1,'F1','Solicitud de Certificados Académicos',NULL),
(2,'F2','Solicitud de Título Académico',NULL),
(3,'F3','Atención Clínica','Workflow de atención clínica para registro, consulta médica, farmacia y pago.');
/*!40000 ALTER TABLE `flujos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `historial`
--

DROP TABLE IF EXISTS `historial`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `historial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_solicitud` int(11) DEFAULT NULL,
  `proceso_origen` varchar(10) DEFAULT NULL,
  `proceso` varchar(10) DEFAULT NULL,
  `accion` varchar(100) DEFAULT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `fecha` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `id_solicitud` (`id_solicitud`),
  CONSTRAINT `historial_ibfk_1` FOREIGN KEY (`id_solicitud`) REFERENCES `solicitudes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historial`
--

LOCK TABLES `historial` WRITE;
/*!40000 ALTER TABLE `historial` DISABLE KEYS */;
/*!40000 ALTER TABLE `historial` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `procesos`
--

DROP TABLE IF EXISTS `procesos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `procesos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `flujo` varchar(10) DEFAULT NULL,
  `proceso` varchar(10) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `rol` varchar(50) DEFAULT NULL,
  `vista` varchar(100) DEFAULT NULL,
  `tipo` char(1) DEFAULT NULL,
  `revisable` tinyint(4) DEFAULT 0,
  `genera_resultado` tinyint(4) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `fk_procesos_flujos` (`flujo`),
  CONSTRAINT `fk_procesos_flujos` FOREIGN KEY (`flujo`) REFERENCES `flujos` (`flujo`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `procesos`
--

LOCK TABLES `procesos` WRITE;
/*!40000 ALTER TABLE `procesos` DISABLE KEYS */;
INSERT INTO `procesos` VALUES
(1,'F1','P1','Información del trámite','alumno','inicio','I',0,0),
(2,'F1','P2','Subir Documentos','alumno','documentos','P',1,0),
(3,'F1','P3','Enviar Solicitud','alumno','envio','P',1,0),
(4,'F1','P4','Revisión Kardex','kardex','revision','P',0,0),
(5,'F1','P5','Decisión Kardex','kardex','decision','P',0,1),
(6,'F1','P6','Solicitud Aprobada','sistema','aprobado','F',0,0),
(7,'F1','P7','Solicitud Rechazada','sistema','rechazado','F',0,0),
(8,'F2','P1','Información del trámite','alumno','inicio','I',0,0),
(9,'F2','P2','Subir Requisitos','alumno','documentos','P',1,0),
(10,'F2','P3','Enviar Solicitud','alumno','envio','P',1,0),
(11,'F2','P4','Verificación Kardex','kardex','revision','P',1,1),
(12,'F2','P5','Revisión Dirección de Carrera','director','revision','P',0,0),
(13,'F2','P6','Decisión Final','director','decision','P',0,1),
(14,'F2','P7','Solicitud Aprobada','sistema','aprobado','F',0,0),
(15,'F2','P8','Solicitud Rechazada','sistema','rechazado','F',0,0),
(16,'F3','P1','Registro de Paciente','recepcionista','registro','I',1,0),
(17,'F3','P2','Consulta Médica','medico','consulta','P',1,1),
(18,'F3','P3','Entrega de Medicamentos','farmaceutico','farmacia','P',1,1),
(19,'F3','P4','Pago','cajero','pago','P',1,1),
(20,'F3','P5','Atención Finalizada','sistema','finalizado','F',0,0);
/*!40000 ALTER TABLE `procesos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `seguimiento_proceso`
--

DROP TABLE IF EXISTS `seguimiento_proceso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `seguimiento_proceso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_solicitud` int(11) DEFAULT NULL,
  `flujo` varchar(10) DEFAULT NULL,
  `proceso` varchar(10) DEFAULT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `fecha_inicio` datetime DEFAULT current_timestamp(),
  `fecha_fin` datetime DEFAULT NULL,
  `estado` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_solicitud` (`id_solicitud`),
  CONSTRAINT `seguimiento_proceso_ibfk_1` FOREIGN KEY (`id_solicitud`) REFERENCES `solicitudes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seguimiento_proceso`
--

LOCK TABLES `seguimiento_proceso` WRITE;
/*!40000 ALTER TABLE `seguimiento_proceso` DISABLE KEYS */;
/*!40000 ALTER TABLE `seguimiento_proceso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `solicitudes`
--

DROP TABLE IF EXISTS `solicitudes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `solicitudes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `flujo` varchar(10) DEFAULT NULL,
  `usuario_creador` varchar(50) DEFAULT NULL,
  `proceso_actual` varchar(10) DEFAULT NULL,
  `fecha_inicio` datetime DEFAULT current_timestamp(),
  `fecha_fin` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_solicitudes_flujos` (`flujo`),
  CONSTRAINT `fk_solicitudes_flujos` FOREIGN KEY (`flujo`) REFERENCES `flujos` (`flujo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `solicitudes`
--

LOCK TABLES `solicitudes` WRITE;
/*!40000 ALTER TABLE `solicitudes` DISABLE KEYS */;
/*!40000 ALTER TABLE `solicitudes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transiciones`
--

DROP TABLE IF EXISTS `transiciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `transiciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `flujo` varchar(10) DEFAULT NULL,
  `proceso_actual` varchar(10) DEFAULT NULL,
  `proceso_siguiente` varchar(10) DEFAULT NULL,
  `accion` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_transiciones_flujos` (`flujo`),
  CONSTRAINT `fk_transiciones_flujos` FOREIGN KEY (`flujo`) REFERENCES `flujos` (`flujo`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transiciones`
--

LOCK TABLES `transiciones` WRITE;
/*!40000 ALTER TABLE `transiciones` DISABLE KEYS */;
INSERT INTO `transiciones` VALUES
(1,'F1','P1','P2','Continuar'),
(2,'F1','P2','P3','Continuar'),
(3,'F1','P3','P4','Enviar'),
(4,'F1','P4','P5','Revisar'),
(5,'F1','P5','P6','Aprobar'),
(6,'F1','P5','P7','Rechazar'),
(7,'F2','P1','P2','Continuar'),
(8,'F2','P2','P3','Continuar'),
(9,'F2','P3','P4','Enviar'),
(10,'F2','P4','P5','Verificar'),
(11,'F2','P4','P8','Rechazar'),
(12,'F2','P5','P6','Finalizar revisión'),
(13,'F2','P6','P7','Aprobar'),
(14,'F2','P6','P8','Rechazar'),
(15,'F3','P1','P2','Registrar'),
(16,'F3','P2','P3','Atender'),
(17,'F3','P3','P4','Entregar medicamento'),
(18,'F3','P4','P5','Cobrar');
/*!40000 ALTER TABLE `transiciones` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-06-11 19:41:37
