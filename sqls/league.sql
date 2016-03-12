-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 12, 2016 at 10:32 PM
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

--
-- Dumping data for table `league`
--

INSERT INTO `league` (`id`, `label`, `logo`, `country`, `team_count`, `match_days`, `match_day`, `year`, `last_updated`, `api_id`) VALUES
(1, 'Premier League', 'xyz', 'England', 20, 38, 29, 2015, '2016-03-06', 398),
(2, 'Bundesliga', 'xyz', 'Germany', 18, 34, 25, 2015, '2016-03-06', 394),
(3, 'Laliga', 'xyz', 'Espain', 20, 38, 28, 2015, '2016-03-06', 399),
(4, 'Champions League', 'xyz', 'All', 32, 10, 7, 2015, '2016-03-06', 405),
(5, 'European Championships France 2016', 'xyz', 'France', 24, 6, 1, 2016, '2016-03-06', 424);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
