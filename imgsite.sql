-- phpMyAdmin SQL Dump
-- version 4.4.15.9
-- https://www.phpmyadmin.net
--
-- Gostitelj: localhost
-- Čas nastanka: 02. okt 2018 ob 20.03
-- Različica strežnika: 5.6.37
-- Različica PHP: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Zbirka podatkov: `imgsite`
--

-- --------------------------------------------------------

--
-- Struktura tabele `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment_text` varchar(255) NOT NULL,
  `time_created` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Struktura tabele `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `imagehash` varchar(255) NOT NULL,
  `extension` varchar(255) NOT NULL,
  `image_title` varchar(255) NOT NULL,
  `image_description` text NOT NULL,
  `time_uploaded` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Odloži podatke za tabelo `images`
--

INSERT INTO `images` (`id`, `user_id`, `imagehash`, `extension`, `image_title`, `image_description`, `time_uploaded`) VALUES
(3, 10, 'f659f3535e', 'jpg', 'x', 'y asdf', '2018-09-16 12:49:58'),
(5, 14, '0dcb015a67', 'jpeg', 'asdas title', 'Descriptions are dsad', '2018-09-18 12:46:47');

-- --------------------------------------------------------

--
-- Struktura tabele `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `time_created` datetime NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Odloži podatke za tabelo `users`
--
-- Indeksi zavrženih tabel
--

--
-- Indeksi tabele `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indeksi tabele `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indeksi tabele `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT zavrženih tabel
--

--
-- AUTO_INCREMENT tabele `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT tabele `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT tabele `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
