-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               10.3.25-MariaDB-0+deb10u1 - Debian 10
-- Операционная система:         debian-linux-gnu
-- HeidiSQL Версия:              11.1.0.6116
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Дамп структуры базы данных grcentral_base
CREATE DATABASE IF NOT EXISTS `grcentral_base` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `grcentral_base`;

-- Дамп структуры для таблица grcentral_base.devices_data
CREATE TABLE IF NOT EXISTS `devices_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mac_addr` varchar(12) DEFAULT NULL,
  `ip_addr` varchar(15) DEFAULT NULL,
  `model_id` int(11) DEFAULT NULL,
  `status_online` tinyint(4) DEFAULT NULL,
  `status_active` tinyint(4) unsigned DEFAULT NULL,
  `descr` varchar(250) DEFAULT NULL,
  `accounts_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `fw_version` varchar(50) DEFAULT NULL,
  `fw_version_pinned` varchar(50) DEFAULT NULL,
  `admin_password` varchar(50) DEFAULT NULL,
  `params_source_data` text DEFAULT NULL,
  `params_json_data` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `mac_addr` (`mac_addr`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица grcentral_base.logs_data
CREATE TABLE IF NOT EXISTS `logs_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) DEFAULT NULL,
  `log_data` text DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица grcentral_base.phonebook_data
CREATE TABLE IF NOT EXISTS `phonebook_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `phone_work` varchar(50) DEFAULT NULL,
  `data_source` varchar(50) DEFAULT NULL,
  `external_id` varchar(50) DEFAULT NULL,
  `status` int(5) DEFAULT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица grcentral_base.settings_fw
CREATE TABLE IF NOT EXISTS `settings_fw` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `version` varchar(50) DEFAULT NULL,
  `previous_version` varchar(50) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `file_name` varchar(100) DEFAULT NULL,
  `file_name_real` varchar(100) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица grcentral_base.settings_models
CREATE TABLE IF NOT EXISTS `settings_models` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tech_name` varchar(100) DEFAULT NULL,
  `friendly_name` varchar(100) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `tech_name` (`tech_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица grcentral_base.settings_models_group
CREATE TABLE IF NOT EXISTS `settings_models_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `params_group_id` int(11) DEFAULT NULL,
  `params_conf_acc_atatus` varchar(50) DEFAULT NULL,
  `params_conf_acc_name` varchar(50) DEFAULT NULL,
  `params_conf_srv_main` varchar(50) DEFAULT NULL,
  `params_conf_srv_reserve` varchar(50) DEFAULT NULL,
  `params_conf_sip_userid` varchar(50) DEFAULT NULL,
  `params_conf_sip_authid` varchar(50) DEFAULT NULL,
  `params_conf_sip_passwd` varchar(50) DEFAULT NULL,
  `params_conf_show_name` varchar(50) DEFAULT NULL,
  `params_conf_acc_display` varchar(50) DEFAULT NULL,
  `params_conf_voicemail` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица grcentral_base.settings_params
CREATE TABLE IF NOT EXISTS `settings_params` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `params_source_data` text DEFAULT NULL,
  `params_json_data` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица grcentral_base.settings_servers
CREATE TABLE IF NOT EXISTS `settings_servers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL,
  `server` varchar(150) DEFAULT NULL,
  `voicemail_number` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица grcentral_base.settings_system
CREATE TABLE IF NOT EXISTS `settings_system` (
  `key` varchar(250) DEFAULT NULL,
  `value` varchar(250) DEFAULT NULL,
  UNIQUE KEY `variable` (`key`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Экспортируемые данные не выделены.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
