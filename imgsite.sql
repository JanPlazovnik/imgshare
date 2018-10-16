-- phpMyAdmin SQL Dump
-- version 4.4.15.9
-- https://www.phpmyadmin.net
--
-- Gostitelj: localhost
-- Čas nastanka: 16. okt 2018 ob 14.41
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
CREATE DATABASE IF NOT EXISTS `imgsite` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `imgsite`;

-- --------------------------------------------------------

--
-- Struktura tabele `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment_text` varchar(255) NOT NULL,
  `time_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabele `images`
--

DROP TABLE IF EXISTS `images`;
CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `imagehash` varchar(255) NOT NULL,
  `extension` varchar(255) NOT NULL,
  `image_title` varchar(255) NOT NULL,
  `image_description` text NOT NULL,
  `time_uploaded` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabele `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `time_created` datetime NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Odloži podatke za tabelo `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `time_created`, `admin`) VALUES
(1, 'admin', '$2y$10$lfFouoEvZo9augB6px4C4e3laUJeu/xzcJKEDHLZknvefcfe6dCdO', 'jan.plazovnik@gmail.com', '2018-10-16 15:59:38', 1);

--
-- Indeksi zavrženih tabel
--

--
-- Indeksi tabele `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_images_id_fk` (`image_id`),
  ADD KEY `comments_users_id_fk` (`user_id`);

--
-- Indeksi tabele `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `images_users_id_fk` (`user_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT tabele `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT tabele `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Omejitve tabel za povzetek stanja
--

--
-- Omejitve za tabelo `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_images_id_fk` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_users_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Omejitve za tabelo `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_users_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
