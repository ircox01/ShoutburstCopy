-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 04, 2014 at 01:14 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `voicesolution`
--

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

DROP TABLE IF EXISTS `companies`;
CREATE TABLE IF NOT EXISTS `companies` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `status` tinyint(3) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `status`) VALUES(1, 'default', 1);

-- --------------------------------------------------------

--
-- Table structure for table `contact_details`
--

DROP TABLE IF EXISTS `contact_details`;
CREATE TABLE IF NOT EXISTS `contact_details` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `number` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `number` (`number`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `recordings`
--

DROP TABLE IF EXISTS `recordings`;
CREATE TABLE IF NOT EXISTS `recordings` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `routing_plan` varchar(250) NOT NULL,
  `cli` varchar(250) NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `record_time` varchar(15) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `recording_emails`
--

DROP TABLE IF EXISTS `recording_emails`;
CREATE TABLE IF NOT EXISTS `recording_emails` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `recording_id` bigint(20) NOT NULL,
  `email_adds` varchar(500) NOT NULL,
  `email_header` varchar(250) NOT NULL,
  `email_message` text NOT NULL,
  `date_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
-- --------------------------------------------------------

--
-- Table structure for table `scraped_recordings`
--

DROP TABLE IF EXISTS `scraped_recordings`;
CREATE TABLE IF NOT EXISTS `scraped_recordings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `company_id` bigint(20) NOT NULL,
  `cli` varchar(100) NOT NULL,
  `routing_plan` varchar(100) NOT NULL,
  `record_time` varchar(20) NOT NULL,
  `duration` varchar(50) NOT NULL,
  `size` varchar(50) NOT NULL,
  `status` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(250) NOT NULL,
  `contact_number` varchar(250) DEFAULT NULL,
  `password` varchar(250) NOT NULL,
  `call_login_pw` varchar(150) NOT NULL,
  `company_id` bigint(20) DEFAULT NULL,
  `is_admin` tinyint(3) NOT NULL DEFAULT '0',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(3) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `company_id` (`company_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `contact_number`, `password`, `call_login_pw`, `company_id`, `is_admin`, `date_created`, `date_modified`, `status`) VALUES(1, 'admin', '123123', '61f7cf7b994187e769cd59b43f7fb6ba616a26a5', 'admin', 1, 1, '2014-01-30 22:06:13', '2013-10-16 16:00:00', 1);
