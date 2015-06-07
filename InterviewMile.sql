-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 08, 2015 at 01:48 AM
-- Server version: 5.5.43-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `InterviewMile`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE IF NOT EXISTS `answers` (
  `answerId` int(10) NOT NULL AUTO_INCREMENT,
  `questionId` int(10) NOT NULL,
  `answer` varchar(5000) DEFAULT NULL,
  `owner` int(10) NOT NULL,
  PRIMARY KEY (`answerId`),
  KEY `questionId` (`questionId`),
  KEY `owner` (`owner`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;



-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `categoryId` int(10) NOT NULL AUTO_INCREMENT,
  `parentCategoryId` int(10) NOT NULL DEFAULT '0',
  `category` varchar(100) NOT NULL,
  `owner` int(10) NOT NULL,
  PRIMARY KEY (`categoryId`),
  UNIQUE KEY `parentId_2` (`parentCategoryId`,`category`),
  KEY `parentId` (`parentCategoryId`),
  KEY `owner` (`owner`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;


-- --------------------------------------------------------

--
-- Table structure for table `mcqChoices`
--

CREATE TABLE IF NOT EXISTS `mcqChoices` (
  `optionId` int(10) NOT NULL AUTO_INCREMENT,
  `questionId` int(10) NOT NULL,
  `choice` varchar(500) NOT NULL,
  `isCorrect` tinyint(1) NOT NULL DEFAULT '0',
  `owner` int(10) NOT NULL,
  PRIMARY KEY (`optionId`),
  KEY `questionId` (`questionId`),
  KEY `owner` (`owner`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

-- --------------------------------------------------------

--
-- Table structure for table `questionCategory`
--

CREATE TABLE IF NOT EXISTS `questionCategory` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `questionId` int(10) NOT NULL,
  `categoryId` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `questionId` (`questionId`),
  KEY `categoryId` (`categoryId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;


-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `questionId` int(10) NOT NULL AUTO_INCREMENT,
  `isMCQ` tinyint(1) NOT NULL DEFAULT '0',
  `title` varchar(500) NOT NULL,
  `description` varchar(5000) DEFAULT NULL,
  `owner` int(10) NOT NULL,
  PRIMARY KEY (`questionId`),
  KEY `owner` (`owner`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `userId` int(10) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`userId`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `email`) VALUES
(1, 'admin@interviewmiles.com');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`questionId`) REFERENCES `questions` (`questionId`),
  ADD CONSTRAINT `answers_ibfk_2` FOREIGN KEY (`owner`) REFERENCES `users` (`userId`);

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `users` (`userId`);

--
-- Constraints for table `mcqChoices`
--
ALTER TABLE `mcqChoices`
  ADD CONSTRAINT `mcqChoices_ibfk_1` FOREIGN KEY (`questionId`) REFERENCES `questions` (`questionId`),
  ADD CONSTRAINT `mcqChoices_ibfk_2` FOREIGN KEY (`owner`) REFERENCES `users` (`userId`);

--
-- Constraints for table `questionCategory`
--
ALTER TABLE `questionCategory`
  ADD CONSTRAINT `questionCategory_ibfk_1` FOREIGN KEY (`questionId`) REFERENCES `questions` (`questionId`),
  ADD CONSTRAINT `questionCategory_ibfk_2` FOREIGN KEY (`categoryId`) REFERENCES `categories` (`categoryId`);

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_2` FOREIGN KEY (`owner`) REFERENCES `users` (`userId`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
