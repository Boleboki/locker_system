-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 16, 2026 at 12:28 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
  `brojevi_ormarica_po_indexu` tinyint(2) DEFAULT 0,
  `ip_address` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `citaci`
--

INSERT INTO `citaci` (`id_citaca`, `opis_citaca`, `tip_citaca`, `citac_za_radno_vreme`, `citac_za_kontrolu_pristupa`, `citac_za_ormarice`, `citac_za_grupu_ormarica`, `citac_za_odjavu`, `delay`, `sn_citaca`, `sn_barijere`, `delay_senzora`, `broj_ormarica`, `broj_redova_ormarica`, `brojevi_ormarica`, `aktivan`, `brojevi_ormarica_po_indexu`, `ip_address`) VALUES
(6, 'k-1', 'U', '', '', '1', '', '', 0, 112988, 'ON102001', 0, 16, 2, '207,208,209,210,211,212,213,214,215,216,217,218,219,220,221,222', 1, 0, ''),
(21, 'e', 'U', '0', '0', '1', NULL, '0', 0, 107336, 'ON101329', 0, 28, 2, '97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124', 1, 0, NULL),
(2, 'G', 'U', '0', '0', '1', NULL, '0', 0, 107343, '', 0, 26, 2, '141,142,143,144,145,146,147,148,149,150,151,152,153,154,155,156,157,158,159,160,161,162,163,164,165,166', 1, 0, NULL),
(107404, 'j', '', '0', '0', '1', '0', '0', 0, 107404, 'ON101324', 0, 1, 1, '2', 1, 0, NULL),
(105919, 'PROBAFIRMA', '', '', '', '1', '', '', 0, 113654, 'ON102669', 0, 32, 2, '16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32', 1, 1, ''),
(8, 'd', 'U', '0', '0', '1', NULL, '0', 0, 106530, 'ON101325', 0, 16, 2, '81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96', 1, 0, NULL),
(9, 'F', 'U', '0', '0', '1', NULL, '0', 0, 106805, 'ON101325', 0, 16, 2, '125,126,127,128,129,130,131,132,133,134,135,136,137,138,139,140', 1, 0, NULL),
(999, 'Test izlaz', 'U', '0', '1', '0', NULL, '0', 0, 106533, '', 0, 0, 0, '', 0, 0, NULL),
(1000, 'Izlaz bar.1', 'U', '0', '0', '0', NULL, '1', 0, 107399, 'ON101350', 0, 0, 0, '', 0, 0, NULL),
(10, 'b', 'U', '0', '0', '1', NULL, '0', 0, 107403, 'ON101328', 0, 18, 2, '35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52', 1, 0, NULL),
(20, 'c', 'U', '0', '0', '1', NULL, '0', 0, 106535, 'ON101075', 0, 28, 2, '53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80', 1, 0, NULL),
(10001, 'Barijera ulaz', 'U', '0', '1', '0', NULL, '0', 0, 107330, 'ON101627', 0, 0, 0, '', 1, 0, NULL),
(1, 'A', 'I', '0', '0', '1', NULL, '0', 0, 107030, 'ON101626', 0, 34, 2, '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34', 1, 0, NULL),
(105920, 'PROBAFIRMA2', 'U', '0', '0', '1', '0', '0', 0, 105919, 'ON102669', 0, 18, 2, '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16', 1, 0, NULL),
(123, 'ppp', '', '0', '0', '1', '0', '0', 0, 1234, 'on123', 0, 2, 2, '1,2,3', 1, 0, NULL),
(111, 'ppp', '', '0', '0', '1', '1', '0', 0, 7504, 'on123', 0, 2, 2, '1,2,3,4,5,6,7,8,9,10,11,12', 1, 0, NULL),
(7843, '', 'I', '', '', '', '', '', 0, 438, '', 0, 0, 0, '', 0, 0, ''),
(362623, '', 'I', '', '', '', '', '', 0, 0, '', 0, 0, 0, '', 0, 0, NULL),
(743743, '', 'I', '', '', '', '', '', 0, 0, '', 0, 0, 0, '', 0, 0, NULL),
(6432623, '', 'I', '', '', '', '', '', 0, 0, '', 0, 0, 0, '', 0, 0, NULL),
(734, '', 'I', '', '', '', '', '', 0, 0, '', 0, 0, 0, '', 0, 0, NULL),
(74373, '', 'I', '', '', '', '', '', 0, 74373, '', 0, 0, 0, '', 0, 0, ''),
(62362, '', 'I', '', '', '', '', '', 0, 623623, '', 0, 0, 0, '', 0, 0, ''),
(63262, '', 'I', '', '', '', '', '', 0, 623623, '', 0, 0, 0, '', 0, 0, ''),
(374, '', 'I', '', '', '', '', '', 0, 734, '', 0, 0, 0, '', 0, 0, ''),
(75357, '46436', 'I', '', '', '', '', '', 845, 785485, 'dfhfdhs', 853835, 0, 0, '', 0, 0, ''),
(743, '', 'I', '', '', '', '', '', 0, 743743, '', 0, 0, 0, '', 0, 0, ''),
(4845, '', 'I', '', '', '', '', '', 0, 8454, '', 0, 0, 0, '', 0, 0, ''),
(843834, '', 'I', '', '', '', '', '', 0, 834843, '', 0, 0, 0, '', 0, 0, ''),
(743473, '', 'I', '', '', '', '', '', 0, 734743, '', 0, 0, 0, '', 0, 0, ''),
(734473, '', 'I', '', '', '', '', '', 0, 743743, '', 0, 0, 0, '', 0, 0, ''),
(7437, '', 'I', '', '', '', '', '', 0, 743734, '', 0, 0, 0, '', 0, 0, ''),
(754375, '', 'I', '', '', '', '', '', 0, 753375, '', 0, 0, 0, '', 0, 0, ''),
(853, '', 'I', '', '', '', '', '', 0, 853, '', 0, 0, 0, '', 0, 0, ''),
(845, '', 'I', '', '', '', '', '', 0, 854, '', 0, 0, 0, '', 0, 0, ''),
(845854, '', 'I', '', '', '', '', '', 0, 85383, '', 0, 0, 0, '', 0, 0, ''),
(574854, '', 'I', '', '', '', '', '', 0, 854845, '', 0, 0, 0, '', 0, 0, ''),
(745745, '', 'I', '', '', '', '', '', 0, 754745, '', 0, 0, 0, '', 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `configuration_translations`
--

CREATE TABLE `configuration_translations` (
  `id` int(11) NOT NULL,
  `configuration_name` varchar(50) NOT NULL,
  `language` varchar(5) NOT NULL,
  `description` varchar(1500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `configuration_translations`
--

INSERT INTO `configuration_translations` (`id`, `configuration_name`, `language`, `description`) VALUES
(1, 'card_job', 'sr', 'broj posla iz kartice'),
(2, 'card_job', 'en', 'job number from the card'),
(3, 'ormarici', 'sr', 'Upotreba ormarica'),
(4, 'ormarici', 'en', 'Use of lockers'),
(5, 'bekap_path', 'sr', 'Putanja bekapa baze podataka npr.c:\\'),
(6, 'bekap_path', 'en', 'Backup path of the database, e.g. c:\\'),
(7, 'zadnji_db_update', 'sr', 'poslednji izvrsen db upit'),
(8, 'zadnji_db_update', 'en', 'last executed db query'),
(9, 'uid_za_reprog_ormarica', 'sr', 'Broj kartice preko koje se radi reprogramiranje ormarica kome je istekao limit zauzeca'),
(10, 'uid_za_reprog_ormarica', 'en', 'Card number used for reprogramming lockers after usage limit expired'),
(11, 'mysqldump_path', 'sr', 'Putanja do fajla koji izvrsava dump (bekap) baze podataka npr.c:\\xampp\\mysql\\bin\\mysqldump.exe'),
(12, 'mysqldump_path', 'en', 'Path to the file executing the database dump (backup), e.g. c:\\xampp\\mysql\\bin\\mysqldump.exe'),
(13, 'mysqlcheck_path', 'sr', 'Putanja do fajla koji pokrece proveru i reparaciju tabela u bazi podataka npr. c:\\xampp\\mysql\\bin\\'),
(14, 'mysqlcheck_path', 'en', 'Path to the file that runs database table check and repair, e.g. c:\\xampp\\mysql\\bin\\'),
(15, 'trajanje_sesije', 'sr', 'Trajanje sesije u sekundama'),
(16, 'trajanje_sesije', 'en', 'Session duration in seconds'),
(17, 'trajanje_sesije_0_1', 'sr', 'Provera max duzine trajanja sesije'),
(18, 'trajanje_sesije_0_1', 'en', 'Check max length of session duration'),
(19, 'limit_zauzeca_ormarica', 'sr', 'Vremenski limit zauzeca ormarica u minutima'),
(20, 'limit_zauzeca_ormarica', 'en', 'Time limit of locker usage in minutes'),
(21, 'max_vreme_neaktivnosti', 'sr', 'Maksimalno vreme neaktivnosti korisnika kod programiranja u sekundama'),
(22, 'max_vreme_neaktivnosti', 'en', 'Maximum inactivity time of user during programming in seconds'),
(23, 'uid_za_bekap', 'sr', 'Broj kartice preko koje se radi bekap baze podataka'),
(24, 'uid_za_bekap', 'en', 'Card number used for database backup'),
(25, 'time_reader_sleep', 'sr', 'Sleep vreme prozivke citaca u sekundama'),
(26, 'time_reader_sleep', 'en', 'Sleep time for polling readers in seconds'),
(27, 'uid_za_sve_ormarice', 'sr', 'UID kartice preko koje si otvaraju svi ormarici'),
(28, 'uid_za_sve_ormarice', 'en', 'UID of the card that opens all lockers'),
(29, 'nova_fiskalizacija', 'sr', 'Da li se upotrebljava nova fiskalizacija ili ne'),
(30, 'nova_fiskalizacija', 'en', 'Whether the new fiscalization is used or not'),
(31, 'naziv_default_printera', 'sr', 'Naziv stampaca koji ce se koristiti za štampanje novog fiskalnog računa'),
(32, 'naziv_default_printera', 'en', 'Name of the printer used for printing new fiscal receipts'),
(33, 'automatsko_razduzivanje_ormarica', 'sr', 'Automatsko razduzivanje ormarica. Ako je vrednost 0 (nula) tada se opcija NE koristi. Vrednost predstavlja minute.'),
(34, 'automatsko_razduzivanje_ormarica', 'en', 'Automatic locker checkout. If value is 0, option is NOT used. Value represents minutes.'),
(35, 'fiskal_qrCodeSize', 'sr', 'Veličina QR koda fiskalnog računa. Default:580'),
(36, 'fiskal_qrCodeSize', 'en', 'Size of fiscal receipt QR code. Default: 580'),
(37, 'max_grupnih_karata', 'sr', 'Maksimalan broj grupnih karata'),
(38, 'max_grupnih_karata', 'en', 'Maximum number of group tickets'),
(39, 'putanja_za_izvestaje', 'sr', 'Putanja do foldera gde se čuvaju izvestaji'),
(40, 'putanja_za_izvestaje', 'en', 'Path to folder where reports are saved'),
(41, 'tip_fiskalnog_racuna', 'sr', 'Tip fiskalnog računa: 0 - Normal, 3 - Training'),
(42, 'tip_fiskalnog_racuna', 'en', 'Type of fiscal receipt: 0 - Normal, 3 - Training'),
(43, 'broj_programiranja_kartice_po_danu', 'sr', 'Maksimalan broj koriscenja kartice za ormarice u toku jednog dana. 0 vrednost znaci neogranicen broj.'),
(44, 'broj_programiranja_kartice_po_danu', 'en', 'Maximum number of uses of card for lockers per day. 0 means unlimited.'),
(45, 'mysql_backup_path', 'sr', 'Bekap baze u folder'),
(46, 'mysql_backup_path', 'en', 'Database backup folder'),
(47, 'mysql_folder_path', 'sr', 'Bekap mysql/backup foldera'),
(48, 'mysql_folder_path', 'en', 'Backup folder for mysql/backup');

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
(1, 1, 'bole', '$2y$10$BUmVuyMPUEClvo/hqo7ST.Qno209Uszzh3xO2qL2e9GnhzTVZ7o5u', 1),
(2, 1, 'nikola', '$2y$10$nU7ffTCtzSDBLyjg10nj7u4hGvJrL6tNVHeLc736EyVFOIIazeIdu', 1),
(3, 1, 'boki', '$2y$10$b5oUdQYbmMfHom0vjKU0VO2JRlym7NcqOC2Qru2zY/55a7fpJqI2G', 1),
(31, 1, 'gsdghsd', '', 1),
(32, 1, 'hdaadh', '$2y$10$LN/nf2rWbHi0rBDuDj4EP.EGi5voNkUBjofDnY9Rs08D8fCTYyNMe', 1),
(41, 1, 'jfhfhjd', '$2y$10$La5bXHj/DD03f8UKFiP8cOCicOvQis.L4kuipHEgZpCD1QSXL21yO', 1),
(45, 1, 'admin', '$2y$10$qFjJfxMM4nsPy75/5JXURenT1lbFM/PURB78nyNVXuR136HEC8RR6', 1);

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
-- Indexes for table `configuration_translations`
--
ALTER TABLE `configuration_translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_config_lang` (`configuration_name`,`language`);

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
-- AUTO_INCREMENT for table `configuration_translations`
--
ALTER TABLE `configuration_translations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
