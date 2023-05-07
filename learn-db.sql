-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.24-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for learn
CREATE DATABASE IF NOT EXISTS `learn` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `learn`;

-- Dumping structure for table learn.accounts
CREATE TABLE IF NOT EXISTS `accounts` (
  `id` varchar(150) NOT NULL DEFAULT '',
  `email` varchar(150) DEFAULT NULL,
  `password` text DEFAULT NULL,
  `is_active` int(11) DEFAULT NULL,
  `date_created` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table learn.accounts: ~6 rows (approximately)
INSERT INTO `accounts` (`id`, `email`, `password`, `is_active`, `date_created`) VALUES
	('1234', 'admin@admin.com', '$2y$10$RdNpenTQ4vbOZV69UcQRAeRR/ZtP04JN8jJ3EmwFMloImYtKljC.G', 1, '2022-08-24 23:22:20'),
	('G0001', 'rhadi.indrawankkpi@gmail.com', '$2y$10$rMSX8HpDdXL6eGTgZptvEO4zVD4fsUCfQAZsAUgWayVHwomfEmhOm', 1, '2022-08-30 00:40:06'),
	('G0002', 'indrawanrhadi@gmail.com', '$2y$10$qCPHtSCLaodjouiLGdckuuIYd1ml9j9qIz8IL/PJtaZPQrkL.iBke', 1, '2022-08-30 00:44:36'),
	('S0001', 'aswar@aswar.com', '$2y$10$EQWt3M1p84Q7wPiFrLmJD.713THJ63DHbF.5y8aHqSV7mnsJ5C6DW', 1, '2022-08-31 05:43:13'),
	('S0002', 'adnan@adnan.com', '$2y$10$6JDVOe8ubTs1qf98urZ1GOSfIZ.8oYTRGSyhQD5u5ozUgNudmpeU.', 1, '2022-08-31 06:23:20'),
	('S0003', 'farhan@farhan.com', '$2y$10$tfXjPp.uyTYFxNVFuvLSweivJsI8t3OiQ.GHLN3c1XXYDGTeMzUu6', 1, '2022-09-06 02:57:03');

-- Dumping structure for table learn.guru
CREATE TABLE IF NOT EXISTS `guru` (
  `id` varchar(150) NOT NULL,
  `mapel` varchar(150) NOT NULL,
  PRIMARY KEY (`id`,`mapel`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table learn.guru: ~5 rows (approximately)
INSERT INTO `guru` (`id`, `mapel`) VALUES
	('G0001', '1'),
	('G0001', '2'),
	('G0001', '3'),
	('G0002', '1'),
	('G0002', '3');

-- Dumping structure for table learn.jadwal
CREATE TABLE IF NOT EXISTS `jadwal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kls` varchar(150) DEFAULT NULL,
  `id_mapel` int(11) DEFAULT NULL,
  `hari` varchar(50) DEFAULT NULL,
  `jam_masuk` time DEFAULT NULL,
  `jam_keluar` time DEFAULT NULL,
  `id_guru` varchar(150) DEFAULT NULL,
  `link_kls` text DEFAULT NULL,
  `link_meet` text DEFAULT NULL,
  `materi` longtext DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table learn.jadwal: ~4 rows (approximately)
INSERT INTO `jadwal` (`id`, `nama_kls`, `id_mapel`, `hari`, `jam_masuk`, `jam_keluar`, `id_guru`, `link_kls`, `link_meet`, `materi`) VALUES
	(6, 'II-A', 1, 'Rabu', '07:30:00', '09:10:00', 'G0002', NULL, NULL, NULL),
	(12, 'II-B', 1, 'Senin', '07:30:00', '09:10:00', 'G0002', NULL, NULL, NULL),
	(13, 'II-B', 2, 'Selasa', '07:30:00', '09:10:00', 'G0001', 'https://askavy.com/font-awesome-5-pro-cdn-link/', 'https://fontawesome.com/icons/graduation-cap?s=solid&f=classic', 'Google_Sites.pdf'),
	(14, 'II-B', 2, 'Kamis', '07:30:00', '09:10:00', 'G0001', NULL, NULL, NULL);

-- Dumping structure for table learn.profile
CREATE TABLE IF NOT EXISTS `profile` (
  `id` varchar(150) NOT NULL DEFAULT '',
  `nama` varchar(150) DEFAULT NULL,
  `asal` varchar(150) DEFAULT NULL,
  `tglahir` date DEFAULT NULL,
  `image` text DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table learn.profile: ~6 rows (approximately)
INSERT INTO `profile` (`id`, `nama`, `asal`, `tglahir`, `image`, `role_id`) VALUES
	('1234', 'Admin Default', 'admin', '2022-08-29', 'not.jpg', 1),
	('G0001', 'Rhadi Indrawan', 'Makassar', '2000-04-16', 'WhatsApp_Image_2022-08-31_at_15_23_58.jpeg', 2),
	('G0002', 'Indrawan Rhadi', 'Makassar', '2001-09-16', 'WhatsApp_Image_2022-08-31_at_15_13_30.jpeg', 2),
	('S0001', 'Aswar Manaf', 'Makassar', '2004-12-23', 'naruto.jpg', 3),
	('S0002', 'Adnan', 'Makassar', '2004-04-12', 'not.jpg', 3),
	('S0003', 'farhan', 'Barcelona', '2004-04-12', 'not.jpg', 3);

-- Dumping structure for table learn.ref_mapel
CREATE TABLE IF NOT EXISTS `ref_mapel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_mapel` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table learn.ref_mapel: ~6 rows (approximately)
INSERT INTO `ref_mapel` (`id`, `nama_mapel`) VALUES
	(1, 'matematika'),
	(2, 'bahasa indonesia'),
	(3, 'bahasa inggris'),
	(4, 'Fisika'),
	(5, 'bahasa arab'),
	(6, 'bahasa spanyol');

-- Dumping structure for table learn.role
CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table learn.role: ~3 rows (approximately)
INSERT INTO `role` (`id`, `role`) VALUES
	(1, 'admin'),
	(2, 'guru'),
	(3, 'siswa');

-- Dumping structure for table learn.siswa
CREATE TABLE IF NOT EXISTS `siswa` (
  `id` varchar(150) NOT NULL DEFAULT 'NULL',
  `kelas` varchar(150) NOT NULL,
  PRIMARY KEY (`id`,`kelas`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table learn.siswa: ~3 rows (approximately)
INSERT INTO `siswa` (`id`, `kelas`) VALUES
	('S0001', 'II-B'),
	('S0002', 'II-A'),
	('S0003', 'II-A');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
