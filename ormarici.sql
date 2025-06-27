-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 27, 2025 at 01:55 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ormarici`
--

-- --------------------------------------------------------

--
-- Table structure for table `citaci`
--

CREATE TABLE `citaci` (
  `id_citaca` int(10) NOT NULL DEFAULT 0,
  `opis_citaca` varchar(50) DEFAULT NULL,
  `tip_citaca` varchar(5) DEFAULT NULL,
  `citac_za_radno_vreme` varchar(2) DEFAULT NULL,
  `citac_za_kontrolu_pristupa` varchar(2) DEFAULT NULL,
  `citac_za_ormarice` varchar(2) DEFAULT NULL,
  `citac_za_grupu_ormarica` varchar(2) DEFAULT NULL,
  `citac_za_odjavu` varchar(2) DEFAULT NULL,
  `delay` smallint(15) DEFAULT NULL,
  `sn_citaca` int(10) UNSIGNED NOT NULL,
  `sn_barijere` varchar(15) DEFAULT NULL,
  `delay_senzora` int(11) UNSIGNED DEFAULT NULL,
  `broj_ormarica` int(11) DEFAULT NULL,
  `broj_redova_ormarica` int(2) DEFAULT NULL,
  `brojevi_ormarica` varchar(255) DEFAULT NULL,
  `aktivan` tinyint(2) DEFAULT 0,
  `brojevi_ormarica_po_indexu` tinyint(2) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `citaci`
--

INSERT INTO `citaci` (`id_citaca`, `opis_citaca`, `tip_citaca`, `citac_za_radno_vreme`, `citac_za_kontrolu_pristupa`, `citac_za_ormarice`, `citac_za_grupu_ormarica`, `citac_za_odjavu`, `delay`, `sn_citaca`, `sn_barijere`, `delay_senzora`, `broj_ormarica`, `broj_redova_ormarica`, `brojevi_ormarica`, `aktivan`, `brojevi_ormarica_po_indexu`) VALUES
(7, 'H', '', '', '', '1', '', '', 0, 107405, 'ON102001', 0, 12, 2, '167,168,169,170,171,172,173,174,175,176,177,178', 1, 0),
(6, 'k-1', 'U', '0', '0', '1', NULL, '0', 0, 112988, 'ON102001', 0, 16, 2, '207,208,209,210,211,212,213,214,215,216,217,218,219,220,221,222', 1, 0),
(21, 'e', 'U', '0', '0', '1', NULL, '0', 0, 107336, 'ON101329', 0, 28, 2, '97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124', 1, 0),
(2, 'G', 'U', '0', '0', '1', NULL, '0', 0, 107343, '', 0, 26, 2, '141,142,143,144,145,146,147,148,149,150,151,152,153,154,155,156,157,158,159,160,161,162,163,164,165,166', 1, 0),
(107404, 'j', '', '0', '0', '1', '0', '0', 0, 107404, 'ON101324', 0, 1, 1, '2', 1, 0),
(105919, 'PROBAFIRMA', '', '0', '0', '1', '0', '0', 0, 113654, 'ON102669', 0, 32, 2, ',,,,,,,,,,,,,,,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32', 1, 1),
(8, 'd', 'U', '0', '0', '1', NULL, '0', 0, 106530, 'ON101325', 0, 16, 2, '81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96', 1, 0),
(9, 'F', 'U', '0', '0', '1', NULL, '0', 0, 106805, 'ON101325', 0, 16, 2, '125,126,127,128,129,130,131,132,133,134,135,136,137,138,139,140', 1, 0),
(999, 'Test izlaz', 'U', '0', '1', '0', NULL, '0', 0, 106533, '', 0, 0, 0, '', 0, 0),
(1000, 'Izlaz bar.1', 'U', '0', '0', '0', NULL, '1', 0, 107399, 'ON101350', 0, 0, 0, '', 0, 0),
(10, 'b', 'U', '0', '0', '1', NULL, '0', 0, 107403, 'ON101328', 0, 18, 2, '35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52', 1, 0),
(20, 'c', 'U', '0', '0', '1', NULL, '0', 0, 106535, 'ON101075', 0, 28, 2, '53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80', 1, 0),
(10001, 'Barijera ulaz', 'U', '0', '1', '0', NULL, '0', 0, 107330, 'ON101627', 0, 0, 0, '', 1, 0),
(1, 'A', 'I', '0', '0', '1', NULL, '0', 0, 107030, 'ON101626', 0, 34, 2, '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34', 1, 0),
(105920, 'PROBAFIRMA2', 'U', '0', '0', '1', '0', '0', 0, 105919, 'ON102669', 0, 18, 2, '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16', 1, 0),
(123, 'ppp', '', '0', '0', '1', '0', '0', 0, 1234, 'on123', 0, 2, 2, '1,2,3', 1, 0),
(111, 'ppp', '', '0', '0', '1', '1', '0', 0, 7504, 'on123', 0, 2, 2, '1,2,3,4,5,6,7,8,9,10,11,12', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `confingure`
--

CREATE TABLE `confingure` (
  `name` varchar(50) DEFAULT NULL,
  `par` text DEFAULT NULL,
  `opis` varchar(1500) DEFAULT NULL,
  `tip` varchar(10) DEFAULT NULL COMMENT 'Polje predstavlja tip kartice i sluzi za kreiranje master i ostalih kartica\r\n''M'' - master'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `confingure`
--

INSERT INTO `confingure` (`name`, `par`, `opis`, `tip`) VALUES
('card_job', '44', 'broj posla iz kartice', NULL),
('ormarici', '1', 'Upotreba ormarica ', NULL),
('bekap_path', 'c:\\', 'Putanja bekapa baze podataka npr.c:\\', NULL),
('zadnji_db_update', 'dbupdate_2018_09_03_2.sql', 'poslednji izvrsen db upit', NULL),
('uid_za_reprog_ormarica', NULL, 'Broj kartice preko koje se radi reprogramiranje ormarica kome je istekao limit zauzeca', 'MASTER'),
('mysqldump_path', 'c:\\xampp\\mysql\\bin\\mysqldump.exe', 'Putanja do fajla koji izvrsava dump (bekap) baze podataka npr.c:\\xampp\\mysql\\bin\\mysqldump.exe', NULL),
('mysqlcheck_path', 'c:\\xampp\\mysql\\bin\\', 'Putanja do fajla koji pokrece proveru i reparaciju tabela u bazi podataka npr. c:\\xampp\\mysql\\bin\\', NULL),
('trajanje_sesije', '60000', 'Trajanje sesije u sekundama', NULL),
('trajanje_sesije_0_1', '1', 'Provera max duzine trajanja sesije', NULL),
('limit_zauzeca_ormarica', '2', 'Vremenski limit zauzeca ormarica u minutima', NULL),
('max_vreme_neaktivnosti', '10000', 'Maksimalno vreme neaktivnosti korisnika kod programiranja u sekundama', NULL),
('uid_za_bekap', 'D5:BC:83:82', 'Broj kartice preko koje se radi bekap baze podataka', 'MASTER'),
('time_reader_sleep', '1200', 'Sleep vreme prozivke citaca u sekundama', NULL),
('uid_za_sve_ormarice', 'E0:44:29:DC', 'UID kartice preko koje si otvaraju svi ormarici', 'MASTER'),
('nova_fiskalizacija', '1', 'Da li se upotrebljava nova fiskalizacija ili ne', NULL),
('naziv_default_printera', 'CP-Q1T', 'Naziv stampaca koji ce se koristiti za štampanje novog fiskalnog računa', NULL),
('automatsko_razduzivanje_ormarica', '3', 'Automatsko razduzivanje ormarica.Ako je vrednost 0 (nula) tada se opcija NE koristi.\r\nVrednost predstavlja minute.\r\n', NULL),
('fiskal_qrCodeSize', '580', 'Veličina QR koda fiskalnog računa.Default:580', NULL),
('max_grupnih_karata', '2', 'Maksimalan broj grupnih karata', NULL),
('putanja_za_izvestaje', 'C:\\\\izvestaji\\\\', 'Putanja do foldera gde se čuvaju izvestaji', NULL),
('tip_fiskalnog_racuna', '3', 'Tip fiskalnog računa: 0 - Normal, 3 - Training', NULL),
('broj_programiranja_kartice_po_danu', '2', 'Maksimalan broj koriscenja kartice za ormarice u toku jednog dana.0 vrednost znaci neogranicen broj.', NULL),
('mysql_backup_path', 'c:\\', 'Bekap baze u folder', NULL),
('mysql_folder_path', 'c:\\xampp\\mysql\\backup', 'Bekap mysql/backup foldera', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `member_id` int(11) NOT NULL,
  `aktivan` tinyint(4) NOT NULL DEFAULT 1,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `admin` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`member_id`, `aktivan`, `username`, `password`, `admin`) VALUES
(1, 1, 'bole', '$2y$10$cfxlG7oLJ1JXABfWZZQNneDGfWFP0576YtJHvRLYUUAWy5VS4RaPq', 1),
(2, 1, 'nikola', '$2y$10$nU7ffTCtzSDBLyjg10nj7u4hGvJrL6tNVHeLc736EyVFOIIazeIdu', 1),
(3, 1, 'boki', '$2y$10$WUV8BgsYL8wKDnQGd6o7a.WlguC.4pt4QFk3QvDMEDLYhzJbTNEuW', 0),
(31, 1, 'hdahda', '$2y$10$YiQqOdtDeq5LZN69fIzlAeUKmaNzEfvYk234VRuh0a2LFFS.zWKKG', 1),
(32, 1, 'hdaadh', '$2y$10$LN/nf2rWbHi0rBDuDj4EP.EGi5voNkUBjofDnY9Rs08D8fCTYyNMe', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `citaci`
--
ALTER TABLE `citaci`
  ADD PRIMARY KEY (`id_citaca`),
  ADD KEY `opis_citaca` (`opis_citaca`);

--
-- Indexes for table `confingure`
--
ALTER TABLE `confingure`
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`member_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
