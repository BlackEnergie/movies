/*
SQLyog Ultimate v12.5.1 (64 bit)
MySQL - 10.1.30-MariaDB : Database - movies
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `actor` */

CREATE TABLE `actor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_447556F95E237E06` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6551 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `director` */

CREATE TABLE `director` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1E90D3F05E237E06` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=1499 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `genre` */

CREATE TABLE `genre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

/*Table structure for table `movie` */

CREATE TABLE `movie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `released` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `runtime` int(11) NOT NULL,
  `genre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `plot` varchar(5000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `awards` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `poster` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `imdb_id` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `imdb_rating` decimal(2,1) NOT NULL,
  `imdb_votes` int(11) NOT NULL,
  `box_office` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `director_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1D5EF26F53B538EB` (`imdb_id`),
  KEY `IDX_1D5EF26F899FB366` (`director_id`),
  CONSTRAINT `FK_1D5EF26F899FB366` FOREIGN KEY (`director_id`) REFERENCES `director` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2462 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `movie_actor` */

CREATE TABLE `movie_actor` (
  `movie_id` int(11) NOT NULL,
  `actor_id` int(11) NOT NULL,
  PRIMARY KEY (`movie_id`,`actor_id`),
  KEY `IDX_3A374C658F93B6FC` (`movie_id`),
  KEY `IDX_3A374C6510DAF24A` (`actor_id`),
  CONSTRAINT `FK_3A374C6510DAF24A` FOREIGN KEY (`actor_id`) REFERENCES `actor` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_3A374C658F93B6FC` FOREIGN KEY (`movie_id`) REFERENCES `movie` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `movie_genre` */

CREATE TABLE `movie_genre` (
  `id_genre` int(11) NOT NULL,
  `id_movie` int(11) NOT NULL,
  PRIMARY KEY (`id_genre`,`id_movie`),
  KEY `id_movie` (`id_movie`),
  CONSTRAINT `movie_genre_ibfk_1` FOREIGN KEY (`id_genre`) REFERENCES `genre` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `movie_genre_ibfk_2` FOREIGN KEY (`id_movie`) REFERENCES `movie` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `selection` */

CREATE TABLE `selection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `movie_id` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `saved_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `IDX_96A50CD7A76ED395` (`user_id`),
  KEY `IDX_96A50CD78F93B6FC` (`movie_id`),
  CONSTRAINT `selection_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `selection_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `movie` (`imdb_id`)
) ENGINE=InnoDB AUTO_INCREMENT=246 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `selection_actor` */

CREATE TABLE `selection_actor` (
  `id_user` int(11) NOT NULL,
  `id_actor` int(11) NOT NULL,
  `nb` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_user`,`id_actor`),
  KEY `id_actor` (`id_actor`),
  CONSTRAINT `selection_actor_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`),
  CONSTRAINT `selection_actor_ibfk_2` FOREIGN KEY (`id_actor`) REFERENCES `actor` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `selection_director` */

CREATE TABLE `selection_director` (
  `id_user` int(11) NOT NULL,
  `id_director` int(11) NOT NULL,
  `nb` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_user`,`id_director`),
  KEY `id_director` (`id_director`),
  CONSTRAINT `selection_director_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`),
  CONSTRAINT `selection_director_ibfk_2` FOREIGN KEY (`id_director`) REFERENCES `director` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `selection_genre` */

CREATE TABLE `selection_genre` (
  `id_user` int(11) NOT NULL,
  `id_genre` int(11) NOT NULL,
  `nb` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_user`,`id_genre`),
  KEY `id_genre` (`id_genre`),
  CONSTRAINT `selection_genre_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`),
  CONSTRAINT `selection_genre_ibfk_2` FOREIGN KEY (`id_genre`) REFERENCES `genre` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `user` */

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `registration` datetime NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci COMMENT '(DC2Type:array)',
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
