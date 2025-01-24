-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 21, 2025 at 12:01 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `astromax`
--

-- --------------------------------------------------------

--
-- Table structure for table `attractions`
--

CREATE TABLE `attractions` (
  `attractionID` int(11) NOT NULL,
  `attractionName` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `overview` text NOT NULL,
  `img` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `maxCapacity` int(11) NOT NULL,
  `availablity` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attractions`
--

INSERT INTO `attractions` (`attractionID`, `attractionName`, `description`, `overview`, `img`, `price`, `maxCapacity`, `availablity`) VALUES
(1, 'E-Karting', 'Race our all-electric go-karts to test your skills, reflexes, and nerve. Challenge your friends, family, or colleagues and discover the true meaning of adrenaline – who will you challenge?\r\n\r\nDiscover the next level of excitement with our state-of-the-art electric go-karts. Perfect for adrenaline junkies seeking a pro racing challenge or families in search of a thrilling day out, our tracks cater to all skill levels.', 'We love go-karting! Our E-Karting track takes excitement to a whole new level with an electrifying ride.', 'kart.jfif', 14.95, 15, 1),
(2, 'Golf', 'Bid farewell to the traditional and step into the extraordinary world of urban golf at Astro MAX, where innovation meets excitement! Whether you’re a seasoned Urban Golf pro or venturing into crazy golf for the first time, our cutting-edge experience is tailored for enthusiasts of all skill levels. Say goodbye to the ordinary and welcome the extraordinary as you redefine your Urban Street Golf experience, creating lasting memories, conquering challenges, and immersing yourself in the thrill of the game.', 'Immerse in Urban Street Golf, where vibrant lights, unique holes, and no dress codes collide!', 'golf.jfif', 12.45, 6, 1),
(3, 'Bowling', 'Do you LOVE bowling? Step into a world of next generation bowling at Astro MAX. Test your skills on our cutting-edge Augmented Reality (AR) bowling lanes, where the excitement isn’t just confined to the pins – it’s an immersive journey that takes your bowling experience to the MAX.\r\n\r\nThe ambiance is set with a choice of captivating themes and games. Watch as our lanes transform, with themes that set the stage – it’s a journey beyond the ordinary with every roll of the ball.\r\n\r\nAt Astro MAX AR Bowling, we’re not just redefining the game; we’re revolutionising the way you experience bowling. Grab your friends, unleash your competitive spirit, and let the games begin in a realm where bowling legends are born!', 'Step onto our lanes and become a legend in the making at Astro MAX AR Bowling!', 'bowling.jpg', 10.45, 3, 1),
(5, 'Lazer Tag', 'Prepare for an exhilarating adventure as you step into the world of Tower Tag at Astro Max! Tower Tag offers unmatched virtual reality experiences, immersing you in captivating and interactive worlds using cutting-edge technology. Engage in heart-pounding matches, strategize with your team, and challenge your opponents in intense tower-based battles. With fast-paced gameplay and thrilling scenarios, Tower Tag brings the excitement of competitive gaming to life like never before. As one of the most successful multiplayer VR systems globally, Tower Tag awaits your challenge. Embark on a journey where reality fades away, and the extraordinary becomes reality. Elevate your entertainment experience with Tower Tag VR at Astro Max – where virtual adventures come to life!', 'Dive into the thrilling world of competitive gaming with Hologate Tower-Tag, an epic VR experience!', 'lazer_tag.jpg', 10.95, 8, 1),
(6, 'Darts', 'Our cutting-edge technology transforms the classic game of arrows into an extraordinary and entertaining adventure for players of all ages!', 'Step up to the oche and embark on an immersive journey into the world of Augmented Reality Digital Darts.', 'darts.jpg', 8.95, 12, 1);

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `bookingID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `attractionID` int(11) NOT NULL,
  `day` date NOT NULL,
  `timeSlot` time NOT NULL,
  `groupSize` int(11) NOT NULL,
  `totalCost` decimal(10,2) NOT NULL,
  `dateBooked` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`bookingID`, `userID`, `attractionID`, `day`, `timeSlot`, `groupSize`, `totalCost`, `dateBooked`) VALUES
(11, 1, 1, '2025-01-22', '16:00:00', 9, 134.55, '2025-01-21 09:16:25'),
(12, 1, 1, '2025-01-22', '11:00:00', 15, 224.25, '2025-01-21 09:17:04'),
(14, 1, 6, '2025-01-22', '14:00:00', 11, 98.45, '2025-01-21 09:25:43'),
(15, 2, 1, '2025-01-22', '13:00:00', 7, 104.65, '2025-01-21 09:48:38'),
(16, 2, 5, '2025-01-22', '16:00:00', 8, 87.60, '2025-01-21 09:49:20');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phonenumber` varchar(255) NOT NULL,
  `role` enum('Customer','Staff','Admin') DEFAULT 'Customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `Name`, `email`, `password`, `phonenumber`, `role`) VALUES
(1, 'Nasir Rashid', 'nasir@example.com', '$2y$10$IF6IpuA/D2fyvN7BlDiNieuxGiHrtXpaytVyCecLA7VYrrZsj9uGm', '0877564653453645', 'Admin'),
(2, 'rew23rw', 'isa@example.com', '$2y$10$kOY7t.IXg8XYMc/.XuqrUO2YyWLT2k1se2AsgdZB92YpMC92rhr86', '432865476423', 'Customer'),
(3, 'syed', 'syed@example.com', '$2y$10$Yg3K7vLGz1H2z99MClwqo.Q1L.XSxu0VIvGwkGV2y.uInrGOUHWTC', '763233420924389', 'Customer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attractions`
--
ALTER TABLE `attractions`
  ADD PRIMARY KEY (`attractionID`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`bookingID`),
  ADD KEY `userID` (`userID`),
  ADD KEY `attractionID` (`attractionID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attractions`
--
ALTER TABLE `attractions`
  MODIFY `attractionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `bookingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`attractionID`) REFERENCES `attractions` (`attractionID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
