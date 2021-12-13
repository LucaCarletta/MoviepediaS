-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 19, 2020 at 10:40 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `moviepedia`
--

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `title` varchar(60) NOT NULL,
  `text` mediumtext NOT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT 0,
  `parent` int(11) DEFAULT NULL,
  `author` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `text`, `approved`, `parent`, `author`) VALUES
(2, 'Hello', 'gsQDDFGHJKLÖÖÖÖÖÖÖLLLLLLkllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllllll', 0, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `moderator` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `email`, `password`, `moderator`) VALUES
(1, 'HJGDUZJGsadas', 'Leoekto', 'Leon', 'leonkleiber3@gmail.com', '$2y$10$WtgxB7UwVSdvhW/zES4N9OnbyEs.lL85gA4X.1zy7o4fkuGqc75t.', 0),
(2, 'Leon', 'Kleiber', 'JaehaerysT', 'leon.kleiber@gibmit.ch', '$2y$10$WtgxB7UwVSdvhW/zES4N9OnbyEs.lL85gA4X.1zy7o4fkuGqc75t.', 1),
(3, 'KLWJqdd', 'ILjDKLDJDNDKdjkshfj', 'Leon', 'dkfdfj22@kdjfkl.dfkl', '$2y$10$gWlvgPHLBhpCfsa0lkQP5.esKkz7ih0.DA1f700R8QSnjRZL.ZX46', 0),
(4, 'KLWJqdd', 'ILjDKLDJDNDKdjkshfj', 'Leon', 'dkfdfj22@kdjfkl.dfkl', '$2y$10$k8h//BPJ5OZPIyhWVo2FfOBG8pH7TTBzx35O9U.lug2fdIuch6HNa', 0),
(5, 'KLWJqdd', 'ILjDKLDJDNDKdjkshfj', 'Leon', 'dkfdfj22@kdjfkl.dfkl', '$2y$10$gwrrehceN8N./wqZivj0leiQP7glUlxPe/9MsVnxb/oPgzOKwyzH6', 0),
(6, 'Leon', 'Kleiber', 'JaehaerysT', 'leonkleiber3@gmail.com', '$2y$10$AgI0kxgFGXQGiPgQ.J90gekRNS1tXJ.ecktBuEc8rbm47HAzJOjni', 0),
(7, 'Leon', 'Kleiber', 'ilgjfioldhfigH', 'leonkleiber3@gmail.com', '$2y$10$IXAPQ38LAgNUPjy.AROWU.LYWARSZuuX07KQ0dCPqannJAB83BWzS', 0),
(8, 'Leon', 'Kleiber', 'ilgjfioldhfigH', 'leonkleiber3@gmail.com', '$2y$10$SDzwKFcZ.hfQbrH.NLyePewPkfeCIVPRZlVYMBZVr2azSSRBVuLWC', 1),
(9, 'Kkjhfdsew', 'Kleiber', 'Fisc', 'leonkleiber3@gmail.com', '$2y$10$j.DFR/tY9BTSa/h4EFD4FOGhnb.XrA2eQDLqsmgNTruHDk5.u8irC', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent` (`parent`),
  ADD KEY `author` (`author`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pages`
--
ALTER TABLE `pages`
  ADD CONSTRAINT `pages_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `pages` (`id`),
  ADD CONSTRAINT `pages_ibfk_2` FOREIGN KEY (`author`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
