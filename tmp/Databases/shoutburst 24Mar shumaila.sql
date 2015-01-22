/*
SQLyog Enterprise - MySQL GUI v7.13 
MySQL - 5.6.12-log : Database - shoutburst
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`shoutburst` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `shoutburst`;

/*Table structure for table `access_levels` */

DROP TABLE IF EXISTS `access_levels`;

CREATE TABLE `access_levels` (
  `acc_id` int(11) NOT NULL AUTO_INCREMENT,
  `acc_title` varchar(20) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`acc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `access_levels` */

insert  into `access_levels`(`acc_id`,`acc_title`) values (1,'Super Admin'),(2,'Company Admin'),(3,'Company Manager'),(4,'Company Agent');

/*Table structure for table `campaigns` */

DROP TABLE IF EXISTS `campaigns`;

CREATE TABLE `campaigns` (
  `camp_id` int(11) NOT NULL AUTO_INCREMENT,
  `camp_name` varchar(255) DEFAULT NULL,
  `created` date DEFAULT NULL,
  `last_change` date DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`camp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `campaigns` */

insert  into `campaigns`(`camp_id`,`camp_name`,`created`,`last_change`,`status`) values (1,'Campaign 1','2014-03-11',NULL,1),(2,'Campaign 2','2014-03-11',NULL,1),(3,'Campaign 3','2014-03-11',NULL,1),(4,'HGJHGHJ','2014-03-11',NULL,1),(5,'2',NULL,NULL,1),(6,'4',NULL,NULL,1),(7,'2',NULL,NULL,1),(8,'4',NULL,NULL,1);

/*Table structure for table `companies` */

DROP TABLE IF EXISTS `companies`;

CREATE TABLE `companies` (
  `comp_id` int(11) NOT NULL AUTO_INCREMENT,
  `comp_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `created` date DEFAULT NULL,
  `last_change` date DEFAULT NULL,
  `logo` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `platform` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `transcribe` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`comp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `companies` */

insert  into `companies`(`comp_id`,`comp_name`,`created`,`last_change`,`logo`,`platform`,`transcribe`,`status`) values (1,'SHOUTBURST',NULL,NULL,NULL,NULL,0,1),(2,'NexDegree',NULL,NULL,NULL,NULL,0,1),(3,'test','2014-03-11',NULL,'1Desert21.jpg','sdfdf',1,1),(4,'test','2014-03-11',NULL,'1Desert22.jpg','sdfdf',1,1),(5,'test','2014-03-11',NULL,'1Desert23.jpg','sdfdf',1,1),(6,'test','2014-03-11',NULL,'1Desert24.jpg','sdfdf',1,1),(7,'test','2014-03-11',NULL,'1Desert25.jpg','sdfdf',1,1);

/*Table structure for table `company_campaings` */

DROP TABLE IF EXISTS `company_campaings`;

CREATE TABLE `company_campaings` (
  `comp_id` int(11) NOT NULL,
  `camp_id` int(11) NOT NULL,
  PRIMARY KEY (`comp_id`,`camp_id`),
  KEY `camp_id` (`camp_id`),
  CONSTRAINT `company_campaings_ibfk_1` FOREIGN KEY (`camp_id`) REFERENCES `campaigns` (`camp_id`),
  CONSTRAINT `company_campaings_ibfk_2` FOREIGN KEY (`comp_id`) REFERENCES `companies` (`comp_id`),
  CONSTRAINT `company_campaings_ibfk_3` FOREIGN KEY (`camp_id`) REFERENCES `campaigns` (`camp_id`),
  CONSTRAINT `company_campaings_ibfk_4` FOREIGN KEY (`comp_id`) REFERENCES `companies` (`comp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `company_campaings` */

insert  into `company_campaings`(`comp_id`,`camp_id`) values (2,1),(2,2),(2,3),(6,5),(6,6),(7,7),(7,8);

/*Table structure for table `dashboards` */

DROP TABLE IF EXISTS `dashboards`;

CREATE TABLE `dashboards` (
  `db_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `comp_id` int(11) NOT NULL,
  `acc_id` int(11) NOT NULL,
  `db_type` varchar(20) DEFAULT NULL,
  `db_query` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`db_id`,`user_id`,`comp_id`,`acc_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

/*Data for the table `dashboards` */

insert  into `dashboards`(`db_id`,`user_id`,`comp_id`,`acc_id`,`db_type`,`db_query`,`created`,`modified`) values (1,17,2,4,'default','SELECT c.camp_name, u.user_id, u.full_name, s.total_score \r\n								 FROM surveys s\r\n								 JOIN campaigns c ON s.camp_id = c.camp_id\r\n								 JOIN users u ON s.user_id = u.user_id\r\n								 WHERE s.user_id = 17 AND s.total_score > 0\r\n								 ORDER BY c.camp_name',NULL,NULL),(2,18,2,4,'default','SELECT c.camp_name, u.user_id, u.full_name, s.total_score \r\n						 FROM surveys s\r\n						 JOIN campaigns c ON s.camp_id = c.camp_id\r\n						 JOIN users u ON s.user_id = u.user_id\r\n						 WHERE s.user_id IN (18,20) AND s.total_score > 0\r\n						 ORDER BY c.camp_name',NULL,NULL),(3,19,2,4,'default','SELECT c.camp_name, u.user_id, u.full_name, s.total_score \r\n								 FROM surveys s\r\n								 JOIN campaigns c ON s.camp_id = c.camp_id\r\n								 JOIN users u ON s.user_id = u.user_id\r\n								 WHERE s.user_id = 19 AND s.total_score > 0\r\n								 ORDER BY c.camp_name',NULL,NULL),(4,20,2,4,'default','SELECT c.camp_name, u.user_id, u.full_name, s.total_score \r\n								 FROM surveys s\r\n								 JOIN campaigns c ON s.camp_id = c.camp_id\r\n								 JOIN users u ON s.user_id = u.user_id\r\n								 WHERE s.user_id = 20 AND s.total_score > 0\r\n								 ORDER BY c.camp_name',NULL,NULL),(5,26,2,3,'default','SELECT c.camp_name, u.user_id, u.full_name, s.total_score \r\n								 FROM surveys s\r\n								 JOIN campaigns c ON s.camp_id = c.camp_id\r\n								 JOIN users u ON s.user_id = u.user_id\r\n								 WHERE s.user_id = 26 AND s.total_score > 0\r\n								 ORDER BY c.camp_name',NULL,NULL),(6,26,2,4,'default','SELECT c.camp_name, u.user_id, u.full_name, s.total_score \r\n								 FROM surveys s\r\n								 JOIN campaigns c ON s.camp_id = c.camp_id\r\n								 JOIN users u ON s.user_id = u.user_id\r\n								 WHERE s.user_id = 26 AND s.total_score > 0\r\n								 ORDER BY c.camp_name',NULL,NULL),(7,1,1,3,'default','SELECT c.camp_name, u.user_id, u.full_name, s.total_score\r\n							FROM surveys s\r\n							JOIN campaigns c ON s.camp_id = c.camp_id\r\n							JOIN users u ON s.user_id = u.user_id\r\n							WHERE s.user_id =  AND s.total_score > 0\r\n							ORDER BY c.camp_name',NULL,NULL),(8,1,1,4,'default','SELECT c.camp_name, u.user_id, u.full_name, s.total_score\r\n							FROM surveys s\r\n							JOIN campaigns c ON s.camp_id = c.camp_id\r\n							JOIN users u ON s.user_id = u.user_id\r\n							WHERE s.user_id =  AND s.total_score > 0\r\n							ORDER BY c.camp_name',NULL,NULL),(9,19,1,3,'default','SELECT c.camp_name, u.user_id, u.full_name, s.total_score\r\n							FROM surveys s\r\n							JOIN campaigns c ON s.camp_id = c.camp_id\r\n							JOIN users u ON s.user_id = u.user_id\r\n							WHERE s.user_id =  AND s.total_score > 0\r\n							ORDER BY c.camp_name',NULL,NULL),(10,19,1,4,'default','SELECT c.camp_name, u.user_id, u.full_name, s.total_score\r\n							FROM surveys s\r\n							JOIN campaigns c ON s.camp_id = c.camp_id\r\n							JOIN users u ON s.user_id = u.user_id\r\n							WHERE s.user_id =  AND s.total_score > 0\r\n							ORDER BY c.camp_name',NULL,NULL),(11,28,1,3,'default','SELECT c.camp_name, u.user_id, u.full_name, s.total_score \r\n											 FROM surveys s\r\n											 JOIN campaigns c ON s.camp_id = c.camp_id\r\n											 JOIN users u ON s.user_id = u.user_id\r\n											 WHERE s.user_id = 28 AND s.total_score > 0\r\n											 ORDER BY c.camp_name',NULL,NULL),(12,28,1,4,'default','SELECT c.camp_name, u.user_id, u.full_name, s.total_score \r\n											 FROM surveys s\r\n											 JOIN campaigns c ON s.camp_id = c.camp_id\r\n											 JOIN users u ON s.user_id = u.user_id\r\n											 WHERE s.user_id = 28 AND s.total_score > 0\r\n											 ORDER BY c.camp_name',NULL,NULL),(13,28,2,4,'default','SELECT c.camp_name, u.user_id, u.full_name, s.total_score\r\n							FROM surveys s\r\n							JOIN campaigns c ON s.camp_id = c.camp_id\r\n							JOIN users u ON s.user_id = u.user_id\r\n							WHERE s.user_id =  AND s.total_score > 0\r\n							ORDER BY c.camp_name',NULL,NULL),(14,29,2,3,'default','SELECT c.camp_name, u.user_id, u.full_name, s.total_score\r\n					    FROM surveys s\r\n					    JOIN campaigns c ON s.camp_id = c.camp_id\r\n					    JOIN users u ON s.user_id = u.user_id\r\n					    WHERE s.user_id =  AND s.total_score > 0\r\n					    ORDER BY c.camp_name',NULL,NULL),(15,31,2,3,'default','SELECT c.camp_name, u.user_id, u.full_name, s.total_score\r\n			    		FROM surveys s\r\n			    		JOIN campaigns c ON s.camp_id = c.camp_id\r\n			    		JOIN users u ON s.user_id = u.user_id\r\n			    		WHERE s.user_id = 31 AND s.total_score > 0\r\n			    		ORDER BY c.camp_name',NULL,NULL),(16,31,2,4,'default','SELECT c.camp_name, u.user_id, u.full_name, s.total_score\r\n			    		FROM surveys s\r\n			    		JOIN campaigns c ON s.camp_id = c.camp_id\r\n			    		JOIN users u ON s.user_id = u.user_id\r\n			    		WHERE s.user_id = 31 AND s.total_score > 0\r\n			    		ORDER BY c.camp_name',NULL,NULL);

/*Table structure for table `surveys` */

DROP TABLE IF EXISTS `surveys`;

CREATE TABLE `surveys` (
  `sur_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `camp_id` int(11) NOT NULL,
  `date_time` datetime DEFAULT NULL,
  `q1` int(11) DEFAULT NULL,
  `q2` int(11) DEFAULT NULL,
  `q3` int(11) DEFAULT NULL,
  `q4` int(11) DEFAULT NULL,
  `q5` int(11) DEFAULT NULL,
  `total_score` int(11) DEFAULT NULL,
  `average_score` int(11) DEFAULT NULL,
  `http_icon` varchar(255) DEFAULT NULL,
  `action` varchar(20) DEFAULT NULL,
  `audio_file` varchar(255) DEFAULT NULL,
  `ftp_path` varchar(255) DEFAULT NULL,
  `comments` text,
  `cli` varchar(20) DEFAULT NULL,
  `servicenumber` varchar(20) DEFAULT NULL,
  `plan` varchar(255) DEFAULT NULL,
  `processed` tinyint(1) NOT NULL DEFAULT '0',
  `total_answered` int(11) DEFAULT '0',
  PRIMARY KEY (`sur_id`,`user_id`,`camp_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `surveys` */

insert  into `surveys`(`sur_id`,`user_id`,`camp_id`,`date_time`,`q1`,`q2`,`q3`,`q4`,`q5`,`total_score`,`average_score`,`http_icon`,`action`,`audio_file`,`ftp_path`,`comments`,`cli`,`servicenumber`,`plan`,`processed`,`total_answered`) values (1,0,0,'2014-03-11 09:06:50',1,3,NULL,NULL,NULL,4,2,NULL,NULL,NULL,NULL,NULL,'03312027007','1','plan1',0,2),(2,18,0,'2014-03-13 14:32:19',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'03312027007','1','plan1',0,0);

/*Table structure for table `tags` */

DROP TABLE IF EXISTS `tags`;

CREATE TABLE `tags` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `camp_ids` tinytext CHARACTER SET utf8,
  `details` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `data_set` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`tag_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `tags` */

insert  into `tags`(`tag_id`,`tag_name`,`camp_ids`,`details`,`data_set`,`status`) values (1,'Tag 1','[1,2]','Details 1','Data Set 1',1),(2,'Tag 2','[\"2\",3]','Details 2','Data Set 2',1);

/*Table structure for table `tags_group` */

DROP TABLE IF EXISTS `tags_group`;

CREATE TABLE `tags_group` (
  `tg_id` int(11) NOT NULL AUTO_INCREMENT,
  `tg_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `tag_ids` text CHARACTER SET utf8,
  PRIMARY KEY (`tg_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tags_group` */

/*Table structure for table `target_setup` */

DROP TABLE IF EXISTS `target_setup`;

CREATE TABLE `target_setup` (
  `comp_id` int(11) NOT NULL,
  `survey_per_day` int(11) DEFAULT NULL,
  `avg_total_score` int(11) DEFAULT NULL,
  `incorrpletes_per_day` int(11) DEFAULT NULL,
  `nps_score` int(11) DEFAULT NULL,
  `max_per_day` int(11) DEFAULT NULL,
  `day_start_time` datetime DEFAULT NULL,
  `day_end_time` datetime DEFAULT NULL,
  PRIMARY KEY (`comp_id`),
  CONSTRAINT `target_setup_ibfk_1` FOREIGN KEY (`comp_id`) REFERENCES `companies` (`comp_id`),
  CONSTRAINT `target_setup_ibfk_2` FOREIGN KEY (`comp_id`) REFERENCES `companies` (`comp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `target_setup` */

insert  into `target_setup`(`comp_id`,`survey_per_day`,`avg_total_score`,`incorrpletes_per_day`,`nps_score`,`max_per_day`,`day_start_time`,`day_end_time`) values (3,4,4,3,5,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(4,4,4,3,5,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(5,4,4,3,5,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(6,4,4,3,5,3,'0000-00-00 00:00:00','0000-00-00 00:00:00'),(7,4,4,3,5,3,'0000-00-00 00:00:00','0000-00-00 00:00:00');

/*Table structure for table `user_companies` */

DROP TABLE IF EXISTS `user_companies`;

CREATE TABLE `user_companies` (
  `user_id` int(11) NOT NULL,
  `comp_id` int(11) NOT NULL,
  `acc_id` int(11) NOT NULL,
  `user_pin` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`,`comp_id`,`acc_id`),
  KEY `acc_id` (`acc_id`),
  KEY `comp_id` (`comp_id`),
  CONSTRAINT `user_companies_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  CONSTRAINT `user_companies_ibfk_2` FOREIGN KEY (`acc_id`) REFERENCES `access_levels` (`acc_id`),
  CONSTRAINT `user_companies_ibfk_3` FOREIGN KEY (`comp_id`) REFERENCES `companies` (`comp_id`),
  CONSTRAINT `user_companies_ibfk_4` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  CONSTRAINT `user_companies_ibfk_5` FOREIGN KEY (`acc_id`) REFERENCES `access_levels` (`acc_id`),
  CONSTRAINT `user_companies_ibfk_6` FOREIGN KEY (`comp_id`) REFERENCES `companies` (`comp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `user_companies` */

insert  into `user_companies`(`user_id`,`comp_id`,`acc_id`,`user_pin`) values (1,1,1,NULL),(2,2,2,NULL),(18,1,2,'usman'),(19,1,3,'afdsa'),(19,1,4,'afdsa'),(19,2,3,'fafaf'),(19,2,4,'fafaf'),(20,1,4,NULL),(21,1,1,NULL),(26,2,3,'fasdf'),(26,2,4,'fasdf'),(28,1,3,'qwweqw'),(28,1,4,'qwweqw'),(28,2,4,'aseerwsr'),(29,2,3,'dfasdfa'),(31,2,4,'dfafsf');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `user_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(32) CHARACTER SET utf8 DEFAULT NULL,
  `password` varchar(32) CHARACTER SET utf8 DEFAULT NULL,
  `created` date DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`user_id`,`full_name`,`user_name`,`email`,`password`,`created`,`photo`,`status`) values (1,'Muhammad Sajid','sajid','sajid@nextgeni.com','202cb962ac59075b964b07152d234b70','2014-03-04',NULL,1),(2,'Imran Moinuddin','imran','imran.moinuddin@nexdegree.com','202cb962ac59075b964b07152d234b70','2014-03-04',NULL,1),(17,'Arshad 122','arshad@nextgeni.com','arshad@ngi.com','2762c76d815b0412fdd27b64e9220393','2014-03-10','1nqN9cHYTo1dIPX7UU9468xsxdIu44Iu.jpg',1),(18,'Usman','usman','usman@ngi.com','202cb962ac59075b964b07152d234b70','2014-03-11','mWZS5Y89yx0o34WV8o64xU1k8wJL8094.jpg',1),(19,'Ali 1','aliq','ali@ngi.com','9fc58423aa0341dd75c031e1b2fabe0a','2014-03-11','yod7i5Fk7Nna6U20GZM0qm9nl94AAEnA.jpg',1),(20,'jawwad','jawwad','jawwad@ngi.com','202cb962ac59075b964b07152d234b70','2014-03-11',NULL,1),(21,'Shumaila Siddiqui','shumaila','s.siddiqui@nextgeni.com','202cb962ac59075b964b07152d234b70',NULL,NULL,1),(25,'testttt','testswe','ssdf@dsf.sd','f4082d9b0bbe22d7a19b7366c83ea1db','2014-03-12','K0FR00G3I459Z088p3qiH37Z7Lmkk5eS.jpg',1),(26,'rew','wewr','tese4t@fsf.dsf','2097a8c9f8271fa34bf8c3fe1a34b802','2014-03-12','3685W9LqE5QZO1eQEU3MyQ6hl5NHoobW.jpg',1),(27,'fad','dfa','tese4t@fsf.dsf','1a2d1e5172f03684b37573a6661596e2','2014-03-12',NULL,1),(28,'test user1','user1','user1@test.com','e10adc3949ba59abbe56e057f20f883e','2014-03-13','ZfHF1jLmUowfK7E2nJJCQjPGFaKb58Xn.jpg',1),(29,'tes','sfsdfsdf','sgs@dfs.sdd','6d5678a7dd76fb64c4d147e651c6a714','2014-03-14',NULL,1),(30,'sds','asd','sgs@dfs.sdw','fc20f3539d327290d00c4931d7622fb0','2014-03-24','',1),(31,'sdss','dsf','sgs@dsfs.sdd','f468946a4879f611bdc4ec53951b7c91','2014-03-24','',1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
