-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Värd: localhost
-- Skapad: 27 februari 2010 kl 17:22
-- Serverversion: 5.1.37
-- PHP-version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databas: `mg`
--

-- --------------------------------------------------------

--
-- Struktur för tabell `alignments`
--

CREATE TABLE IF NOT EXISTS `alignments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `min` int(11) NOT NULL,
  `max` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Data i tabell `alignments`
--

INSERT INTO `alignments` (`id`, `name`, `min`, `max`) VALUES
(1, 'Angel', 81, 100),
(2, 'Good', 60, 80),
(3, 'Neutral', 59, 41),
(4, 'Evil', 40, 20),
(5, 'Devil', 19, 0);

-- --------------------------------------------------------

--
-- Struktur för tabell `battles`
--

CREATE TABLE IF NOT EXISTS `battles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `character_id` int(11) NOT NULL,
  `monster_id` int(11) NOT NULL,
  `hp` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=42 ;

--
-- Data i tabell `battles`
--

INSERT INTO `battles` (`id`, `character_id`, `monster_id`, `hp`) VALUES
(41, 6, 2, 100);

-- --------------------------------------------------------

--
-- Struktur för tabell `blog_posts`
--

CREATE TABLE IF NOT EXISTS `blog_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `author` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Data i tabell `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `title`, `content`, `created_on`, `author`) VALUES
(1, 'testy', 'yryryryryryry', '2009-12-29 00:00:00', 2);

-- --------------------------------------------------------

--
-- Struktur för tabell `characters`
--

CREATE TABLE IF NOT EXISTS `characters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `race_id` int(11) NOT NULL,
  `alignment` int(4) NOT NULL,
  `hp` int(11) NOT NULL,
  `max_hp` int(11) NOT NULL,
  `money` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `xp` int(11) NOT NULL,
  `energy` int(11) NOT NULL,
  `zone_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Data i tabell `characters`
--

INSERT INTO `characters` (`id`, `user_id`, `name`, `gender`, `race_id`, `alignment`, `hp`, `max_hp`, `money`, `level`, `xp`, `energy`, `zone_id`) VALUES
(6, 2, 'Cookie', 'male', 1, 5000, 100, 100, 980, 1, 0, 100, 1);

-- --------------------------------------------------------

--
-- Struktur för tabell `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class` varchar(25) NOT NULL,
  `image` varchar(25) NOT NULL,
  `description` text NOT NULL,
  `name` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Data i tabell `items`
--

INSERT INTO `items` (`id`, `class`, `image`, `description`, `name`) VALUES
(1, 'food', 'anchovypizzaslice.png', 'A very delicate chicken, replenishes some health on use.', 'Cooked chicken'),
(2, 'food', 'orange.png', '', 'Orange');

-- --------------------------------------------------------

--
-- Struktur för tabell `monsters`
--

CREATE TABLE IF NOT EXISTS `monsters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `max_hp` int(11) NOT NULL,
  `defence` int(2) NOT NULL,
  `min_dmg` int(11) NOT NULL,
  `max_dmg` int(11) NOT NULL,
  `money` int(11) NOT NULL,
  `xp` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Data i tabell `monsters`
--

INSERT INTO `monsters` (`id`, `name`, `max_hp`, `defence`, `min_dmg`, `max_dmg`, `money`, `xp`, `image`) VALUES
(1, 'Pig', 50, 20, 1, 4, 300, 20, 'pig.gif'),
(2, 'Strong Pig', 100, 10, 5, 15, 1000, 100, 'pig.gif');

-- --------------------------------------------------------

--
-- Struktur för tabell `races`
--

CREATE TABLE IF NOT EXISTS `races` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `starting_zone` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Data i tabell `races`
--

INSERT INTO `races` (`id`, `name`, `description`, `starting_zone`) VALUES
(1, 'Human', 'Some text', 1);

-- --------------------------------------------------------

--
-- Struktur för tabell `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `session_id` varchar(127) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL,
  `data` text NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Data i tabell `sessions`
--


-- --------------------------------------------------------

--
-- Struktur för tabell `shops`
--

CREATE TABLE IF NOT EXISTS `shops` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zone_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Data i tabell `shops`
--

INSERT INTO `shops` (`id`, `zone_id`, `name`, `description`) VALUES
(1, 1, 'Weapon Manager', 'I sell awesome weapons.');

-- --------------------------------------------------------

--
-- Struktur för tabell `shop_items`
--

CREATE TABLE IF NOT EXISTS `shop_items` (
  `shop_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Data i tabell `shop_items`
--

INSERT INTO `shop_items` (`shop_id`, `item_id`, `amount`, `price`) VALUES
(1, 1, 0, 50);

-- --------------------------------------------------------

--
-- Struktur för tabell `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(64) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `logins` int(10) NOT NULL,
  `last_login` int(10) DEFAULT NULL,
  `role` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Data i tabell `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `token`, `logins`, `last_login`, `role`) VALUES
(2, 'copy112', 'copy112@gmail.com', '788429e33e99edb89255e7c8c3755c5a4cc19e7b15d06e701c', '4NaXzislTKzNtepgjjvWOzqXXmBsncmf', 35, 1267227526, 'admin'),
(18, 'test', 'test@gmail.com', 'ddbb5d3888e4c75cc2abbfe76a5b57527f3bc3cc9979cd615c', 'WMp7BzN6n1cohSioA5pbkqa3a2ezOJTO', 3, 1261614811, ''),
(19, 'test2', 'test@test.com', NULL, NULL, 0, NULL, ''),
(20, 'test2', 'test@test.com', NULL, NULL, 0, NULL, ''),
(21, 'test2', 'test@test.com', NULL, NULL, 0, NULL, ''),
(22, 'test2', 'test@test.com', NULL, NULL, 0, NULL, ''),
(23, 'test2', 'test@test.com', NULL, NULL, 0, NULL, ''),
(24, 'test2', 'test@test.com', NULL, NULL, 0, NULL, ''),
(25, 'testy', 'thetest2@gmail.com', '76cd5db8d1db010a2a9f07541a22ebe2d480746792239b4609', '', 0, NULL, 'user'),
(26, 'tester', 'copy112@lol.com', 'ef72d9d9320289efdddc16753e6e5e1d73e165274fb6ba87ea', '', 0, NULL, '2'),
(27, 'copy1122', 'copy112@gmail.com', 'afa043a96395678c1fd11273bc5c0038650ebecb06decf8b16', '', 0, NULL, '');

-- --------------------------------------------------------

--
-- Struktur för tabell `user_histories`
--

CREATE TABLE IF NOT EXISTS `user_histories` (
  `user_id` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `history` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Data i tabell `user_histories`
--

INSERT INTO `user_histories` (`user_id`, `time`, `history`) VALUES
(2, 1264780728, 'Created the character'),
(2, 1265926962, 'hi'),
(2, 1266000411, 'Created the character: Cookie'),
(2, 1266000938, 'Started a new battle agains Strong Pig'),
(2, 1267011168, 'Started a new battle agains Strong Pig');

-- --------------------------------------------------------

--
-- Struktur för tabell `user_items`
--

CREATE TABLE IF NOT EXISTS `user_items` (
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Data i tabell `user_items`
--

INSERT INTO `user_items` (`item_id`, `user_id`, `amount`) VALUES
(1, 2, 41),
(2, 2, 3);

-- --------------------------------------------------------

--
-- Struktur för tabell `zones`
--

CREATE TABLE IF NOT EXISTS `zones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `energy` int(4) NOT NULL,
  `x` int(2) NOT NULL,
  `y` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Data i tabell `zones`
--

INSERT INTO `zones` (`id`, `name`, `description`, `energy`, `x`, `y`) VALUES
(1, 'Norse Land', 'The ancient land of the Norse gods, created to bring peace to all remaining believers in the Norse mythology.', 20, 1, 1),
(2, 'Dev Land', 'The mystic area of development, still not sure why its here.', 10, 1, 2);

-- --------------------------------------------------------

--
-- Struktur för tabell `zone_monster`
--

CREATE TABLE IF NOT EXISTS `zone_monster` (
  `zone_id` int(11) NOT NULL,
  `monster_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Data i tabell `zone_monster`
--

INSERT INTO `zone_monster` (`zone_id`, `monster_id`) VALUES
(1, 1),
(1, 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
