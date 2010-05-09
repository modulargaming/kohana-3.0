-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 09, 2010 at 11:23 AM
-- Server version: 5.1.41
-- PHP Version: 5.3.2-1ubuntu4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
--
-- Database: `modulargaming`
--

-- --------------------------------------------------------

--
-- Table structure for table `alignments`
--

CREATE TABLE IF NOT EXISTS `alignments` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `min` int(6) NOT NULL,
  `max` int(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `alignments`
--

INSERT INTO `alignments` (`id`, `name`, `min`, `max`) VALUES
(1, 'Angel', 81, 100),
(2, 'Good', 60, 80),
(3, 'Neutral', 41, 59),
(4, 'Evil', 20, 40),
(5, 'Devil', 0, 19);

-- --------------------------------------------------------

--
-- Table structure for table `battles`
--

CREATE TABLE IF NOT EXISTS `battles` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `character_id` int(6) NOT NULL,
  `monster_id` int(6) NOT NULL,
  `hp` int(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE IF NOT EXISTS `blog_posts` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `author` int(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `blog_posts`
--


-- --------------------------------------------------------

--
-- Table structure for table `characters`
--

CREATE TABLE IF NOT EXISTS `characters` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `user_id` int(6) NOT NULL,
  `name` varchar(255) NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `race_id` int(6) NOT NULL,
  `class_id` int(6) NOT NULL,
  `alignment` int(4) NOT NULL,
  `hp` int(6) NOT NULL,
  `max_hp` int(6) NOT NULL,
  `strength` int(6) NOT NULL,
  `defence` int(6) NOT NULL,
  `agility` int(6) NOT NULL,
  `money` int(6) NOT NULL,
  `level` int(6) NOT NULL,
  `xp` int(6) DEFAULT NULL,
  `max_xp` int(6) DEFAULT NULL,
  `energy` int(6) NOT NULL,
  `max_energy` int(6) NOT NULL,
  `zone_id` int(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


--
-- Table structure for table `character_classes`
--

CREATE TABLE IF NOT EXISTS `character_classes` (
  `id` int(6) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;

INSERT INTO `character_classes` (`id`, `name`, `description`) VALUES 
(1, 'Warrior', 'Warriors are strong'),
(2, 'Magican', 'Magicans are fast'),
(3, 'Medic',   'Medics have a lot of health');

--
-- Table structure for table `character_races`
--

CREATE TABLE IF NOT EXISTS `character_races` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `starting_zone` int(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `character_races`
--

INSERT INTO `character_races` (`id`, `name`, `description`, `starting_zone`) VALUES
(1, 'Human', 'The human race. ', 1),
(2, 'Alien', 'Aliens that have migrated to Earth.', 1);

-- --------------------------------------------------------


--
-- Table structure for table `forum_categories`
--

CREATE TABLE IF NOT EXISTS `forum_categories` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `title` varchar(30) NOT NULL,
  `description` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `forum_categories`
--

INSERT INTO `forum_categories` (`id`, `title`, `description`) VALUES
(1, 'General', 'General Discussions'),
(2, 'Marketplace', 'Buy and sell items.'),
(3, 'Alliances', 'Alliance Discussions');

-- --------------------------------------------------------

--
-- Table structure for table `forum_posts`
--

CREATE TABLE IF NOT EXISTS `forum_posts` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `topic_id` int(6) NOT NULL,
  `user_id` int(6) NOT NULL,
  `title` varchar(25) NOT NULL,
  `content` varchar(500) NOT NULL,
  `created` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `forum_topics`
--

CREATE TABLE IF NOT EXISTS `forum_topics` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `category_id` int(6) NOT NULL,
  `user_id` int(6) NOT NULL,
  `title` varchar(30) NOT NULL,
  `status` varchar(12) NOT NULL,
  `posts` int(6) NOT NULL,
  `created` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `class` varchar(25) NOT NULL,
  `image` varchar(25) NOT NULL,
  `description` text NOT NULL,
  `name` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `items`
--


INSERT INTO `items` (`id`, `class`, `image`, `description`, `name`) VALUES
(1, 'food', 'food/apple.png', 'A very delicate apple, replenishes some health on use.', 'Apple'),
(2, 'food', 'food/pie.png', 'A pie, replenishes a lot of health on use', 'Cooked Pie'),
(3, 'weapon', 'axe/starter.png', 'An axe made of wood. Nothing special but it will still help!', 'Starter Axe'),
(4, 'weapon', 'bow/starter.png', 'An bow made of wood. Nothing special but it will still help!', 'Starter Bow'),
(5, 'weapon', 'bow/basic.png', 'An bow made of wood. Quite good.', 'Basic Bow'),
(6, 'weapon', 'sword/basic.png', 'An sword made of iron. Nothing special but it will still help!', 'Basic Sword'),
(7, 'weapon', 'sword/basic2.png', 'An long sword made of iron. Nothing special but it will still help!', 'Basic Long Sword'),
(8, 'weapon', 'sword/ice.png', 'An sword made of ice. Nothing special but it will still help!', 'Basic Long Sword');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `to` int(6) NOT NULL,
  `to_status` varchar(10) NOT NULL,
  `from` int(6) NOT NULL,
  `from_status` varchar(10) NOT NULL,
  `status` varchar(10) NOT NULL,
  `title` varchar(25) NOT NULL,
  `message` text NOT NULL,
  `created` int(10),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `monsters`
--

CREATE TABLE IF NOT EXISTS `monsters` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `level` int(6) NOT NULL,
  `max_hp` int(6) NOT NULL,
  `defence` int(2) NOT NULL,
  `min_dmg` int(6) NOT NULL,
  `max_dmg` int(6) NOT NULL,
  `money` int(6) NOT NULL,
  `xp` int(6) NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `monsters`
--

INSERT INTO `monsters` (`id`, `name`, `level`, `max_hp`, `defence`, `min_dmg`, `max_dmg`, `money`, `xp`, `image`) VALUES
(1, 'Alpha', 0, 50, 20, 1, 2, 300, 10, 'virus/virus.png'),
(2, 'Beta', 0, 100, 10, 1, 5, 1000, 20, 'virus/virus2.png'),
(3, 'Gamma', 0, 150, 20, 2, 8, 300, 30, 'virus/virus3.png'),
(4, 'Delta', 0, 150, 20, 5, 15, 300, 50, 'virus/virus4.png'),
(5, 'Epsilon', 0, 150, 20, 8, 15, 300, 100, 'virus/virus5.png'),
(6, 'Zeta', 0, 150, 20, 10, 18, 300, 150, 'virus/virus6.png'),
(7, 'Kappa', 0, 150, 10, 15, 20, 1000, 300, 'virus/virus7.png'),
(8, 'Lambda', 0, 200, 10, 15, 20, 1000, 500, 'virus/virus8.png'),
(9, 'Mu', 0, 300, 10, 15, 20, 1000, 1000, 'virus/virus9.png'),
(10, 'Nu', 0, 400, 10, 15, 20, 1000, 2500, 'virus/virus10.png');

-- --------------------------------------------------------

-- --------------------------------------------------------

--
-- Table structure for table `navigations`
--

CREATE TABLE IF NOT EXISTS `navigations` (
  `id` int(6) NOT NULL,
  `group_id` int(6) NOT NULL,
  `position` int(6) NOT NULL,
  `title` varchar(25) NOT NULL,
  `slug` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


--
-- Table structure for table `npcs`
--

CREATE TABLE IF NOT EXISTS `npcs` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `zone_id` int(6) NOT NULL,
  `name` varchar(255) NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `npcs`
--

INSERT INTO `npcs` (`id`, `zone_id`, `name`, `message`) VALUES
(1, 1, 'E4-P4', 'Hello,\r\n\r\nI am E4-P4 how may I help?');

-- --------------------------------------------------------

--
-- Table structure for table `npc_messages`
--

CREATE TABLE IF NOT EXISTS `npc_messages` (
  `id` int(6) NOT NULL,
  `npc_id` int(6) NOT NULL,
  `title` varchar(25) NOT NULL,
  `message` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `npc_messages`
--

-- --------------------------------------------------------

--
-- Table structure for table `npc_quests`
--

CREATE TABLE IF NOT EXISTS `npc_quests` (
  `id` int(6) NOT NULL,
  `npc_id` int(6) NOT NULL,
  `title` varchar(25) NOT NULL,
  `description` varchar(100) NOT NULL,
  `type` enum('item','kill','travel') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `npc_quests`
--

INSERT INTO `npc_quests` (`id`, `npc_id`, `title`, `description`, `type`) VALUES
(1, 1, 'Test quest', 'Test quest', 'item');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `session_id` varchar(127) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL,
  `data` text NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sessions`
--


-- --------------------------------------------------------

--
-- Table structure for table `shops`
--

CREATE TABLE IF NOT EXISTS `shops` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `zone_id` int(6) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `shops`
--

INSERT INTO `shops` (`id`, `zone_id`, `name`, `description`) VALUES
(1, 1, 'General Store', 'We sell food products to help get your health back.'),
(2, 2, 'Weapon Store', 'We sell quality weapons.');

-- --------------------------------------------------------

--
-- Table structure for table `shop_items`
--

CREATE TABLE IF NOT EXISTS `shop_items` (
  `shop_id` int(6) NOT NULL,
  `item_id` int(6) NOT NULL,
  `amount` int(6) NOT NULL,
  `price` int(6) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shop_items`
--

INSERT INTO `shop_items` (`shop_id`, `item_id`, `amount`, `price`) VALUES
(1, 1, 100, 5),
(1, 2, 300, 4),
(2, 3, 10, 200),
(2, 4, 10, 400),
(2, 5, 10, 800),
(2, 6, 10, 1600),
(2, 7, 10, 2000),
(2, 8, 10, 15000);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(64) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `logins` int(10) DEFAULT NULL,
  `last_login` int(10) DEFAULT NULL,
  `role` varchar(50) NOT NULL,
  `language` varchar(3) DEFAULT 'en',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Table structure for table `user_facebook`
--

CREATE TABLE IF NOT EXISTS `user_facebook` (
  `facebook_id` int(6) NOT NULL,
  `user_id` int(6) NOT NULL,
  UNIQUE KEY `facebook_id` (`facebook_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_facebook`
--


-- --------------------------------------------------------

--
-- Table structure for table `user_histories`
--

CREATE TABLE IF NOT EXISTS `user_histories` (
  `user_id` int(6) NOT NULL,
  `time` int(10) NOT NULL,
  `history` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_items`
--

CREATE TABLE IF NOT EXISTS `user_items` (
  `item_id` int(6) NOT NULL,
  `user_id` int(6) NOT NULL,
  `amount` int(6) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_items`
--


-- --------------------------------------------------------

--
-- Table structure for table `zones`
--

CREATE TABLE IF NOT EXISTS `zones` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `energy` int(4) NOT NULL,
  `x` int(2) NOT NULL,
  `y` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `zones`
--

INSERT INTO `zones` (`id`, `name`, `description`, `energy`, `x`, `y`) VALUES
(1, 'Upsilon', 'The ancient city of Upsilon was created by the survivors after the Apocalypse.', 10, 1, 1),
(2, 'Theta Forest', 'The forests of Theta are not the safest place to be. Theta has stronger viri due to being in the wild.', 10, 1, 2),
(3, 'Echo Valley', 'Echo Valley is an empty area but it is very dangerous.', 20, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `zone_monster`
--

CREATE TABLE IF NOT EXISTS `zone_monster` (
  `zone_id` int(6) NOT NULL,
  `monster_id` int(6) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zone_monster`
--

INSERT INTO `zone_monster` (`zone_id`, `monster_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(2, 3),
(2, 4),
(2, 5),
(2, 6),
(3, 4),
(3, 5),
(3, 6),
(3, 7),
(3, 8),
(3, 9),
(3, 10);


CREATE TABLE IF NOT EXISTS `navigations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` varchar(255) NOT NULL,
  `position` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

