-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.24-log - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL version:             7.0.0.4053
-- Date/time:                    2013-03-06 01:34:02
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

-- Dumping database structure for pinguinradio
CREATE DATABASE IF NOT EXISTS `pinguinradio` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `pinguinradio`;


-- Dumping structure for table pinguinradio._oud_graadmeter
DROP TABLE IF EXISTS `_oud_graadmeter`;
CREATE TABLE IF NOT EXISTS `_oud_graadmeter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `positie` int(11) NOT NULL,
  `track` varchar(250) NOT NULL,
  `artiest` varchar(150) NOT NULL,
  `positie_vw` int(11) NOT NULL DEFAULT '0',
  `aantal_wk` int(11) NOT NULL,
  `ijsbreker` char(1) NOT NULL DEFAULT '0',
  `ex_ijsbreker` char(1) NOT NULL DEFAULT '0',
  `stemmen_voor` int(11) NOT NULL DEFAULT '0',
  `stemmen_tegen` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table pinguinradio._oud_graadmeter_exit
DROP TABLE IF EXISTS `_oud_graadmeter_exit`;
CREATE TABLE IF NOT EXISTS `_oud_graadmeter_exit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `positie` int(11) NOT NULL,
  `track` varchar(250) NOT NULL,
  `artiest` varchar(150) NOT NULL,
  `positie_vw` int(11) NOT NULL DEFAULT '0',
  `aantal_wk` int(11) NOT NULL,
  `ijsbreker` char(1) NOT NULL DEFAULT '0',
  `ex_ijsbreker` char(1) NOT NULL DEFAULT '0',
  `stemmen_voor` int(11) NOT NULL DEFAULT '0',
  `stemmen_tegen` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table pinguinradio._oud_graadmeter_ip_adressen
DROP TABLE IF EXISTS `_oud_graadmeter_ip_adressen`;
CREATE TABLE IF NOT EXISTS `_oud_graadmeter_ip_adressen` (
  `ipadres` varchar(20) NOT NULL,
  `stemdatum` char(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table pinguinradio._oud_graadmeter_tip10
DROP TABLE IF EXISTS `_oud_graadmeter_tip10`;
CREATE TABLE IF NOT EXISTS `_oud_graadmeter_tip10` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `positie` int(11) NOT NULL,
  `track` varchar(250) NOT NULL,
  `artiest` varchar(150) NOT NULL,
  `positie_vw` int(11) NOT NULL DEFAULT '0',
  `aantal_wk` int(11) NOT NULL,
  `ijsbreker` char(1) NOT NULL DEFAULT '0',
  `ex_ijsbreker` char(1) NOT NULL DEFAULT '0',
  `stemmen_voor` int(11) NOT NULL DEFAULT '0',
  `stemmen_tegen` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table pinguinradio._oud_graadmeter_tips
DROP TABLE IF EXISTS `_oud_graadmeter_tips`;
CREATE TABLE IF NOT EXISTS `_oud_graadmeter_tips` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tip` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
