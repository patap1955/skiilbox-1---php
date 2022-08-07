-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 07 2022 г., 06:37
-- Версия сервера: 5.7.33
-- Версия PHP: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `store_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `admin_menu`
--

CREATE TABLE `admin_menu` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `admin_menu`
--

INSERT INTO `admin_menu` (`id`, `name`, `url`) VALUES
(1, 'Главная', '/'),
(2, 'Товары', '/admin/products/'),
(3, 'Заказы', '/admin/orders/'),
(4, 'Выйти', '?logout=yes');

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `name`, `url`) VALUES
(1, 'Все', '/'),
(2, 'Женщины', '/women/'),
(3, 'Мужчины', '/men/'),
(4, 'Дети', '/children/'),
(5, 'Аксессуары', '/accessories/');

-- --------------------------------------------------------

--
-- Структура таблицы `config`
--

CREATE TABLE `config` (
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci,
  `image_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `config`
--

INSERT INTO `config` (`name`, `value`, `image_id`) VALUES
('charset', 'utf-8', NULL),
('cost_delivery', '280', NULL),
('description', 'Fashion - интернет-магазин', NULL),
('favicon', NULL, 11),
('keywords', 'Fashion, интернет-магазин, одежда, аксессуары', NULL),
('lang', 'ru', NULL),
('logo', NULL, 10),
('logo-footer', NULL, 12),
('min_dilevery', '3000', NULL),
('theme-color', '#393939', NULL),
('title', 'Fashion', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `delivery`
--

CREATE TABLE `delivery` (
  `id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `delivery`
--

INSERT INTO `delivery` (`id`, `type`) VALUES
(1, 'Самовывоз'),
(2, 'Курьерная доставка');

-- --------------------------------------------------------

--
-- Структура таблицы `goods`
--

CREATE TABLE `goods` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `desc` text COLLATE utf8_unicode_ci,
  `price` decimal(10,0) NOT NULL DEFAULT '0',
  `sale` tinyint(1) NOT NULL DEFAULT '0',
  `new` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `goods`
--

INSERT INTO `goods` (`id`, `name`, `desc`, `price`, `sale`, `new`) VALUES
(2, 'Шорты и рубашка', NULL, '2999', 0, 1),
(3, 'Часы мужские', NULL, '2999', 0, 0),
(4, 'Штаны полосатые', NULL, '2999', 1, 0),
(5, 'Сумка кожаная', NULL, '2999', 1, 0),
(6, 'Очки красные', NULL, '2999', 1, 0),
(7, 'Плащ женский', NULL, '2999', 1, 0),
(8, 'Джинсы женские', NULL, '2999', 1, 1),
(9, 'Туфли женские', NULL, '2999', 1, 1),
(17, 'Рубашка на завязках', 'Модная мужская рубашка свободного покроя. Застежка выполнена в виде завязок спереди. На рубашке имеется воротник-стойка.', '5000', 1, 1),
(103, 'Кофточка красная женская', NULL, '4520', 0, 1),
(104, 'Свитер женский теплый с высоким горлом', NULL, '5500', 0, 1),
(105, 'World of Estiya / Свитер', NULL, '4200', 0, 1),
(106, 'AWER / Брюки', NULL, '4550', 1, 0),
(107, 'Брюки с накладными карманами', NULL, '1600', 0, 1),
(108, 'Брюки мужские', NULL, '3300', 0, 0),
(109, 'Кроссовки REEBOK REWIND', NULL, '7300', 0, 1),
(110, 'adidas / Кроссовки', NULL, '5500', 0, 1),
(111, 'Мужской классический деловой костюм', NULL, '8500', 1, 1),
(112, 'ТЕЛОДВИЖЕНИЯ / Тёплый, спортивный', NULL, '4000', 0, 0),
(113, 'Футболка мужская хлопковая', NULL, '450', 1, 1),
(114, 'Брюки из экокожи для девочки', NULL, '1500', 1, 1),
(115, 'Брюки Reimatec Lento', NULL, '3500', 0, 1),
(116, 'Superfit / Кроссовки', NULL, '7500', 0, 0),
(117, ' Ботинки ', NULL, '2500', 0, 1),
(118, ' Кофта флисовая / Детская толстовка', NULL, '1200', 0, 1),
(119, 'НадевайКа / Джемпер', NULL, '1000', 0, 1),
(120, 'Ali-O / Джемпер ', NULL, '4200', 1, 0),
(121, 'Sabotage / Джемпер', NULL, '3000', 1, 0),
(122, 'Комбинезон Reimatec Copenhagen', NULL, '5100', 0, 0),
(123, 'RICH PEACH / Рубашка', NULL, '1000', 1, 1),
(124, 'RICH PEACH / Рубашка', NULL, '1000', 1, 1),
(125, 'RICH PEACH Рубашка', NULL, '1000', 1, 1),
(126, ' ReSelf / Солнцезащитные очки ', NULL, '3500', 0, 0),
(127, 'Шляпа Федора', NULL, '2559', 1, 1),
(128, 'Бейсболка женская, мужская, детская.', NULL, '450', 1, 1),
(129, 'Бейсболка это бессменный и модный тренд', NULL, '550', 1, 0),
(130, 'Мужской зонт-автомат', NULL, '2700', 0, 1),
(131, 'ТРИ СЛОНА / Зонт, D 104см. ', NULL, '3000', 1, 1),
(132, ' KSAS / Перчатки ', NULL, '665', 0, 0),
(133, 'Ремень с люверсами', NULL, '320', 1, 1),
(134, 'Портмоне мужское из натуральной кожи', NULL, '3350', 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `goods_orders`
--

CREATE TABLE `goods_orders` (
  `good_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `good_category`
--

CREATE TABLE `good_category` (
  `good_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `good_category`
--

INSERT INTO `good_category` (`good_id`, `category_id`) VALUES
(2, 2),
(4, 2),
(5, 2),
(6, 2),
(7, 2),
(8, 2),
(9, 2),
(103, 2),
(104, 2),
(105, 2),
(3, 3),
(17, 3),
(106, 3),
(107, 3),
(108, 3),
(109, 3),
(110, 3),
(111, 3),
(112, 3),
(113, 3),
(114, 4),
(115, 4),
(116, 4),
(117, 4),
(118, 4),
(119, 4),
(120, 4),
(121, 4),
(122, 4),
(125, 4),
(3, 5),
(126, 5),
(127, 5),
(128, 5),
(129, 5),
(130, 5),
(131, 5),
(132, 5),
(133, 5),
(134, 5);

-- --------------------------------------------------------

--
-- Структура таблицы `good_image`
--

CREATE TABLE `good_image` (
  `good_id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `good_image`
--

INSERT INTO `good_image` (`good_id`, `image_id`) VALUES
(2, 96),
(3, 97),
(4, 98),
(5, 99),
(6, 100),
(7, 101),
(8, 102),
(17, 104),
(9, 105),
(103, 106),
(104, 107),
(105, 108),
(106, 109),
(107, 110),
(108, 111),
(109, 112),
(110, 113),
(111, 114),
(112, 115),
(113, 116),
(114, 117),
(115, 118),
(116, 119),
(117, 120),
(118, 121),
(119, 122),
(120, 123),
(121, 124),
(122, 125),
(125, 126),
(126, 127),
(127, 128),
(128, 129),
(129, 130),
(130, 131),
(131, 132),
(132, 133),
(133, 134),
(134, 135);

-- --------------------------------------------------------

--
-- Структура таблицы `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `groups`
--

INSERT INTO `groups` (`id`, `name`) VALUES
(1, 'Администратор'),
(2, 'Покупатель');

-- --------------------------------------------------------

--
-- Структура таблицы `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `alt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `images`
--

INSERT INTO `images` (`id`, `link`, `alt`) VALUES
(10, '/templates/img/logo.svg', 'Fashion'),
(11, '/templates/img/favicon.png', NULL),
(12, '/templates/img/logo--footer.svg', NULL),
(14, '/templates/img/products/cream-hat.jpg', NULL),
(15, '/templates/img/products/cream-shoes.jpg', NULL),
(16, '/templates/img/products/gray.jpg', NULL),
(17, '/templates/img/products/haki.jpg', NULL),
(18, '/templates/img/products/jacket.jpg', NULL),
(19, '/templates/img/products/man.jpg', NULL),
(20, '/templates/img/products/school-dress.jpg', NULL),
(21, '/templates/img/products/snood.jpg', NULL),
(22, '/templates/img/products/sport-jacket.jpg', NULL),
(23, '/templates/img/products/white.jpg', NULL),
(24, '/templates/img/products/sparkles-shoes.jpg', NULL),
(25, '/templates/img/products/strong.jpg', NULL),
(26, '/templates/img/products/white-dress.jpg', NULL),
(27, '/templates/img/products/yoga.jpg', NULL),
(28, '/templates/img/products/mongol.jpg', NULL),
(29, '/templates/img/products/winter-shoes.jpg', NULL),
(30, '/templates/img/products/skin.jpg', NULL),
(31, '/templates/img/products/bear.jpg', NULL),
(32, '/templates/img/products/atlas.jpg', NULL),
(33, '/templates/img/products/ghavai.jpg', NULL),
(34, '/templates/img/products/white-pants.jpg', NULL),
(35, '/templates/img/products/string.jpg', NULL),
(36, '/templates/img/products/kruj.jpg', NULL),
(37, '/templates/img/products/green.jpg', NULL),
(38, '/templates/img/products/puma.jpg', NULL),
(39, '/templates/img/products/rose.jpg', NULL),
(40, '/templates/img/products/today.jpg', NULL),
(41, '/templates/img/products/serf.jpg', NULL),
(42, '/templates/img/products/pretty-shoes.jpg', NULL),
(43, '/templates/img/products/black-orange.jpg', NULL),
(44, '/templates/img/products/error.jpg', NULL),
(45, '/templates/img/products/striped-jacket.jpg', NULL),
(46, '/templates/img/products/stretch-blue.jpg', NULL),
(47, '/templates/img/products/blue.jpg', NULL),
(48, '/templates/img/products/legs-shoes.jpg', NULL),
(49, '/templates/img/products/jacket-light.jpg', NULL),
(50, '/templates/img/products/made.jpg', NULL),
(51, '/templates/img/products/blondie.jpg', NULL),
(52, '/templates/img/products/usa.jpg', NULL),
(53, '/templates/img/products/suit.jpg', NULL),
(86, '/templates/img/new/spacex.jpeg', NULL),
(87, '/templates/img/new/roadster-earth.png', NULL),
(88, '/templates/img/new/product-1.jpg', NULL),
(89, '/templates/img/new/product-6.jpg', NULL),
(90, '/templates/img/new/product-6.jpg', NULL),
(91, '/templates/img/new/product-6.jpg', NULL),
(92, '/templates/img/new/product-6.jpg', NULL),
(93, '/templates/img/new/product-2.jpg', NULL),
(94, '/templates/img/new/product-2.jpg', NULL),
(95, '/templates/img/new/product-2.jpg', NULL),
(96, '/templates/img/new/product-2.jpg', NULL),
(97, '/templates/img/new/product-3.jpg', NULL),
(98, '/templates/img/new/product-4.jpg', NULL),
(99, '/templates/img/new/product-5.jpg', NULL),
(100, '/templates/img/new/product-6.jpg', NULL),
(101, '/templates/img/new/product-7.jpg', NULL),
(102, '/templates/img/new/product-8.jpg', NULL),
(103, '/templates/img/new/product-9.jpg', NULL),
(104, '/templates/img/new/product-2.jpg', NULL),
(105, '/templates/img/new/product-3.jpg', NULL),
(106, '/templates/img/new/product-6.jpg', NULL),
(107, '/templates/img/new/canvas.png', NULL),
(108, '/templates/img/new/canvas.png', NULL),
(109, '/templates/img/new/canvas3.png', NULL),
(110, '/templates/img/new/canvas4.png', NULL),
(111, '/templates/img/new/canvas5.png', NULL),
(112, '/templates/img/new/canvas6.png', NULL),
(113, '/templates/img/new/canvas7.png', NULL),
(114, '/templates/img/new/canvas8.png', NULL),
(115, '/templates/img/new/canvas9.png', NULL),
(116, '/templates/img/new/canvas10.png', NULL),
(117, '/templates/img/new/canvas11.png', NULL),
(118, '/templates/img/new/canvas12.png', NULL),
(119, '/templates/img/new/canvas13.png', NULL),
(120, '/templates/img/new/canvas14.png', NULL),
(121, '/templates/img/new/canvas15.png', NULL),
(122, '/templates/img/new/canvas16.png', NULL),
(123, '/templates/img/new/canvas17.png', NULL),
(124, '/templates/img/new/canvas18.png', NULL),
(125, '/templates/img/new/canvas19.png', NULL),
(126, '/templates/img/new/canvas20.png', NULL),
(127, '/templates/img/new/canvas21.png', NULL),
(128, '/templates/img/new/canvas22.png', NULL),
(129, '/templates/img/new/canvas23.png', NULL),
(130, '/templates/img/new/canvas24.png', NULL),
(131, '/templates/img/new/canvas25.png', NULL),
(132, '/templates/img/new/canvas26.png', NULL),
(133, '/templates/img/new/canvas27.png', NULL),
(134, '/templates/img/new/canvas28.png', NULL),
(135, '/templates/img/new/canvas29.png', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `menu`
--

CREATE TABLE `menu` (
  `int` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `menu`
--

INSERT INTO `menu` (`int`, `name`, `url`) VALUES
(1, 'Главная', '/'),
(2, 'Новинки', '/?new=on'),
(3, 'Sale', '/?sale=on'),
(4, 'Доставка', '/delivery/');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `surname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `patronymic` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `mail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `delivery_id` int(11) NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `street` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `home` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `app` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment_id` int(11) NOT NULL,
  `comment` text COLLATE utf8_unicode_ci,
  `goods` int(11) NOT NULL,
  `sum` int(11) NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `surname`, `name`, `patronymic`, `phone`, `mail`, `delivery_id`, `city`, `street`, `home`, `app`, `payment_id`, `comment`, `goods`, `sum`, `completed`, `date`) VALUES
(8, 'Ivanov', 'Ivan', 'Ivanovich', '+79999999999', 'test@gmail.com', 1, NULL, NULL, NULL, NULL, 1, 'New comment', 36, 6000, 1, '2020-03-21 22:15:56'),
(9, 'Петров', 'Петр', 'Петрович', '+79999999999', 'petrovich@gmail.com', 2, 'Санкт-Петербург', 'Средний проспект В.О.', '10', '15', 1, 'Доставить побыстрее', 32, 9000, 1, '2020-02-20 22:16:13'),
(10, 'Дмитриенко', 'Виктория', 'Вячеславовна', '+79999999999', 'vika@mail.ru', 2, 'Таганчик', 'Греческая', '33', '13', 1, '', 39, 4000, 0, '2020-01-20 22:16:18'),
(11, 'TEST', 'TEST', '', '+79999999999', 't@gmail.com', 1, NULL, NULL, NULL, NULL, 1, 'TEST TEST', 40, 7000, 1, '2020-05-20 21:46:30'),
(12, 'Bdfghh', 'FGHJJK', '', '9621459300', 'DFGH@NB.RE', 1, NULL, NULL, NULL, NULL, 1, '', 24, 6000, 1, '2022-04-07 03:57:55');

-- --------------------------------------------------------

--
-- Структура таблицы `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `payment`
--

INSERT INTO `payment` (`id`, `type`) VALUES
(1, 'Наличные'),
(2, 'Банковской картой');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `groups` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `groups`) VALUES
(1, 'Петрович', 'admin@admin.com', '$2y$10$n0x791A9boypkpfz9dEnFe6AjlcOkFC.rHxT2qkAisB7owlYnVDh.', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `user_group`
--

CREATE TABLE `user_group` (
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `user_group`
--

INSERT INTO `user_group` (`user_id`, `group_id`) VALUES
(1, 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `admin_menu`
--
ALTER TABLE `admin_menu`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `config`
--
ALTER TABLE `config`
  ADD UNIQUE KEY `config_name_uindex` (`name`),
  ADD KEY `config_images_id_fk` (`image_id`);

--
-- Индексы таблицы `delivery`
--
ALTER TABLE `delivery`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `goods`
--
ALTER TABLE `goods`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `goods_orders`
--
ALTER TABLE `goods_orders`
  ADD PRIMARY KEY (`good_id`,`order_id`),
  ADD KEY `goods_orders_orders_id_fk` (`order_id`);

--
-- Индексы таблицы `good_category`
--
ALTER TABLE `good_category`
  ADD PRIMARY KEY (`good_id`,`category_id`),
  ADD KEY `good_category_categories_id_fk` (`category_id`);

--
-- Индексы таблицы `good_image`
--
ALTER TABLE `good_image`
  ADD PRIMARY KEY (`good_id`,`image_id`),
  ADD KEY `good_image_images_id_fk` (`image_id`);

--
-- Индексы таблицы `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`int`),
  ADD UNIQUE KEY `menu_name_uindex` (`name`),
  ADD UNIQUE KEY `menu_url_uindex` (`url`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_delivery_id_fk` (`delivery_id`),
  ADD KEY `orders_payment_id_fk` (`payment_id`);

--
-- Индексы таблицы `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_uindex` (`email`),
  ADD KEY `users_groups_id_fk` (`groups`);

--
-- Индексы таблицы `user_group`
--
ALTER TABLE `user_group`
  ADD PRIMARY KEY (`user_id`,`group_id`),
  ADD KEY `user_group_groups_id_fk` (`group_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `admin_menu`
--
ALTER TABLE `admin_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `delivery`
--
ALTER TABLE `delivery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `goods`
--
ALTER TABLE `goods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT для таблицы `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT для таблицы `menu`
--
ALTER TABLE `menu`
  MODIFY `int` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `config`
--
ALTER TABLE `config`
  ADD CONSTRAINT `config_images_id_fk` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `goods_orders`
--
ALTER TABLE `goods_orders`
  ADD CONSTRAINT `goods_orders_goods_id_fk` FOREIGN KEY (`good_id`) REFERENCES `goods` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `goods_orders_orders_id_fk` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `good_category`
--
ALTER TABLE `good_category`
  ADD CONSTRAINT `good_category_categories_id_fk` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `good_category_goods_id_fk` FOREIGN KEY (`good_id`) REFERENCES `goods` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `good_image`
--
ALTER TABLE `good_image`
  ADD CONSTRAINT `good_image_goods_id_fk` FOREIGN KEY (`good_id`) REFERENCES `goods` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `good_image_images_id_fk` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_groups_id_fk` FOREIGN KEY (`groups`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `user_group`
--
ALTER TABLE `user_group`
  ADD CONSTRAINT `user_group_groups_id_fk` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_group_users_id_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
