-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 30, 2010 at 10:22 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.2-1ubuntu3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `mg`
--

-- --------------------------------------------------------

--
-- Table structure for table `alignments`
--

CREATE TABLE IF NOT EXISTS `alignments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `min` int(11) NOT NULL,
  `max` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `alignments`
--

INSERT INTO `alignments` (`id`, `name`, `min`, `max`) VALUES
(1, 'Angel', 81, 100),
(2, 'Good', 60, 80),
(3, 'Neutral', 59, 41),
(4, 'Evil', 40, 20),
(5, 'Devil', 19, 0);

-- --------------------------------------------------------

--
-- Table structure for table `battles`
--

CREATE TABLE IF NOT EXISTS `battles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `character_id` int(11) NOT NULL,
  `monster_id` int(11) NOT NULL,
  `hp` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `battles`
--

INSERT INTO `battles` (`id`, `character_id`, `monster_id`, `hp`) VALUES
(2, 1, 2, 100),
(3, 2, 1, 50);

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
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
-- Dumping data for table `blog_posts`
--


-- --------------------------------------------------------

--
-- Table structure for table `characters`
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
  `xp` int(11) DEFAULT NULL,
  `energy` int(11) NOT NULL,
  `zone_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `characters`
--

INSERT INTO `characters` (`id`, `user_id`, `name`, `gender`, `race_id`, `alignment`, `hp`, `max_hp`, `money`, `level`, `xp`, `energy`, `zone_id`) VALUES
(1, 1, 'curtis', 'male', 1, 5000, 100, 100, 612, 1, 0, 70, 1),
(2, 2, 'Lewis', 'male', 1, 5000, 0, 100, 1000, 1, 0, 90, 2);

-- --------------------------------------------------------

--
-- Table structure for table `forum_categories`
--

CREATE TABLE IF NOT EXISTS `forum_categories` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `title` varchar(30) NOT NULL,
  `description` varchar(50) NOT NULL,
  `access` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `forum_categories`
--

INSERT INTO `forum_categories` (`id`, `title`, `description`, `access`) VALUES
(1, 'General', 'General Discussions', 0),
(2, 'Marketplace', 'Buy and sell items.', 0),
(3, 'Alliances', 'Alliance Discussions', 0);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `forum_posts`
--

INSERT INTO `forum_posts` (`id`, `topic_id`, `user_id`, `title`, `content`, `created`) VALUES
(1, 1, 1, 'Test', 'testasasasa', 1269904152),
(2, 1, 1, 'test again', 'another test', 1269905004),
(3, 1, 2, '123', '1234567890', 1269946315),
(4, 1, 1, 'HAAA', 'HAHAHAHAHAAHAH', 1269981498),
(5, 4, 1, 'Test', 'Testaaaaaaa', 1269982454),
(6, 5, 1, 'tests', 'testss', 1269983295),
(7, 6, 1, 'Testataa', 'testoooo', 1269983354),
(8, 7, 1, 'testasasa', 'testasasass', 1269983407),
(9, 7, 1, 'testaasa', 'testasasa', 1269983455);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `forum_topics`
--

INSERT INTO `forum_topics` (`id`, `category_id`, `user_id`, `title`, `status`, `posts`, `created`) VALUES
(1, 1, 0, 'Test', '', 0, 1234567891),
(2, 0, 0, 'Test', 'open', 0, 1269981965),
(3, 1, 0, 'Test', 'open', 0, 1269982052),
(4, 1, 0, 'Test', 'open', 1, 1269982454),
(5, 1, 0, 'tests', 'open', 1, 1269983295),
(6, 1, 0, 'Testataa', 'open', 1, 1269983354),
(7, 2, 0, 'testasasa', 'open', 1, 1269983407);

-- --------------------------------------------------------

--
-- Table structure for table `items`
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
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `class`, `image`, `description`, `name`) VALUES
(1, 'food', 'anchovypizzaslice.png', 'A very delicate chicken, replenishes some health on use.', 'Cooked chicken'),
(2, 'food', 'orange.png', '', 'Orange');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `to` int(6) NOT NULL,
  `from` int(6) NOT NULL,
  `status` varchar(10) NOT NULL,
  `title` varchar(25) NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `to`, `from`, `status`, `title`, `message`) VALUES
(1, 1, 1, 'sent', 'test', 'test test test'),
(2, 1, 1, 'sent', 'hkkk', 'hkkkkkkkkkkkk');

-- --------------------------------------------------------

--
-- Table structure for table `monsters`
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `monsters`
--

INSERT INTO `monsters` (`id`, `name`, `max_hp`, `defence`, `min_dmg`, `max_dmg`, `money`, `xp`, `image`) VALUES
(1, 'Pig', 50, 20, 1, 4, 300, 20, 'pig.gif'),
(2, 'Strong Pig', 100, 10, 5, 15, 1000, 100, 'pig.gif'),
(3, 'Pig', 150, 20, 1, 4, 300, 20, 'pig.gif'),
(4, 'Pig', 150, 20, 1, 4, 300, 20, 'pig.gif'),
(5, 'Pig', 150, 20, 1, 4, 300, 20, 'pig.gif'),
(6, 'Pig', 150, 20, 1, 4, 300, 20, 'pig.gif'),
(7, 'Pig', 100, 10, 1, 10, 1000, 100, 'pig2.png');

-- --------------------------------------------------------

--
-- Table structure for table `npcs`
--

CREATE TABLE IF NOT EXISTS `npcs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zone_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `npcs`
--


-- --------------------------------------------------------

--
-- Table structure for table `races`
--

CREATE TABLE IF NOT EXISTS `races` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `starting_zone` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `races`
--

INSERT INTO `races` (`id`, `name`, `description`, `starting_zone`) VALUES
(1, 'Human', 'Some text', 1);

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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zone_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `shops`
--

INSERT INTO `shops` (`id`, `zone_id`, `name`, `description`) VALUES
(1, 1, 'Weapon Manager', 'I sell awesome weapons.');

-- --------------------------------------------------------

--
-- Table structure for table `shop_items`
--

CREATE TABLE IF NOT EXISTS `shop_items` (
  `shop_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shop_items`
--

INSERT INTO `shop_items` (`shop_id`, `item_id`, `amount`, `price`) VALUES
(1, 1, 100, 50);

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `token`, `logins`, `last_login`, `role`) VALUES
(1, 'curtis', 'curtis@delicata.eu', '10180313ec28b097104bc89fab1d09d00dba1de942aa6e32e4', '6IVbcX3SwoRfbg1Z5YKwUkKzMU4cbCZl', 24, 1269981399, 'user'),
(2, 'Lewis', 'lewis@delicata.eu', 'da1658908899e09ad0ee3ca60fc32927d106637faf93dd4762', 'joUCS8Yp3AyGIbDHuJjdvwydH7KeSPMu', 2, 1269946236, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `user_facebook`
--

CREATE TABLE IF NOT EXISTS `user_facebook` (
  `facebook_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
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
  `user_id` int(11) NOT NULL,
  `time` int(10) NOT NULL,
  `history` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_histories`
--

INSERT INTO `user_histories` (`user_id`, `time`, `history`) VALUES
(1, 1268936308, 'Created the character: curtis'),
(1, 1269550854, 'Started a new battle agains Pig'),
(1, 1269706179, 'Started a new battle agains Strong Pig'),
(2, 1269810706, 'Created the character: Lewis'),
(2, 1269810716, 'Started a new battle agains Pig');

-- --------------------------------------------------------

--
-- Table structure for table `user_items`
--

CREATE TABLE IF NOT EXISTS `user_items` (
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_items`
--


-- --------------------------------------------------------

--
-- Table structure for table `zones`
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
-- Dumping data for table `zones`
--

INSERT INTO `zones` (`id`, `name`, `description`, `energy`, `x`, `y`) VALUES
(1, 'Norse Land', 'The ancient land of the Norse gods, created to bring peace to all remaining believers in the Norse mythology.', 20, 1, 1),
(2, 'Dev Land', 'The mystic area of development, still not sure why its here.', 10, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `zone_monster`
--

CREATE TABLE IF NOT EXISTS `zone_monster` (
  `zone_id` int(11) NOT NULL,
  `monster_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zone_monster`
--

INSERT INTO `zone_monster` (`zone_id`, `monster_id`) VALUES
(1, 1),
(1, 2),
(2, 2),
(2, 1);

