-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.6.17 - MySQL Community Server (GPL)
-- ОС Сервера:                   Win64
-- HeidiSQL Версия:              9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Дамп структуры для таблица yii2.ytp_budget_item
CREATE TABLE IF NOT EXISTS `ytp_budget_item` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы yii2.ytp_budget_item: ~6 rows (приблизительно)
/*!40000 ALTER TABLE `ytp_budget_item` DISABLE KEYS */;
INSERT INTO `ytp_budget_item` (`id`, `name`) VALUES
	(1, 'Еда'),
	(2, 'Квартплата'),
	(3, 'Одежда'),
	(4, 'Развлечения'),
	(5, 'Депозиты'),
	(6, 'Зарплата');
/*!40000 ALTER TABLE `ytp_budget_item` ENABLE KEYS */;


-- Дамп структуры для таблица yii2.ytp_currency
CREATE TABLE IF NOT EXISTS `ytp_currency` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы yii2.ytp_currency: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `ytp_currency` DISABLE KEYS */;
INSERT INTO `ytp_currency` (`id`, `name`) VALUES
	(2, 'Доллар США'),
	(3, 'Российский рубль');
/*!40000 ALTER TABLE `ytp_currency` ENABLE KEYS */;


-- Дамп структуры для таблица yii2.ytp_operation
CREATE TABLE IF NOT EXISTS `ytp_operation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL DEFAULT '0',
  `amount` bigint(20) NOT NULL DEFAULT '0',
  `currency_id` smallint(6) NOT NULL DEFAULT '0',
  `budget_item_id` smallint(6) NOT NULL DEFAULT '0',
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `created` int(11) NOT NULL DEFAULT '0',
  `updated` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_cost_currency` (`currency_id`),
  KEY `FK_cost_budget_item` (`budget_item_id`),
  CONSTRAINT `FK_cost_budget_item` FOREIGN KEY (`budget_item_id`) REFERENCES `ytp_budget_item` (`id`),
  CONSTRAINT `FK_cost_currency` FOREIGN KEY (`currency_id`) REFERENCES `ytp_currency` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы yii2.ytp_operation: ~5 rows (приблизительно)
/*!40000 ALTER TABLE `ytp_operation` DISABLE KEYS */;
INSERT INTO `ytp_operation` (`id`, `name`, `amount`, `currency_id`, `budget_item_id`, `type`, `created`, `updated`) VALUES
	(7, 'Какая-то сумма в рублях на одежду', 1570010, 3, 3, 0, 1425600000, 1447571648),
	(8, 'Отправка денег на срочный вклад', 5030075, 2, 5, 0, 1444435200, 1447662787),
	(9, 'Доход со вклада', 519278, 3, 5, 1, 1447200000, 1447587447),
	(10, 'Аванс', 1570020, 3, 6, 1, 1444953600, 1447574521),
	(11, 'Доход по депозиту', 582322, 3, 5, 1, 1446681600, 1447587115);
/*!40000 ALTER TABLE `ytp_operation` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
