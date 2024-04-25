-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 10.0.0.79
-- Время создания: Ноя 07 2020 г., 19:58
-- Версия сервера: 5.7.26-29
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `potok4_gorizont`
--

-- --------------------------------------------------------

--
-- Структура таблицы `banners`
--

CREATE TABLE `banners` (
  `id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `head` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `show` int(1) NOT NULL,
  `text` text NOT NULL,
  `url` varchar(255) NOT NULL,
  `rate` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `banners`
--

INSERT INTO `banners` (`id`, `path`, `head`, `show`, `text`, `url`, `rate`) VALUES
(2, '1568110821.jpg', '', 1, '', '', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `catalog`
--

CREATE TABLE `catalog` (
  `id` int(11) NOT NULL,
  `show` int(1) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `short` text,
  `text` text,
  `url` varchar(255) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `path2` varchar(255) DEFAULT NULL,
  `rate` int(11) DEFAULT NULL,
  `catalog_cat` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `catalog`
--

INSERT INTO `catalog` (`id`, `show`, `name`, `short`, `text`, `url`, `path`, `path2`, `rate`, `catalog_cat`) VALUES
(1, 1, 'Салат зеленый, японский', NULL, '', 'salat-zeleniy-yaponskiy', '1604766081.jpg', NULL, 0, 3),
(2, 1, 'Салат', NULL, '', 'salat', '1604767888.jpg', NULL, 0, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `catalog_cat`
--

CREATE TABLE `catalog_cat` (
  `id` int(11) NOT NULL,
  `show` int(1) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `text` text,
  `url` varchar(255) DEFAULT NULL,
  `rate` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `catalog_cat`
--

INSERT INTO `catalog_cat` (`id`, `show`, `name`, `text`, `url`, `rate`) VALUES
(1, 1, 'Фрукты', NULL, 'frukti', 0),
(2, 1, 'Овощи', NULL, 'ovoschi', 0),
(3, 1, 'Листовые овощи', NULL, 'listovie-ovoschi', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `show` tinyint(11) NOT NULL DEFAULT '1',
  `name` text COLLATE utf8_unicode_ci,
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` int(11) DEFAULT NULL,
  `opis` text COLLATE utf8_unicode_ci,
  `text` longtext COLLATE utf8_unicode_ci,
  `rate` int(11) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `files_type`
--

CREATE TABLE `files_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `ids` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `path_small` varchar(255) NOT NULL,
  `path_big` varchar(255) NOT NULL,
  `path_middle` varchar(255) NOT NULL,
  `rate` int(11) NOT NULL,
  `color` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ids` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name3` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name4` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `text` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `items`
--

INSERT INTO `items` (`id`, `type`, `ids`, `name`, `name2`, `name3`, `name4`, `text`) VALUES
(6, 'article', 2, '1111', NULL, NULL, NULL, NULL),
(7, 'article', 2, '222', NULL, NULL, NULL, NULL),
(8, 'catalog', 1, 'Заголовок', 'Название', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `page`
--

CREATE TABLE `page` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `opis` text COLLATE utf8_unicode_ci,
  `text` longtext COLLATE utf8_unicode_ci NOT NULL,
  `top` tinyint(1) NOT NULL,
  `rate` int(11) DEFAULT NULL,
  `show` tinyint(1) NOT NULL DEFAULT '1',
  `menu` int(11) NOT NULL DEFAULT '0',
  `foot_menu` tinyint(1) NOT NULL DEFAULT '0',
  `foot_menu2` tinyint(1) NOT NULL DEFAULT '0',
  `path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `path2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `path3` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `page` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `keywords` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `page`
--

INSERT INTO `page` (`id`, `name`, `name2`, `url`, `opis`, `text`, `top`, `rate`, `show`, `menu`, `foot_menu`, `foot_menu2`, `path`, `path2`, `path3`, `page`, `title`, `keywords`, `description`) VALUES
(1, 'Главная', '', 'glavnaya', '', '', 0, 0, 1, 0, 0, 0, NULL, NULL, NULL, 0, '', '', ''),
(2, 'Каталог', '', 'catalog', '', '', 0, 0, 1, 0, 0, 0, NULL, NULL, NULL, 0, '', '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `sends`
--

CREATE TABLE `sends` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `date` int(11) DEFAULT NULL,
  `mail` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `text` text,
  `type` varchar(255) DEFAULT NULL,
  `page` int(255) DEFAULT NULL,
  `arhiv` tinyint(1) DEFAULT '0',
  `status` tinyint(1) DEFAULT '0',
  `url` varchar(255) DEFAULT NULL,
  `read` tinyint(1) NOT NULL DEFAULT '0',
  `lastmod` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` varchar(255) DEFAULT NULL,
  `created_at` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `sends_type`
--

CREATE TABLE `sends_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `seo`
--

CREATE TABLE `seo` (
  `id` int(11) NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `opis` text COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `keywords` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(500) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `setting`
--

CREATE TABLE `setting` (
  `id` int(11) NOT NULL DEFAULT '0',
  `lastmod` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `site_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `phone2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone3` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_pre` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_pre2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_pre3` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mail` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `mailsend` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `soc1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `soc2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `soc3` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8_unicode_ci,
  `coords` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `path` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `path2` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `agree` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `setting`
--

INSERT INTO `setting` (`id`, `lastmod`, `site_name`, `phone`, `phone2`, `phone3`, `phone_pre`, `phone_pre2`, `phone_pre3`, `mail`, `mailsend`, `soc1`, `soc2`, `soc3`, `address`, `coords`, `path`, `path2`, `title`, `agree`) VALUES
(1, '2020-11-07 16:36:36', 'New project', '313-01-11', '', '', '+7 812', '', '', 'nsx89@mail.ru', 'nsx89@mail.ru', 'https:/vk.com/', 'https://facebook.com/', 'https://instagram.com/', 'ул. Курская, д.27', '59.931510,30.313226', '1568804105.png', '1568968714.jpg', 'мест осталось\r\nна поставку\r\nсвежих овощей', 'http://www.kremlin.ru/acts/bank/24154/page/1');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `lastmod` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `login` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sault` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hash` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hash_reg` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `verified` tinyint(1) DEFAULT NULL,
  `regdate` int(11) DEFAULT NULL,
  `lastvisit` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `class` int(11) DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `lastname` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `otch` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `menu` int(11) DEFAULT NULL,
  `view` tinyint(1) DEFAULT NULL,
  `font` tinyint(1) DEFAULT NULL,
  `light` tinyint(1) DEFAULT NULL,
  `company` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `subs` tinyint(1) DEFAULT NULL,
  `gender` tinyint(1) DEFAULT NULL,
  `ava` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birthday` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `auto` tinyint(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `lastmod`, `login`, `email`, `password`, `sault`, `hash`, `hash_reg`, `verified`, `regdate`, `lastvisit`, `class`, `name`, `lastname`, `otch`, `menu`, `view`, `font`, `light`, `company`, `address`, `contact`, `phone`, `type`, `subs`, `gender`, `ava`, `birthday`, `auto`) VALUES
(1, '2015-01-29 12:42:18', 'admin', '', '9c60633a432925a458f080a43cdf2f69', '359950e23ac12ff7b76e9e3c12377824', NULL, NULL, 1, 1402991924, '1422535338', 1, '', '', NULL, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, 0, NULL, NULL, 0),
(2, '2019-09-06 12:49:06', '9515', 'degurn99@mail.ru', '3f0054400157bdc014ecd74e95c7b67d', '228246ccf6a46f947afe45aed1b5259b', '7bc263fb722ef84379565cc3f7961492', NULL, 1, 1420888166, '1567774146', 1, NULL, NULL, NULL, 0, 1, 0, 1, NULL, NULL, NULL, NULL, 1, 0, 0, NULL, NULL, 0),
(14, '2020-01-23 11:00:24', 'Lara400', '', 'a08b6488cd2bb57f4665703fb88860e7', '1d4f264eacbd69b8e8794a46fa40fefe', NULL, NULL, 0, 1428046068, '1579777224', 1, NULL, NULL, NULL, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, 0, NULL, NULL, 0),
(32, '2019-12-10 10:52:53', 'albert', 'nsx89st@gmail.com', '13dd0a568af6bb5fdb5d7bf8efd442dd', 'e29092b3617cce310e4d26a26c2b915c', NULL, NULL, 0, 0, '1575975173', 1, NULL, NULL, NULL, 0, 0, 0, 0, 'Газпром', NULL, 'Тестов Тест', '+7 (123) 123-12-36', 2, 0, NULL, '32-1572882967.jpg', NULL, 0),
(61, '2020-11-07 16:57:52', 'test', '', 'bc848368294343144c18f82337260210', '0719b4fa5f775ffa5e7969261d0d716d', NULL, NULL, 0, 1567755309, '1604768272', 1, NULL, NULL, NULL, 0, 0, 0, 0, NULL, NULL, NULL, NULL, 1, 0, 0, NULL, NULL, 0),
(76, '2019-11-06 11:45:33', 'nsx89@mail.ru', 'nsx89@mail.ru', '649f8524b96bc5e5175960cfcfdb0db3', 'cea65690b705b3daeb6ae189935a71e3', '7190cfd93d5e2f7a209688a9acc1b953', 'f2468672a431fbd17de17a2becf932c2', 1, 1571301197, '1573040733', 4, '11', '22', NULL, NULL, 0, 0, 0, NULL, NULL, NULL, '+7 (333) 333-33-33', 1, 1, 1, NULL, '21.03.1989', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `user_class`
--

CREATE TABLE `user_class` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `user_class`
--

INSERT INTO `user_class` (`id`, `name`) VALUES
(1, 'Администратор'),
(4, 'Обычный пользователь');

-- --------------------------------------------------------

--
-- Структура таблицы `user_type`
--

CREATE TABLE `user_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `user_type`
--

INSERT INTO `user_type` (`id`, `name`) VALUES
(1, 'Физ. лицо'),
(2, 'Юр. лицо');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `catalog`
--
ALTER TABLE `catalog`
  ADD PRIMARY KEY (`id`),
  ADD KEY `catalog_cat` (`catalog_cat`);

--
-- Индексы таблицы `catalog_cat`
--
ALTER TABLE `catalog_cat`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `files_type`
--
ALTER TABLE `files_type`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ids` (`ids`);

--
-- Индексы таблицы `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`),
  ADD KEY `ids` (`ids`);

--
-- Индексы таблицы `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`id`),
  ADD KEY `show` (`show`),
  ADD KEY `url` (`url`);

--
-- Индексы таблицы `sends`
--
ALTER TABLE `sends`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `sends_type`
--
ALTER TABLE `sends_type`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `seo`
--
ALTER TABLE `seo`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user_class`
--
ALTER TABLE `user_class`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `catalog`
--
ALTER TABLE `catalog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `catalog_cat`
--
ALTER TABLE `catalog_cat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `files_type`
--
ALTER TABLE `files_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `page`
--
ALTER TABLE `page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `sends`
--
ALTER TABLE `sends`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `sends_type`
--
ALTER TABLE `sends_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `seo`
--
ALTER TABLE `seo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT для таблицы `user_class`
--
ALTER TABLE `user_class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `user_type`
--
ALTER TABLE `user_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
