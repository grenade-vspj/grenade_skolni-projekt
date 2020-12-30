-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Počítač: localhost
-- Vytvořeno: Stř 30. pro 2020, 05:58
-- Verze serveru: 8.0.21
-- Verze PHP: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `team1`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `clanky`
--

CREATE TABLE `clanky` (
  `id_clanek` int NOT NULL,
  `id_autor` int DEFAULT NULL,
  `id_stav` int DEFAULT NULL,
  `nazev` varchar(100) CHARACTER SET latin2 COLLATE latin2_czech_cs NOT NULL,
  `id_resitel` int DEFAULT NULL,
  `id_recenzent1` int DEFAULT NULL,
  `id_recenzent2` int DEFAULT NULL,
  `hodnoceni_recenzent1` text CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci,
  `hodnoceni_recenzent2` text CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci,
  `termin_recenze` datetime DEFAULT NULL COMMENT 'Termín zpracování recenze článku',
  `cislo_casopisu` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci COMMENT='Tabulka článků';

-- --------------------------------------------------------

--
-- Struktura tabulky `sablony`
--

CREATE TABLE `sablony` (
  `cislo_casopisu` int NOT NULL,
  `cesta` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci NOT NULL,
  `datum` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tisk` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci COMMENT='Šablony čísel časopisů pro tisk';

-- --------------------------------------------------------

--
-- Struktura tabulky `stav`
--

CREATE TABLE `stav` (
  `id` int NOT NULL,
  `nazev` varchar(50) CHARACTER SET latin2 COLLATE latin2_czech_cs NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Vypisuji data pro tabulku `stav`
--

INSERT INTO `stav` (`id`, `nazev`) VALUES
(4, 'Doplnění'),
(5, 'Přijato'),
(3, 'Recenzní řízení'),
(2, 'Stanovení recenzentů'),
(1, 'Zadán'),
(6, 'Zamítnuto'),
(7, 'Zveřejněno');

-- --------------------------------------------------------

--
-- Struktura tabulky `ucet`
--

CREATE TABLE `ucet` (
  `id` int NOT NULL,
  `prihlas_jmeno` varchar(255) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `heslo` varchar(255) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `jmeno` varchar(255) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `prijmeni` varchar(255) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `prava` varchar(255) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `zmena_hesla` varchar(255) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Vypisuji data pro tabulku `ucet`
--

INSERT INTO `ucet` (`id`, `prihlas_jmeno`, `heslo`, `jmeno`, `prijmeni`, `prava`, `zmena_hesla`) VALUES
(1, 'admin', 'admin', 'admin', 'admin', 'admin', 'NE'),
(2, 'ctenar', '', 'ctenar', 'ctenar', 'ctenar', ''),
(3, 'redaktor', 'redaktor', 'Red', 'Aktor', 'redaktor', 'NE'),
(4, 'pokus', 'pokus', 'pokus', 'pokus', 'ctenar', 'NE'),
(5, 'recenzent1', 'recenzent1', 'recenzent1', 'recenzent1', 'recenzent', 'NE'),
(6, 'recenzent2', 'recenzent2', 'recenzent2', 'recenzent2', 'recenzent', 'NE'),
(7, 'svobodp', 'svobodp', 'Petr', 'Svoboda', 'recenzent', 'NE'),
(9, 'autor1', 'autor1', 'Aut', 'Or1', 'autor', 'NE'),
(10, 'behounekv', 'behounekv', 'Vojta', 'Běhounek', 'recenzent', 'NE'),
(11, 'sectelyj', 'sectelyj', 'Jan', 'Sečtělý', 'autor', 'NE'),
(12, 'muzikantj', 'muzikantj', 'Josef', 'Muzikant', 'autor', 'NE');

-- --------------------------------------------------------

--
-- Struktura tabulky `verze`
--

CREATE TABLE `verze` (
  `id_verze` int NOT NULL,
  `id_clanek` int NOT NULL,
  `cesta` varchar(255) CHARACTER SET latin2 COLLATE latin2_czech_cs NOT NULL,
  `datum` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `clanky`
--
ALTER TABLE `clanky`
  ADD PRIMARY KEY (`id_clanek`) USING BTREE COMMENT 'Primární klíč tabulky',
  ADD KEY `ix_clanky_fk_id_autor` (`id_autor`) USING BTREE COMMENT 'Cizí klíč - tabulka logos_login, sloupec id_login',
  ADD KEY `ix_clanky_fk_id_resitel` (`id_resitel`) USING BTREE COMMENT 'Cizí klíč - tabulka logos_login, sloupec id_login',
  ADD KEY `ix_clanky_fk_id_stav` (`id_stav`) USING BTREE COMMENT 'Cizí klíč - tabulka stav, sloupec id_stav';

--
-- Klíče pro tabulku `sablony`
--
ALTER TABLE `sablony`
  ADD PRIMARY KEY (`cislo_casopisu`);

--
-- Klíče pro tabulku `stav`
--
ALTER TABLE `stav`
  ADD PRIMARY KEY (`id`) USING BTREE COMMENT 'Primární klíč tabulky',
  ADD UNIQUE KEY `ix_clanky_uq_nazev` (`nazev`) USING BTREE COMMENT 'Alternativní klíč tabulky - nelze evidovat 2 stejné stavy';

--
-- Klíče pro tabulku `ucet`
--
ALTER TABLE `ucet`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `verze`
--
ALTER TABLE `verze`
  ADD PRIMARY KEY (`id_verze`) USING BTREE COMMENT 'Primární klíč tabulky',
  ADD UNIQUE KEY `ix_verze_uq_cesta` (`cesta`) USING BTREE COMMENT 'Alternativní klíč tabulky - nelze evidovat v tabulce 2x stejný soubor (každý soubor musí mít jinou cestu)',
  ADD KEY `ix_verze_fk_id_clanek` (`id_clanek`) USING BTREE COMMENT 'Cizí klíč - tabulka clanky, sloupec id_clanek';

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `clanky`
--
ALTER TABLE `clanky`
  MODIFY `id_clanek` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `stav`
--
ALTER TABLE `stav`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pro tabulku `ucet`
--
ALTER TABLE `ucet`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pro tabulku `verze`
--
ALTER TABLE `verze`
  MODIFY `id_verze` int NOT NULL AUTO_INCREMENT;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `clanky`
--
ALTER TABLE `clanky`
  ADD CONSTRAINT `ix_clanky_fk_id_autor` FOREIGN KEY (`id_autor`) REFERENCES `ucet` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `ix_clanky_fk_id_resitel` FOREIGN KEY (`id_resitel`) REFERENCES `ucet` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `ix_clanky_fk_id_stav` FOREIGN KEY (`id_stav`) REFERENCES `stav` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Omezení pro tabulku `verze`
--
ALTER TABLE `verze`
  ADD CONSTRAINT `ix_verze_fk_id_clanek` FOREIGN KEY (`id_clanek`) REFERENCES `clanky` (`id_clanek`) ON DELETE CASCADE ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
