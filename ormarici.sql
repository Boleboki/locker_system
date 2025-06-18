-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 18, 2025 at 12:07 PM
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
(3, 1, 'boki', '$2y$10$1tLk30erLM7m41QvG.zW2.a7SSOW.8.VHC3vskgVkw9qSe1zlB4BO', 1),
(21, 1, 'gdadga', '$2y$10$X9G8Q0BcP0JdKbKpo21Raulqz0uiFonlYFF1qNst4RT8HLZFQghay', 1);

--
-- Indexes for dumped tables
--

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
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
