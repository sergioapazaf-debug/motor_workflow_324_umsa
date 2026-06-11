/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.14-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: usuario_db
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
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `rol` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario` (`usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES
(1,'sergio','$2y$10$8scOkwwvfV.NiPlfCpjZgujxWJNrImbqHT9sXtYm/CeipdEAcP6Ge','alumno'),
(2,'luis','$2y$10$yeukwggCO37208xIFwD0VuRkUoc8qff2rGYo.Dxztbt5RonPjsVMK','alumno'),
(3,'ana','$2y$10$tTVqiy6RGNF3zCcItwWFbOJVY7Ucf87heSAj4/u7LW5JxVfQICI2q','kardex'),
(4,'mario','$2y$10$4idpg6KX79zFbHFzX4yUleWCaSaukSi/tWlcI/IHNThKuhD2aM/8q','kardex'),
(5,'leo','$2y$10$Y6Y5Dk3hQeAnOdDcZ6wVie.HZOcyaE.oS9ZLtPbbiZ11IUzP0rM4O','tecnico'),
(6,'juan','$2y$10$ztIaTxLTYwgrL/i0CU4Wr.kQ7T4M7Iu4XoOgHSrR4cpE9aH/.GiJa','tecnico'),
(7,'carlos','$2y$10$xoIY3Si6h8uyh3i0v0UW0OcBtQrgzZoLwxjFylTtxbuMRjfJ9Vp8q','director'),
(8,'recepcionista1','$2y$10$nKThAsuXJ02qTI2SgDE7guCnH0Fna2h2hDSrjx/2m4aRgNImmDkL2','recepcionista'),
(9,'medico1','$2y$10$jo/U0m1eON/GabDYfET3Ie1WNa6aP.KdqpOg5uQOnagWWrYujntqq','medico'),
(10,'farmaceutico1','$2y$10$TfBdVQIBnKhU.FBZPIH6ru0GZZ8nO7jgNhI17M4REOlSuAy6Bsb/C','farmaceutico'),
(11,'cajero1','$2y$10$gLRC6i5KnUZFNgv3B1vJROGyqKo0ScgVyn0o5y.peFcDzc7PTLL6K','cajero');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-06-11 19:42:22
