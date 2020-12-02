-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Počítač: localhost
-- Vytvořeno: Úte 01. pro 2020, 23:59
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
  `termin_recenze` datetime DEFAULT NULL COMMENT 'Termín zpracování recenze článku'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci COMMENT='Tabulka článků';

--
-- Vypisuji data pro tabulku `clanky`
--

INSERT INTO `clanky` (`id_clanek`, `id_autor`, `id_stav`, `nazev`, `id_resitel`, `id_recenzent1`, `id_recenzent2`, `hodnoceni_recenzent1`, `hodnoceni_recenzent2`, `termin_recenze`) VALUES
(3, NULL, 1, '104', NULL, 5, 6, 'No jde to', 'Skvělé!', NULL),
(4, NULL, 1, '105', NULL, 5, 6, 'ok', '', NULL),
(5, NULL, 1, 'Dod01', NULL, 5, 6, '', '', NULL),
(6, NULL, 1, 'Dor01', NULL, 5, 6, '', '', NULL),
(7, NULL, 1, 'Zkouska03', NULL, 5, 6, '', 'Test hodnocení', NULL),
(8, NULL, 1, 'Pepa91', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktura tabulky `logos_login`
--

CREATE TABLE `logos_login` (
  `id_login` int NOT NULL,
  `jmeno` varchar(255) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `heslo` varchar(255) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `sk_jmeno` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci NOT NULL,
  `sk_prijmeni` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci NOT NULL,
  `zmena_hesla` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Vypisuji data pro tabulku `logos_login`
--

INSERT INTO `logos_login` (`id_login`, `jmeno`, `heslo`, `sk_jmeno`, `sk_prijmeni`, `zmena_hesla`) VALUES
(1, 'admin', 'admin', 'admin', 'admin', 'NE'),
(2, 'ctenar', 'ctenar', 'ctenar', 'ctenar', '0'),
(3, 'test', 'test', 'test', 'test', 'ano'),
(7, 'bb', 'bb', 'bbb', 'bbb', 'ANO'),
(8, 'hgnfhn', 'sfgby', 'dfbd', 'ghsn gh', 'ANO'),
(9, 'qdqwqqwd', '', '', '', 'ANO'),
(10, 'recenzent1', 'recenzent', 'recenzent', 'recenzent', 'ANO'),
(11, 'recenzent2', 'recenzent', 'recenzent', 'recenzent', 'ANO');

-- --------------------------------------------------------

--
-- Struktura tabulky `ma_prava`
--

CREATE TABLE `ma_prava` (
  `id` int NOT NULL,
  `id_login` int NOT NULL,
  `id_prava` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Vypisuji data pro tabulku `ma_prava`
--

INSERT INTO `ma_prava` (`id`, `id_login`, `id_prava`) VALUES
(1, 1, 1),
(2, 2, 2),
(12, 10, 5);

-- --------------------------------------------------------

--
-- Struktura tabulky `prava`
--

CREATE TABLE `prava` (
  `id_prava` int NOT NULL,
  `typ_uctu` varchar(255) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Vypisuji data pro tabulku `prava`
--

INSERT INTO `prava` (`id_prava`, `typ_uctu`) VALUES
(1, 'admin'),
(3, 'autor'),
(2, 'ctenar'),
(5, 'recenzent'),
(7, 'redakcni_rada'),
(4, 'redaktor'),
(6, 'sef_redaktor');

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
(6, 'Zamítnuto');

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
(6, 'recenzent2', 'recenzent2', 'recenzent2', 'recenzent2', 'recenzent', 'NE');

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
-- Vypisuji data pro tabulku `verze`
--

INSERT INTO `verze` (`id_verze`, `id_clanek`, `cesta`, `datum`) VALUES
(1, 3, 'clanky/104.docx', '2020-11-28 20:21:46'),
(2, 4, 'clanky/105.docx', '2020-11-28 20:26:22'),
(3, 5, 'clanky/Dod01.docx', '2020-11-29 11:09:00'),
(4, 6, 'clanky/Dor01.docx', '2020-11-29 11:10:30'),
(5, 7, 'clanky/Zkouska03.docx', '2020-11-29 11:37:38'),
(14, 8, 'clanky/Pepa91.docx', '2020-12-01 19:42:32');

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
-- Klíče pro tabulku `logos_login`
--
ALTER TABLE `logos_login`
  ADD PRIMARY KEY (`id_login`) USING BTREE COMMENT 'Primární klíč tabulky',
  ADD UNIQUE KEY `ix_logos_login_uq_jmeno` (`jmeno`) USING BTREE COMMENT 'Alternativní klíč tabulky - nelze evidovat 2 stejné jména - kolidovalo by v případě stejného hesla a nikdo by se nepřihlásil';

--
-- Klíče pro tabulku `ma_prava`
--
ALTER TABLE `ma_prava`
  ADD PRIMARY KEY (`id`) USING BTREE COMMENT 'Primární klíč tabulky',
  ADD UNIQUE KEY `ix_ma_prava_uq_id_login_id_prava` (`id_login`,`id_prava`) USING BTREE COMMENT 'Alternativní klíč tabulky - nelze evidovat 2x stejný login se stejnými právy',
  ADD KEY `ix_ma_prava_fk_id_prava` (`id_prava`) USING BTREE COMMENT 'Cizí klíč - tabulka prava, sloupec id_prava',
  ADD KEY `ix_ma_prava_fk_id_login` (`id_login`) USING BTREE COMMENT 'Cizí klíč - tabulka logos_login, sloupec id_login';

--
-- Klíče pro tabulku `prava`
--
ALTER TABLE `prava`
  ADD PRIMARY KEY (`id_prava`) USING BTREE COMMENT 'Primární klíč tabulky',
  ADD UNIQUE KEY `ix_prava_uq_typ_uctu` (`typ_uctu`) USING BTREE COMMENT 'Alternativní klíč tabulky - nelze evidovat 2 stejné typy účtu';

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
  MODIFY `id_clanek` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pro tabulku `logos_login`
--
ALTER TABLE `logos_login`
  MODIFY `id_login` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pro tabulku `ma_prava`
--
ALTER TABLE `ma_prava`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pro tabulku `stav`
--
ALTER TABLE `stav`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pro tabulku `ucet`
--
ALTER TABLE `ucet`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pro tabulku `verze`
--
ALTER TABLE `verze`
  MODIFY `id_verze` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `clanky`
--
ALTER TABLE `clanky`
  ADD CONSTRAINT `ix_clanky_fk_id_autor` FOREIGN KEY (`id_autor`) REFERENCES `logos_login` (`id_login`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `ix_clanky_fk_id_resitel` FOREIGN KEY (`id_resitel`) REFERENCES `logos_login` (`id_login`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `ix_clanky_fk_id_stav` FOREIGN KEY (`id_stav`) REFERENCES `stav` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Omezení pro tabulku `ma_prava`
--
ALTER TABLE `ma_prava`
  ADD CONSTRAINT `ix_ma_prava_fk_id_login` FOREIGN KEY (`id_login`) REFERENCES `logos_login` (`id_login`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `ix_ma_prava_fk_id_prava` FOREIGN KEY (`id_prava`) REFERENCES `prava` (`id_prava`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Omezení pro tabulku `verze`
--
ALTER TABLE `verze`
  ADD CONSTRAINT `ix_verze_fk_id_clanek` FOREIGN KEY (`id_clanek`) REFERENCES `clanky` (`id_clanek`) ON DELETE CASCADE ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
