
-- MySQL dump 10.13  Distrib 5.7.32, for Linux (x86_64)
--
-- Host: mysql.info.unicaen.fr    Database: 21403460_bd
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.44-MariaDB-0+deb9u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Utilisateur`
--

DROP TABLE IF EXISTS `Utilisateur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Utilisateur` (
  `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `mot_de_passe` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `tel` varchar(255) DEFAULT NULL,
  `mail` varchar(255) DEFAULT NULL,
  `date_naissance` varchar(255) DEFAULT NULL,
  `film_favori` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_utilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Utilisateur`
--

LOCK TABLES `Utilisateur` WRITE;
/*!40000 ALTER TABLE `Utilisateur` DISABLE KEYS */;
INSERT INTO `Utilisateur` VALUES (1,'vanier','$2y$10$7iVLbtmdtb.U0Om/AwD3g./kJgLDfe41f3M4yJHVqxbtavwxyVdtW','utilisateur','0606060606','vanier@gmail.com','1990-12-31','Le voyage de Chihiro'),(2,'lecarpentier','$2y$10$mDodcigBYQP7eDxVyZtQ8.vcP/6SbW9x39IcV9sO0W2eWgIp5vwvy','utilisateur','0606060606','lecarpentier@gmail.com','1990-12-31','Le voyage de Chihiro');
/*!40000 ALTER TABLE `Utilisateur` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ProduitGhibli`
--

DROP TABLE IF EXISTS `ProduitGhibli`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ProduitGhibli` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int(11) DEFAULT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `lien_image` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `creation_date` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProduitGhibli`
--

LOCK TABLES `ProduitGhibli` WRITE;
/*!40000 ALTER TABLE `ProduitGhibli` DISABLE KEYS */;
INSERT INTO `ProduitGhibli` VALUES (1,1,'Peluche Totoro!','https://s1.thcdn.com/productimg/960/960/11117383-1834292479519770.jpg','peluche','2010-05-06'),(2,1,'DVD le voyage de Chihiro','https://www.nautiljon.com/images/dvd/00/64/mini/le_voyage_de_chihiro_-_dvd_46.jpg?11465315111','DVD','2002-05-10'),(3,2,'Mug ghibli','https://c49d16a6c82563251344-1ab5a5b00ecdd96a368a8d8d17482920.ssl.cf2.rackcdn.com/images/TS_Ghibli_Gang_Black_Handle_Mug_9_99-617-662.jpg','mug','2015-03-09'),(4,2,'Kigurumi no face','https://www.4kigurumi.com/image/cache/data/kigurumi/D010/no-face-man-kigurumi-costumes-600x900.jpg','kigurumi','2014-03-17');
/*!40000 ALTER TABLE `ProduitGhibli` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-12-06  1:43:31

