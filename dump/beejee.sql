--
-- Скрипт сгенерирован Devart dbForge Studio 2019 for MySQL, Версия 8.2.23.0
-- Домашняя страница продукта: http://www.devart.com/ru/dbforge/mysql/studio
-- Дата скрипта: 21.11.2019 3:14:42
-- Версия сервера: 5.7.25
-- Версия клиента: 4.1
--

-- 
-- Отключение внешних ключей
-- 
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

-- 
-- Установить режим SQL (SQL mode)
-- 
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- 
-- Установка кодировки, с использованием которой клиент будет посылать запросы на сервер
--
SET NAMES 'utf8';

--
-- Установка базы данных по умолчанию
--
USE beejee;

--
-- Удалить таблицу `tasks`
--
DROP TABLE IF EXISTS tasks;

--
-- Удалить таблицу `users`
--
DROP TABLE IF EXISTS users;

--
-- Установка базы данных по умолчанию
--
USE beejee;

--
-- Создать таблицу `users`
--
CREATE TABLE users (
  id int(11) NOT NULL AUTO_INCREMENT,
  name varchar(50) DEFAULT NULL,
  email varchar(50) DEFAULT NULL,
  password varchar(255) DEFAULT NULL,
  PRIMARY KEY (id)
)
ENGINE = INNODB,
AUTO_INCREMENT = 2,
CHARACTER SET utf8,
COLLATE utf8_general_ci,
COMMENT = 'Зарегистрированные пользователи';

--
-- Создать таблицу `tasks`
--
CREATE TABLE tasks (
  id int(11) NOT NULL AUTO_INCREMENT,
  text text NOT NULL,
  user_name varchar(255) NOT NULL,
  email varchar(50) NOT NULL,
  status tinyint(4) NOT NULL DEFAULT 0,
  created datetime NOT NULL,
  changed datetime DEFAULT NULL,
  PRIMARY KEY (id)
)
ENGINE = INNODB,
AUTO_INCREMENT = 18,
AVG_ROW_LENGTH = 963,
CHARACTER SET utf8,
COLLATE utf8_general_ci,
COMMENT = 'Задачи';

-- 
-- Вывод данных для таблицы users
--
INSERT INTO users VALUES
(1, 'admin', 'admin@admin.lo', '202cb962ac59075b964b07152d234b70');

-- 
-- Вывод данных для таблицы tasks
--
INSERT INTO tasks VALUES
(1, 'Уборка рабочего места', 'koko', 'koko@jam.bo', 1, '2019-11-13 00:00:00', NULL),
(2, 'Просмотр лекции', 'sobako', 'dog@mail.noy', 1, '2019-11-08 00:00:00', '2019-11-21 01:50:06'),
(3, 'ewf we we ew ew ew ewf ew!', 'bon', 'ede@rgr.rur', 0, '2019-11-07 00:00:00', '2019-11-21 01:53:14'),
(4, 'ewf we we ew ew ew ewf ew', 'milena', 'ede@rgr.ru', 0, '2019-11-17 00:00:00', NULL),
(5, 'ewf we we ew ew ew', 'ilena', 'ede@rgr.ru', 0, '2019-10-02 00:00:00', '2019-11-21 02:01:41'),
(6, 'ewf we we ew ew ew ewf ew', 'bon-milena', 'ede@rgr.ru', 0, '2019-11-08 00:00:00', NULL),
(7, 'ferf er erfref ref ', 'sdf', 'emaaaa@gg.ru', 0, '2019-11-19 00:00:00', NULL),
(8, 'ferf er erfref ref ', 'jggg', 'emaaaa@gg.ru', 0, '2019-11-15 00:00:00', NULL),
(9, 'ferf er erfref ref ', 'fhhjh', 'emaaaa@gg.ru', 0, '2019-11-04 00:00:00', NULL),
(10, 'uoipli;lo;yi', 'errrr', 'ed@ed.de', 0, '2019-09-04 00:00:00', NULL),
(11, 'uoipli;lo;yi', 'cat', 'ed@ed.de', 0, '2019-10-09 00:00:00', NULL),
(12, 'uoipli;lo;yi', 'admin', 'ed@ed.de', 1, '2019-10-25 00:00:00', NULL),
(13, 'wegfewrg', 'kuku', 'ere@fef.ru', 0, '2019-11-14 00:00:00', NULL),
(14, 'wegfewrg', 'укк', 'ere@fef.ru', 0, '2019-11-18 00:00:00', NULL),
(15, 'к4цн45н', 'dfff', 'mail@mail.com', 1, '2019-11-20 20:02:19', NULL),
(16, 'увцу цу в цув у', 'ууууу', 'vi@sok.ru', 0, '2019-11-20 22:43:07', NULL),
(17, 'alert(‘test’);', 'duda', 'ed@ed.de', 0, '2019-11-20 22:51:06', NULL);

-- 
-- Восстановить предыдущий режим SQL (SQL mode)
-- 
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;

-- 
-- Включение внешних ключей
-- 
/*!40014 SET FOREIGN_KEY_CHECKS = @OLD_FOREIGN_KEY_CHECKS */;