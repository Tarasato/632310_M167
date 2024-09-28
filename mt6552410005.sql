-- MySQL dump 10.13  Distrib 8.0.33, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: sautrip_db
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `myprofile_tb`
--

DROP TABLE IF EXISTS `myprofile_tb`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `myprofile_tb` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `myprofile_tb`
--

/*!40000 ALTER TABLE `myprofile_tb` DISABLE KEYS */;
INSERT INTO `myprofile_tb` VALUES (1,'สมชาย','password123','somchai@example.com','2024-09-28 08:26:15'),(2,'สมหญิง','password456','somying@example.com','2024-09-28 08:26:15'),(3,'ก้องเกียรติ','password789','kongkiat@example.com','2024-09-28 08:26:15'),(4,'กรรชัย','กรรชัย1234','Kanchai@example.com','2024-09-28 08:33:45');
/*!40000 ALTER TABLE `myprofile_tb` ENABLE KEYS */;

--
-- Table structure for table `trip_tb`
--

DROP TABLE IF EXISTS `trip_tb`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `trip_tb` (
  `trip_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `location_name` varchar(100) NOT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`trip_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `trip_tb_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `myprofile_tb` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trip_tb`
--

/*!40000 ALTER TABLE `trip_tb` DISABLE KEYS */;
INSERT INTO `trip_tb` VALUES (2,2,'2024-08-15','2024-08-18','เชียงใหม่',18.78830000,98.98530000,2000.00,'2024-09-28 08:26:35'),(3,3,'2024-07-10','2024-07-15','ภูเก็ต',7.88040000,98.39230000,3000.00,'2024-09-28 08:26:35'),(17,4,'2024-09-01','2024-09-05','บ้าน',13.64723450,100.46184230,100.00,'2024-09-28 08:54:57'),(19,4,'2024-09-01','2024-12-31','บ้านเรือน',13.64723450,100.46184230,150.00,'2024-09-28 09:38:03'),(20,4,'2024-09-01','2024-12-13','บ้านเรือนไทย',13.64723450,100.46184230,200.00,'2024-09-28 09:18:46'),(21,4,'2024-09-01','2024-12-08','บ้านทรายทอง',13.64723450,100.46184230,300.00,'2024-09-28 09:38:03'),(22,4,'2024-09-01','2024-09-05','น้ำตกเอราวัณ',14.37370000,99.14450000,2500.50,'2024-09-28 09:47:34');
/*!40000 ALTER TABLE `trip_tb` ENABLE KEYS */;

--
-- Dumping routines for database 'sautrip_db'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-09-28 16:50:55
