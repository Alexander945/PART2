-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Час створення: Сер 08 2021 р., 07:26
-- Версія сервера: 10.4.20-MariaDB
-- Версія PHP: 7.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `shop`
--

DELIMITER $$
--
-- Процедури
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `create_goods` (IN `code` VARCHAR(6), IN `name` VARCHAR(50), IN `price` FLOAT, IN `volume_count` INT, IN `volume_price` FLOAT)  BEGIN
    IF NOT EXISTS(SELECT 1 FROM goods WHERE goods.code = code) THEN
	SET @s = 'INSERT INTO goods (goods.code, goods.name, goods.price, goods.volume_count, goods.volume_price) VALUES(?, ?, ?, ?, ?)';
        PREPARE stmt FROM @s;
	EXECUTE stmt USING code, name, price, volume_count, volume_price;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delete_goods` (IN `code` VARCHAR(6))  BEGIN 
    IF EXISTS(SELECT 1 FROM goods WHERE goods.code = code) THEN
        DELETE FROM goods WHERE goods.code = code;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_goods` (IN `code` VARCHAR(6), IN `name` VARCHAR(50), IN `price` FLOAT, IN `volume_count` INT, IN `volume_price` FLOAT)  BEGIN
    IF EXISTS(SELECT 1 FROM goods WHERE goods.code = code) THEN
	SET @s = 'UPDATE goods SET goods.name=?, goods.price=?, goods.volume_count=?, goods.volume_price=? WHERE goods.code = ?';
        PREPARE stmt FROM @s;
	EXECUTE stmt USING name, price, volume_count, volume_price, code;
    END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Структура таблиці `goods`
--

CREATE TABLE `goods` (
  `code` varchar(6) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `volume_count` int(11) DEFAULT NULL,
  `volume_price` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп даних таблиці `goods`
--

INSERT INTO `goods` (`code`, `name`, `price`, `volume_count`, `volume_price`) VALUES
('A', 'Apple', 2, 4, 7),
('B', 'Pineapple', 12, 0, 0),
('C', 'Peach', 1.25, 6, 6),
('D', 'Nut', 0.15, 0, 0);

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `goods`
--
ALTER TABLE `goods`
  ADD PRIMARY KEY (`code`),
  ADD UNIQUE KEY `code` (`code`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
