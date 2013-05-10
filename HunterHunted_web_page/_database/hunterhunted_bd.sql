-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 10-05-2013 a las 21:21:49
-- Versión del servidor: 5.5.24-log
-- Versión de PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `hunterhunted_bd`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `matchs`
--

CREATE TABLE IF NOT EXISTS `matchs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `match_name` varchar(20) COLLATE utf8_bin NOT NULL,
  `tournament_match` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 -> Friendly Match; 1 -> Tournament',
  `time` time NOT NULL DEFAULT '00:03:00' COMMENT 'HH:MM:SS',
  `id_creator` int(11) unsigned NOT NULL,
  `date_created` datetime DEFAULT NULL COMMENT 'YYYY-MM-DD HH:MM:SS',
  `id_user_winner_match` int(10) unsigned DEFAULT NULL,
  `tournament_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `match_name` (`match_name`),
  KEY `tournament_id` (`tournament_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Friendly matchs; Tournament matchs' AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `matchs`
--

INSERT INTO `matchs` (`id`, `match_name`, `tournament_match`, `time`, `id_creator`, `date_created`, `id_user_winner_match`, `tournament_id`) VALUES
(2, 'Partido', 0, '00:03:00', 1, '2013-04-26 00:13:43', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `score`
--

CREATE TABLE IF NOT EXISTS `score` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(11) unsigned NOT NULL,
  `hunter_score` int(10) unsigned NOT NULL DEFAULT '0',
  `hunted_score` int(10) unsigned NOT NULL DEFAULT '0',
  `punctuation` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_user` (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=105 ;

--
-- Volcado de datos para la tabla `score`
--

INSERT INTO `score` (`id`, `id_user`, `hunter_score`, `hunted_score`, `punctuation`) VALUES
(1, 1, 0, 0, -18),
(2, 9, 0, 0, 8),
(104, 6, 0, 0, -10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tournaments`
--

CREATE TABLE IF NOT EXISTS `tournaments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title_tournament` varchar(30) COLLATE utf8_bin NOT NULL DEFAULT 'Torneo' COMMENT 'Title Tournament',
  `initial_time` datetime DEFAULT NULL,
  `finish_time` datetime DEFAULT NULL,
  `date_created` datetime NOT NULL,
  `id_user_winner_tournament` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tournament History' AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `tournaments`
--

INSERT INTO `tournaments` (`id`, `title_tournament`, `initial_time`, `finish_time`, `date_created`, `id_user_winner_tournament`) VALUES
(1, 'Intercontinental', NULL, NULL, '0000-00-00 00:00:00', 6),
(3, 'Hola', NULL, NULL, '2013-04-29 17:34:09', NULL),
(4, 'Mundial', NULL, NULL, '2013-04-29 17:34:27', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(20) COLLATE utf8_bin NOT NULL,
  `password` varchar(40) COLLATE utf8_bin NOT NULL,
  `full_name` varchar(40) COLLATE utf8_bin NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0 -> Off; 1 -> On',
  `rol` tinyint(1) NOT NULL COMMENT '0: presa , 1: cazador',
  `email` varchar(45) COLLATE utf8_bin NOT NULL,
  `city` varchar(20) COLLATE utf8_bin NOT NULL,
  `country` varchar(20) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_name` (`user_name`,`email`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Users' AUTO_INCREMENT=10 ;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `user_name`, `password`, `full_name`, `status`, `rol`, `email`, `city`, `country`) VALUES
(1, 'admin', 'admin', 'administrador del sistema', 1, 1, 'admin@hunterhunted.com', 'barranquilla', 'colombia'),
(6, 'jose', '123', 'Jose Luis Gonzalez Coronado', 1, 0, 'gonzalezlj@uninorte.edu.co', 'barranquilla', 'colombia'),
(7, 'prueba', 'prueba', 'dsdbsd', 1, 0, 'alsfasjfa', 'asfas', 'dasfs'),
(8, 'prueba2', '12345', 'prueba dos', 1, 0, 'prueba@hot.co', 'barranquilla', 'colombia'),
(9, 'andres', 'a', 'Andres ortega', 1, 0, 'djgj@hotmail.com', 'barranquilla', 'colombia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_matchs`
--

CREATE TABLE IF NOT EXISTS `users_matchs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `users_id` int(11) NOT NULL,
  `match_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_id` (`users_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1079 ;

--
-- Volcado de datos para la tabla `users_matchs`
--

INSERT INTO `users_matchs` (`id`, `users_id`, `match_id`) VALUES
(1078, 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users_tournaments`
--

CREATE TABLE IF NOT EXISTS `users_tournaments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `users_id` int(11) unsigned NOT NULL,
  `tournament_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_id` (`users_id`),
  UNIQUE KEY `tournament_id` (`tournament_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `score`
--
ALTER TABLE `score`
  ADD CONSTRAINT `score_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `users_tournaments`
--
ALTER TABLE `users_tournaments`
  ADD CONSTRAINT `users_tournaments_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_tournaments_ibfk_2` FOREIGN KEY (`tournament_id`) REFERENCES `tournaments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
