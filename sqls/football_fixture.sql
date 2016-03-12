-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 12, 2016 at 10:09 PM
-- Server version: 5.5.47-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `football_fixture`
--

-- --------------------------------------------------------

--
-- Table structure for table `fixtures`
--

CREATE TABLE IF NOT EXISTS `fixtures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `l_id` int(4) DEFAULT NULL,
  `home_id` int(5) DEFAULT NULL,
  `away_id` int(5) DEFAULT NULL,
  `match_date` datetime DEFAULT NULL,
  `goals_home_team` int(2) NOT NULL,
  `goals_away_team` int(2) NOT NULL,
  `status` enum('FINISHED','TIMED','IN_PLAY') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_unique` (`l_id`,`home_id`,`away_id`) COMMENT 'idx_unique'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1447 ;

-- --------------------------------------------------------

--
-- Table structure for table `league`
--

CREATE TABLE IF NOT EXISTS `league` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) DEFAULT NULL,
  `logo` varchar(700) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `team_count` int(4) DEFAULT NULL,
  `match_days` int(4) DEFAULT NULL,
  `match_day` int(4) DEFAULT NULL,
  `year` int(6) DEFAULT NULL,
  `last_updated` date DEFAULT NULL,
  `api_id` int(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `league_table`
--

CREATE TABLE IF NOT EXISTS `league_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `l_id` int(4) DEFAULT NULL,
  `t_id` int(5) DEFAULT NULL,
  `played` int(4) DEFAULT NULL,
  `wins` int(4) DEFAULT NULL,
  `draws` int(4) DEFAULT NULL,
  `losses` int(4) DEFAULT NULL,
  `goal_for` int(4) DEFAULT NULL,
  `goal_against` int(4) DEFAULT NULL,
  `goal_diff` int(4) DEFAULT NULL,
  `points` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_table` (`l_id`,`t_id`) COMMENT 'xxx'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=119 ;

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE IF NOT EXISTS `teams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `short_name` varchar(50) DEFAULT NULL,
  `code` varchar(255) NOT NULL,
  `logo` varchar(500) DEFAULT NULL,
  `league_id` int(4) DEFAULT NULL,
  `position` int(4) DEFAULT NULL,
  `api_id` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=115 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
