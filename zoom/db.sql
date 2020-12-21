-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2020-12-20 23:29:15
-- 服务器版本： 8.0.22
-- PHP 版本： 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `awesome_zoom`
--
CREATE DATABASE IF NOT EXISTS `awesome_zoom` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `awesome_zoom`;

-- --------------------------------------------------------

--
-- 表的结构 `config`
--

DROP TABLE IF EXISTS `config`;
CREATE TABLE IF NOT EXISTS `config` (
  `key` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'config key',
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COMMENT 'config value',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'data type 0:notjson;1:json',
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='system config';

--
-- 插入之前先把表清空（truncate） `config`
--

TRUNCATE TABLE `config`;
--
-- 转存表中的数据 `config`
--

INSERT INTO `config` (`key`) VALUES
('ZOOM_API_KEY'),
('ZOOM_API_SECRET'),
('ZOOM_IM_TOKEN'),
('ZOOM_JWT_TOKEN'),
('ZOOM_CLIENT_ID'),
('ZOOM_CLIENT_SECRET'),
('ZOOM_SDK_KEY'),
('ZOOM_SDK_SECRET');

-- --------------------------------------------------------

--
-- 表的结构 `match`
--

DROP TABLE IF EXISTS `match`;
CREATE TABLE IF NOT EXISTS `match` (
  `id` bigint NOT NULL AUTO_INCREMENT COMMENT 'row id',
  `host_id` bigint NOT NULL COMMENT 'host user id',
  `user_id` bigint DEFAULT NULL COMMENT 'guest user id',
  `create_time` bigint DEFAULT NULL COMMENT 'create time',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='player match';

--
-- 插入之前先把表清空（truncate） `match`
--

TRUNCATE TABLE `match`;
-- --------------------------------------------------------

--
-- 表的结构 `meeting`
--

DROP TABLE IF EXISTS `meeting`;
CREATE TABLE IF NOT EXISTS `meeting` (
  `id` bigint NOT NULL AUTO_INCREMENT COMMENT 'row id',
  `user_id` bigint NOT NULL COMMENT 'user id',
  `meeting_id` bigint NOT NULL COMMENT 'meeting id',
  `password` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'meeting password',
  `create_time` bigint NOT NULL COMMENT 'create time',
  PRIMARY KEY (`id`),
  UNIQUE KEY `meeting_id` (`meeting_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='meeting';

--
-- 插入之前先把表清空（truncate） `meeting`
--

TRUNCATE TABLE `meeting`;
-- --------------------------------------------------------

--
-- 表的结构 `oauth_token`
--

DROP TABLE IF EXISTS `oauth_token`;
CREATE TABLE IF NOT EXISTS `oauth_token` (
  `id` bigint NOT NULL AUTO_INCREMENT COMMENT 'row id',
  `user_id` bigint NOT NULL COMMENT 'user id',
  `token_type` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'token type',
  `access_token` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'access token',
  `refresh_token` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'refresh token',
  `expires` int NOT NULL COMMENT 'expires time',
  `create_time` bigint NOT NULL COMMENT 'create time',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='OAuth token';

--
-- 插入之前先把表清空（truncate） `oauth_token`
--

TRUNCATE TABLE `oauth_token`;
-- --------------------------------------------------------

--
-- 表的结构 `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `session_id` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'session id',
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT 'player name',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'status',
  `create_time` bigint NOT NULL COMMENT 'create time',
  PRIMARY KEY (`session_id`),
  UNIQUE KEY `session_id` (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 插入之前先把表清空（truncate） `user`
--

TRUNCATE TABLE `user`;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
