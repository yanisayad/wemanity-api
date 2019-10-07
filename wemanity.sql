# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Hôte: 127.0.0.1 (MySQL 5.5.5-10.1.37-MariaDB)
# Base de données: wemanity
# Temps de génération: 2019-09-26 14:10:44 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

# Affichage de la table city
# ------------------------------------------------------------

DROP TABLE IF EXISTS `city`;

CREATE TABLE `city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department` varchar(3) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `zipcode` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `city` WRITE;
/*!40000 ALTER TABLE `city` DISABLE KEYS */;

INSERT INTO `city` (`id`, `department`, `name`, `zipcode`)
VALUES
	(1,'01','OZAN','01190'),
	(2,'01','CORMORANCHE-SUR-SAONE','01290'),
	(3,'01','PLAGNE','01130'),
	(4,'01','TOSSIAT','01250'),
	(5,'01','POUILLAT','01250'),
	(6,'01','TORCIEU','01230'),
	(7,'01','REPLONGES','01620'),
	(8,'01','CORCELLES','01110'),
	(9,'01','PERON','01630'),
	(10,'01','RELEVANT','01990');

/*!40000 ALTER TABLE `city` ENABLE KEYS */;
UNLOCK TABLES;


# Affichage de la table cinema
# ------------------------------------------------------------

DROP TABLE IF EXISTS `cinema`;

CREATE TABLE `cinema` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `street` varchar(45) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `city_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cinema_city_idx` (`city_id`),
  CONSTRAINT `cinema_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `cinema` WRITE;
/*!40000 ALTER TABLE `cinema` DISABLE KEYS */;

INSERT INTO `cinema` (`id`, `street`, `name`, `phone`, `city_id`)
VALUES
	(1,'3 rue Cusino','UGC','0101010101',1),
	(2,'5 rue Faubourg','UGC','0202020202',1),
	(3,'86 avenue Saint Honoré','GAUMONT ','0303030303',2),
	(4,'75 rue du Berger','MEGARAMA','0404040404',3);

/*!40000 ALTER TABLE `cinema` ENABLE KEYS */;
UNLOCK TABLES;

# Affichage de la table movie
# ------------------------------------------------------------

DROP TABLE IF EXISTS `movie`;

CREATE TABLE `movie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `cinema_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_movie_cinema1_idx` (`cinema_id`),
  CONSTRAINT `movie_ibfk_1` FOREIGN KEY (`cinema_id`) REFERENCES `cinema` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `movie` WRITE;
/*!40000 ALTER TABLE `movie` DISABLE KEYS */;

INSERT INTO `movie` (`id`, `name`, `start`, `end`, `cinema_id`)
VALUES
	(1,'Pirates des caraïbes','2019-06-03 20:30:00','2019-06-03 22:30:00',1),
	(2,'Les Chtis','2019-06-03 20:30:00','2019-06-03 22:30:00',1),
	(3,'Les Bronzés','2019-06-03 20:30:00','2019-06-03 22:30:00',1),
	(4,'La mémoire dans la peau','2019-06-03 20:30:00','2019-06-03 22:30:00',2);

/*!40000 ALTER TABLE `movie` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
