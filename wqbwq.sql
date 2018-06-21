-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Час створення: Трв 21 2018 р., 02:26
-- Версія сервера: 10.0.33-MariaDB
-- Версія PHP: 5.6.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- База даних: `iq_vila`
--

-- --------------------------------------------------------

--
-- Структура таблиці `content`
--

CREATE TABLE `content` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` char(16) DEFAULT NULL,
    `type_id` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `slug` varchar(128) DEFAULT NULL,
  `system` tinyint(1) UNSIGNED NOT NULL,
  `thumbnail` int(11) UNSIGNED DEFAULT NULL,
  `crop_info` varchar(255) NOT NULL,

  `page_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,

  `to_main` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',

  `image` varchar(128) DEFAULT NULL,
  `pre_image` varchar(255) NOT NULL,



  `publish_date` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT '0',
  `views` int(11) DEFAULT '0',
  `status` tinyint(1) DEFAULT '1',

   `title` varchar(128) NOT NULL,
  `short` varchar(1024) DEFAULT NULL,
  `text` text NOT NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`),
  ADD KEY (`page_id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `type_id` (`type_id`),
  ADD KEY `to_main` (`to_main`),
  ADD KEY `category_id` (`category_id`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `content`
--
ALTER TABLE `content`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;
