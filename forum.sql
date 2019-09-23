-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Erstellungszeit: 28. Sep 2017 um 12:43
-- Server-Version: 10.1.23-MariaDB-9+deb9u1
-- PHP-Version: 7.0.19-1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `539197_1_1`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `threads`
--

CREATE TABLE `threads` (
  `thread_id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `owner` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `parent_thread_id` int(11) NOT NULL DEFAULT '0',
  `thread_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `threads`
--

INSERT INTO `threads` (`thread_id`, `title`, `content`, `owner`, `parent_thread_id`, `thread_time`) VALUES
(1, 'Client/Server', 'Was ist der Unterschied zwischen einem Client und einem Server?', 0, 0, '2017-07-20 10:22:20'),
(2, 'PHP', 'Was bedeitet PHP?', 3, 0, '2017-07-20 10:23:27'),
(3, 'PHP Hypertext Processor', 'PHP bedeutet \"PHP Hypertext Processor“.', 2, 2, '2017-07-24 17:39:58'),
(5, 'Titel meiner Frage', 'Inhalt meiner Frage', 1, 0, '2017-07-30 17:40:16'),
(44, 'wer', 'wie, was', 0, 0, '2017-07-30 17:21:59'),
(45, 'Wieso', 'weshalb, warum', 0, 44, '2017-07-30 17:26:08'),
(46, 'Wer nicht fragt', 'bleibt dumm!', 1, 44, '2017-07-30 17:43:52');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL DEFAULT '',
  `password` varchar(24) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `firstname` varchar(100) NOT NULL DEFAULT '',
  `lastname` varchar(100) NOT NULL DEFAULT '',
  `role` int(3) UNSIGNED NOT NULL DEFAULT '5',
  `user_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `email`, `firstname`, `lastname`, `role`, `user_time`) VALUES
(1, 'admin', '12345', 'alina.weisser@mmpforum.ch', 'Alina', 'Weisser', 100, '2017-07-18 11:35:18'),
(2, 'wobo', '54321', 'wolfgang.bock@htwchur.ch', 'Wolfgang', 'Bock', 5, '2017-07-18 20:43:07'),
(3, 'Bonsai', '1111', 'urs@thoeny.ch', 'Urs', 'Thöny', 5, '2017-07-19 09:44:52');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `threads`
--
ALTER TABLE `threads`
  ADD PRIMARY KEY (`thread_id`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `role` (`role`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `threads`
--
ALTER TABLE `threads`
  MODIFY `thread_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
