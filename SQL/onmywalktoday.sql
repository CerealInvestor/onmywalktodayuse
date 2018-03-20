-- phpMyAdmin SQL Dump
-- version 4.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 24, 2015 at 03:42 AM
-- Server version: 5.5.42
-- PHP Version: 5.6.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `PUBMyContent`
--

-- --------------------------------------------------------

--
-- Table structure for table `contentFiles`
--

CREATE TABLE IF NOT EXISTS `contentFiles` (
  `fileid` int(11) NOT NULL,
  `fileName` varchar(150) NOT NULL,
  `fileSize` varchar(45) NOT NULL,
  `fileType` varchar(10) NOT NULL,
  `deleted` int(11) DEFAULT '0',
  `contentid` int(11) DEFAULT NULL,
  `userid` int(11) NOT NULL,
  `fileDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `contentList`
--

CREATE TABLE IF NOT EXISTS `contentList` (
  `contentid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `dateAdded` datetime DEFAULT NULL,
  `deleted` int(11) DEFAULT '0',
  `contentType` varchar(45) DEFAULT NULL,
  `description` text,
  `accessType` varchar(45) DEFAULT 'public',
  `published` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fileAccess`
--

CREATE TABLE IF NOT EXISTS `fileAccess` (
  `accessid` int(11) NOT NULL,
  `fileid` int(11) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `access` varchar(45) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `pageid` int(11) NOT NULL,
  `pageTitle` text,
  `pageContent` text,
  `pageName` varchar(30) NOT NULL,
  `deleted` int(11) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`pageid`, `pageTitle`, `pageContent`, `pageName`, `deleted`) VALUES
(1, 'Home', '<p>Homepage content being pulled from the database it is it i i i ii i i i</p>', 'home', 0),
(2, 'What we do', '<p>This is the what we do content</p>', 'whatwedo', 0),
(3, 'FAQ', '<p>I will try to answer as many questions as possible here on the FAQ page.</p>\r\n<p>What can I do?<br />How to edit user details?<br />What is a document lists?<br />How to add a list?<br />Editing a list?<br />Uploading files to a list?<br />How to publish a list</p>', 'faq', 0),
(4, 'Contact us', '<p>If you would like to contact us please fill out the form below.</p>\r\n<p>&nbsp;</p>', 'contact', 0),
(5, 'Privacy', '<p>Privacy content</p>', 'privacy', 0),
(6, 'Accessibility', '<p>Accessibility content</p>', 'accessibility', 0),
(7, 'Register', '<p>Enter your details in to the form below to register an account with PUBMyContent</p>', 'register', 0),
(8, 'Login', '<p>Please login below to your account</p>', 'login', 0),
(9, 'My account', '<p>Welcome to your account, see below for what you can do.</p>', 'myaccount', 0),
(10, 'Document Lists', '<p>Below you will find all the document lists you have added. You can edit or remove and add new lists from this page</p>', 'documentlist', 0),
(11, 'Gallery list', '<p>Below you will find all the gallery lists you have added. You can edit or remove and add new lists from this page</p>', 'gallerylist', 0),
(12, 'User details', '<p>Below you will find your user details, you are able to edit them from here.</p>', 'userdetails', 0);

-- --------------------------------------------------------

--
-- Table structure for table `subUsers`
--

CREATE TABLE IF NOT EXISTS `subUsers` (
  `userid` int(11) NOT NULL,
  `subUserscol` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `userid` int(11) NOT NULL,
  `userName` varchar(45) NOT NULL,
  `password` text NOT NULL,
  `firstName` varchar(45) NOT NULL,
  `lastName` varchar(45) NOT NULL,
  `dob` datetime DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `address1` varchar(80) DEFAULT NULL,
  `address2` varchar(80) DEFAULT NULL,
  `postcode` varchar(8) NOT NULL,
  `county` varchar(30) DEFAULT NULL,
  `country` varchar(30) DEFAULT NULL,
  `telephone` varchar(15) DEFAULT NULL,
  `lastOnline` datetime DEFAULT NULL,
  `userLevel` varchar(15) NOT NULL,
  `deleted` int(11) DEFAULT '0',
  `lastIPAddress` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `userName`, `password`, `firstName`, `lastName`, `dob`, `email`, `address1`, `address2`, `postcode`, `county`, `country`, `telephone`, `lastOnline`, `userLevel`, `deleted`, `lastIPAddress`) VALUES
(2, 'admin', '$2a$10$4f4cbc26bdf150b2225b4u1xWrMIbyyyREjc.yCbBqsNgDk92VJc6', 'Tom', 'Collins', '0000-00-00 00:00:00', 't0mc97@gmail.com', 'add1', 'add2', 'postcode', 'ounty', 'country', 'tele', '2015-04-23 18:32:51', 'admin', 0, 'localhost'),
(3, 'user1', '$2a$10$ae75316baadf174d78919OVEAb7UUb5wSZbqaFFa9t8JM8ASkbsv6', 'Tom', 'Collins', '0000-00-00 00:00:00', 't@gmail.com', 'add1', 'add2', 'postcode', 'ounty', 'country', 'tele', '2015-04-23 16:52:44', 'user', 0, 'localhost');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contentFiles`
--
ALTER TABLE `contentFiles`
  ADD PRIMARY KEY (`fileid`);

--
-- Indexes for table `contentList`
--
ALTER TABLE `contentList`
  ADD PRIMARY KEY (`contentid`);

--
-- Indexes for table `fileAccess`
--
ALTER TABLE `fileAccess`
  ADD PRIMARY KEY (`accessid`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`pageid`);

--
-- Indexes for table `subUsers`
--
ALTER TABLE `subUsers`
  ADD PRIMARY KEY (`userid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contentFiles`
--
ALTER TABLE `contentFiles`
  MODIFY `fileid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `contentList`
--
ALTER TABLE `contentList`
  MODIFY `contentid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fileAccess`
--
ALTER TABLE `fileAccess`
  MODIFY `accessid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `pageid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
