-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Host: sql308.mzzhost.com
-- Generation Time: Jan 18, 2015 at 12:04 PM
-- Server version: 5.6.21-70.1
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mzzho_15144940_tatarcon`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE IF NOT EXISTS `chat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usr1` int(11) NOT NULL,
  `usr2` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`id`, `usr1`, `usr2`) VALUES
(1, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creator` int(11) NOT NULL,
  `time` double NOT NULL,
  `chat` int(11) NOT NULL,
  `kabara` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `creator`, `time`, `chat`, `kabara`) VALUES
(1, 2, 1406400987, 1, 'hello world this is a test'),
(2, 1, 1406401012, 1, 'yes this is a test too!'),
(3, 1, 1406401013, 1, 'yes this is a test too!'),
(4, 2, 1406401043, 1, 'looks good on big screens'),
(5, 2, 1406401151, 1, 'you there'),
(6, 2, 1406401154, 1, 'you there'),
(7, 1, 1406401172, 1, 'shit'),
(8, 1, 1406401213, 1, 'it sucks on small screens'),
(9, 2, 1406401240, 1, 'it would get better tomorrow code it again'),
(10, 1, 1406401256, 1, 'ok bye'),
(11, 2, 1406401286, 1, 'ok bye'),
(12, 1, 1406401937, 1, 'dude this is shit on mobile device I have to make it better'),
(13, 1, 1406401959, 1, 'it hides the messafes'),
(14, 1, 1406401974, 1, 'it hides the messafes'),
(15, 1, 1406402003, 1, 'the spam technique is perfect'),
(16, 1, 1406402006, 1, 'the spam technique is perfect'),
(17, 1, 1406402006, 1, 'the spam technique is perfect'),
(18, 1, 1406402006, 1, 'the spam technique is perfect'),
(19, 1, 1406402012, 1, 'the spam technique is perfect'),
(20, 1, 1406402018, 1, 'the spam technique is perfecto'),
(21, 1, 1406402021, 1, 'the spam technique is perfecto'),
(22, 1, 1406402021, 1, 'the spam technique is perfecto'),
(23, 1, 1406402062, 1, 'cjcicj'),
(24, 1, 1406404884, 1, 'hey'),
(25, 1, 1406404911, 1, 'lol');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(90) NOT NULL,
  `dp` varchar(300) NOT NULL DEFAULT 'img/defdp.png',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user`, `dp`) VALUES
(1, 'muneeb khan', 'img/prof/cat2.png'),
(2, 'amber khan', 'img/defdp.png');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
