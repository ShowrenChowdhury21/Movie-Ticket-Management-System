-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2020 at 10:30 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `movieticket`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `fname` varchar(50) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `mname` varchar(100) NOT NULL,
  `date` varchar(50) NOT NULL,
  `time` varchar(15) NOT NULL,
  `type` varchar(20) NOT NULL,
  `seats` int(5) NOT NULL,
  `price` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`fname`, `phone`, `mname`, `date`, `time`, `type`, `seats`, `price`) VALUES
('Abdullah', '01822252222', 'Guns Akimbo', '19-05-20', '11am', 'vip', 3, 3000),
('Abdullah', '01822252222', 'Jumanji', '19-05-20', '3am', 'vip', 4, 4000),
('Rakib', '01552255854', 'Birds of Prey', '20-05-20', '3am', 'vip', 4, 4000);

-- --------------------------------------------------------

--
-- Table structure for table `comingsoon`
--

CREATE TABLE `comingsoon` (
  `image` mediumtext NOT NULL,
  `mname` varchar(100) NOT NULL,
  `director` varchar(50) NOT NULL,
  `genre` varchar(50) NOT NULL,
  `description` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `comingsoon`
--

INSERT INTO `comingsoon` (`image`, `mname`, `director`, `genre`, `description`) VALUES
('poster6.jpg', 'KGF 2', 'Prashanth Neel', 'Action', 'Best one'),
('poster7.jpg', 'Underwater', 'William Eubank', 'Horror,Thriller', 'good one'),
('poster8.jpg', 'Black Widow', 'Cate Shortland', 'Adventure,Action', 'Best one'),
('poster9.jpg', 'Pycaaka', 'Stephen Chow', 'Horror', 'Ghoastly '),
('poster10.jpg', 'Impossible monsters', 'Nathan Catucci', 'Thriller', 'Good');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(30) NOT NULL,
  `fname` varchar(30) NOT NULL,
  `lname` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `fname`, `lname`, `email`, `phone`, `password`) VALUES
(42115780, 'Abdullah', 'Rahman', 'abdullah@user.com', '01775552225', '953c1224e7654fb74fbb637f72ed9d13'),
(68358423, 'Rakib', 'Khan', 'rakib@user.com', '01555222555', '5e699b3ee74abdc7ab59106b15b6e55e');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(15) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `gender` varchar(8) NOT NULL,
  `designation` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `salary` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `fname`, `lname`, `email`, `phone`, `gender`, `designation`, `address`, `salary`) VALUES
(112233, 'Abir', 'Hossain', 'abir22@manager.com', '01852255224', 'male', 'manager', 'Basundhara Residential Area,Dhaka', 250000),
(11111111, 'Tanvir', 'Ahmed', 'tanvir@admin.com', '01558555852', 'male', 'admin', 'Aiub, Dhaka', 300000),
(11223435, 'Kawser', 'Sheikh', 'kawser@employee.com', '01966565252', 'male', '', 'Dhanmondi housing,Dhaka', 110000),
(11223344, 'Showren', 'Chowdhury', 'showren@manager.com', '01752256257', 'male', 'manager', 'Dhanmondi housing road 6,Dhaka', 250000),
(13211104, 'Maisha', 'Haque', 'maisha@employee.com', '01825852942', 'female', '', 'Basundhara Residential Area Block D,Dhaka', 100000);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(30) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `fname`, `email`, `password`, `role`) VALUES
(112233, 'Abir', 'abir22@manager.com', 'ae10732723eb65123391850af6eef6b9', 2),
(42115780, 'Abdullah', 'abdullah@user.com', '953c1224e7654fb74fbb637f72ed9d13', 3),
(11111111, 'Tanvir', 'tanvir@admin.com', 'a35f84ab14d9aa21e893eb08ed6ca3fe', 1),
(11223344, 'Showren', 'showren@manager.com', '94742b26b86eb0add0ba52a820eeeec2', 2),
(68358423, 'Rakib', 'rakib@user.com', '5e699b3ee74abdc7ab59106b15b6e55e', 3);

-- --------------------------------------------------------

--
-- Table structure for table `movie`
--

CREATE TABLE `movie` (
  `image` mediumtext NOT NULL,
  `mname` varchar(100) NOT NULL,
  `director` varchar(100) NOT NULL,
  `genre` varchar(50) NOT NULL,
  `duration` int(4) NOT NULL,
  `description` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `movie`
--

INSERT INTO `movie` (`image`, `mname`, `director`, `genre`, `duration`, `description`) VALUES
('poster1.jpg', 'Guns Akimbo', 'Jason Lei Howden', 'Action,Comedy', 95, 'something good.'),
('poster2.jpg', 'Jumanji', 'Jake Kasdan', 'Adventure,Action', 123, 'something good.'),
('poster3.jpg', 'Sonic the Hedgehog', 'Jeff Fowler', 'Adventure,Family', 100, 'something good.'),
('poster4.jpg', 'The Call of the Wild', 'Chris Sanders', 'Adventure,Drama', 100, 'something good.'),
('poster5.jpg', 'Birds of Prey', 'Cathy Yan', 'Action,Superhero', 109, 'something good.');

-- --------------------------------------------------------

--
-- Table structure for table `shows`
--

CREATE TABLE `shows` (
  `id` varchar(15) NOT NULL,
  `mname` varchar(100) NOT NULL,
  `date` varchar(50) NOT NULL,
  `time` varchar(15) NOT NULL,
  `seats` int(4) NOT NULL,
  `type` varchar(20) NOT NULL,
  `price` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `shows`
--

INSERT INTO `shows` (`id`, `mname`, `date`, `time`, `seats`, `type`, `price`) VALUES
('G1V', 'Guns Akimbo', '19-05-20', '11am', 34, 'vip', 1000),
('G1NV', 'Guns Akimbo', '19-05-20', '11am', 40, 'nonvip', 550),
('J1V', 'Jumanji', '19-05-20', '3am', 36, 'vip', 1000),
('J1NV', 'Jumanji', '19-05-20', '3am', 40, 'nonvip', 550),
('S1V', 'Sonic the Hedgehog', '19-05-20', '6am', 40, 'vip', 1000),
('S1NV', 'Sonic the Hedgehog', '19-05-20', '6am', 40, 'nonvip', 550),
('C1V', 'The Call of the Wild', '20-05-20', '11am', 40, 'vip', 1000),
('C1NV', 'The Call of the Wild', '20-05-20', '11am', 40, 'nonvip', 550),
('B1V', 'Birds of Prey', '20-05-20', '3am', 36, 'vip', 1000),
('B1NV', 'Birds of Prey', '20-05-20', '3am', 40, 'nonvip', 550),
('J2V', 'Jumanji', '20-05-20', '6am', 40, 'vip', 1000),
('J2NV', 'Jumanji', '20-05-20', '6am', 40, 'nonvip', 550);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
