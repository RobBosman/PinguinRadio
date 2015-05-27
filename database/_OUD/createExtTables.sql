-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.24-log - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL version:             7.0.0.4053
-- Date/time:                    2013-03-20 17:41:17
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

-- Dumping database structure for pinguinradio
DROP DATABASE IF EXISTS `pinguinradio`;
CREATE DATABASE IF NOT EXISTS `pinguinradio` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `pinguinradio`;


-- Dumping structure for table pinguinradio.ext_graadmeter
DROP TABLE IF EXISTS `ext_graadmeter`;
CREATE TABLE IF NOT EXISTS `ext_graadmeter` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ref` varchar(25) NOT NULL,
  `artiest` varchar(150) NOT NULL,
  `track` varchar(250) NOT NULL,
  `ijsbreker` char(1) NOT NULL DEFAULT 'N',
  `lijst` varchar(10) NOT NULL,
  `positie` int(11) unsigned NOT NULL DEFAULT '0',
  `positie_vw` int(11) unsigned NOT NULL DEFAULT '0',
  `aantal_wk` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ref` (`ref`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Data exporting was unselected.


-- Dumping structure for table pinguinradio.ext_graadmeter_beheer
DROP TABLE IF EXISTS `ext_graadmeter_beheer`;
CREATE TABLE IF NOT EXISTS `ext_graadmeter_beheer` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ref` varchar(25) NOT NULL,
  `artiest` varchar(150) NOT NULL,
  `track` varchar(250) NOT NULL,
  `ijsbreker` char(1) NOT NULL DEFAULT 'N',
  `lijst` varchar(10) NOT NULL,
  `positie` int(11) unsigned NOT NULL DEFAULT '0',
  `positie_vw` int(11) unsigned NOT NULL DEFAULT '0',
  `aantal_wk` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ref` (`ref`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Data exporting was unselected.


-- Dumping structure for table pinguinradio.ext_graadmeter_beheer_state
DROP TABLE IF EXISTS `ext_graadmeter_beheer_state`;
CREATE TABLE IF NOT EXISTS `ext_graadmeter_beheer_state` (
  `prepared` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `published` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Data exporting was unselected.


-- Dumping structure for table pinguinradio.ext_graadmeter_stemmen
DROP TABLE IF EXISTS `ext_graadmeter_stemmen`;
CREATE TABLE IF NOT EXISTS `ext_graadmeter_stemmen` (
  `ip_adres` varchar(50) NOT NULL,
  `datum` date NOT NULL,
  `ref_top30_voor` varchar(25) DEFAULT NULL,
  `ref_top30_tegen` varchar(25) DEFAULT NULL,
  `ref_tip10_voor` varchar(25) DEFAULT NULL,
  `ref_tip10_tegen` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`ip_adres`,`datum`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table pinguinradio.ext_graadmeter_tips
DROP TABLE IF EXISTS `ext_graadmeter_tips`;
CREATE TABLE IF NOT EXISTS `ext_graadmeter_tips` (
  `ip_adres` varchar(50) NOT NULL,
  `tijdstip` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tip` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Data exporting was unselected.
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
