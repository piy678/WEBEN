-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 21. Mai 2025 um 19:13
-- Server-Version: 10.4.32-MariaDB
-- PHP-Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `webshop`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `benutzer`
--

CREATE TABLE `benutzer` (
  `id` int(11) NOT NULL,
  `vorname` varchar(50) NOT NULL,
  `nachname` varchar(50) NOT NULL,
  `adresse` varchar(100) NOT NULL,
  `plz` varchar(10) NOT NULL,
  `ort` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `benutzername` varchar(50) NOT NULL,
  `passwort` varchar(255) NOT NULL,
  `zahlungsmethode` enum('Rechnung','PayPal','Kreditkarte') NOT NULL,
  `registriert_am` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 = aktiv, 0 = deaktiviert'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `benutzer`
--

INSERT INTO `benutzer` (`id`, `vorname`, `nachname`, `adresse`, `plz`, `ort`, `email`, `benutzername`, `passwort`, `zahlungsmethode`, `registriert_am`, `is_admin`, `is_active`) VALUES
(1, 'Yufeng', 'Cai', 'Forsthausgasse 15/7/6', '1200', 'vienna', 'caiyufeng030114@gmail.com', 'Cai', '$2y$10$CXH6QTS7JvdC9Mmxx0nt/uXEMIneHzzAUS0.xIw86YGJuu0LlhWM6', 'Kreditkarte', '2025-05-07 14:28:54', 1, 1),
(3, 'A', 'gast', 'gast', '1200', 'vienna', 'gast@gmail.com', 'GastA', '$2y$10$kkwa2KvGatbJP7ey0bHVLep6Hr3syV2qVUtORS/B63afonWn3qZuO', 'Rechnung', '2025-05-07 14:47:35', 0, 1),
(4, 'py', 'y', 'qwerta', '1110', 'Wien', 'py345@hotmail.com', 'piy678', '$2y$10$8zaz1i2CDX/kQ.3DVTOTZ.uipAGZjQXN1leaFwiu2CFPB4Kb9uipy', 'PayPal', '2025-05-17 22:59:30', 0, 1),
(6, 'admin', 'user', 'Adresse 1', '1120', 'Wien', 'admin@hotmail.com', 'admin', '$2y$10$8zaz1i2CDX/kQ.3DVTOTZ.uipAGZjQXN1leaFwiu2CFPB4Kb9uipy', 'Rechnung', '2025-05-17 23:25:21', 1, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `login_tokens`
--

CREATE TABLE `login_tokens` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(64) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `login_tokens`
--

INSERT INTO `login_tokens` (`id`, `user_id`, `token`, `created_at`) VALUES
(1, 4, 'ddb1da377cab51cb080e170b3206a585d751968551c5b822ea255ffc1250b585', '2025-05-19 20:26:09'),
(2, 4, '858a6fcda685c6a84bbb39edcb6c8131dfd57db45314488a45279d6ad970d25b', '2025-05-20 20:45:03'),
(3, 4, '57a0b66a90f28a61262014d4c1efc5749e3922b47758581b67f663d824630302', '2025-05-21 13:30:28');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_price`, `payment_method`, `created_at`) VALUES
(1, 1, 45.00, NULL, '2025-04-29 22:13:11'),
(2, 1, 29.99, NULL, '2025-04-29 22:18:49'),
(3, 2, 105.00, NULL, '2025-05-02 12:48:14'),
(4, 2, 84.90, NULL, '2025-05-02 13:42:03'),
(5, 3, 25.00, NULL, '2025-05-07 13:23:21'),
(6, 4, 64.90, NULL, '2025-05-19 00:41:35'),
(7, 4, 64.90, 'kreditkarte', '2025-05-19 23:46:44'),
(8, 4, 84.90, 'kreditkarte', '2025-05-20 19:28:01'),
(9, 4, 84.90, 'kreditkarte', '2025-05-20 20:06:38'),
(10, 4, 70.30, 'kreditkarte', '2025-05-20 23:01:44'),
(11, 6, 29.90, 'kreditkarte', '2025-05-21 01:58:44');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `title`, `price`, `quantity`) VALUES
(1, 1, 3, 'Theaterstück: Hamlet', 29.99, 2),
(4, 2, 2, 'Jazz Night', 35.00, 1),
(5, 3, 2, 'Jazz Night', 35.00, 3),
(6, 4, 3, 'Theaterstück: Hamlet', 29.90, 1),
(7, 4, 4, 'Oper Nacht', 55.00, 1),
(8, 0, 1, 'Rock Konzert', 45.00, 3),
(10, 0, 2, 'Jazz Night', 35.00, 1),
(12, 6, 3, 'Theaterstück: Hamlet', 29.90, 1),
(14, 7, 3, 'Theaterstück: Hamlet', 29.90, 1),
(15, 8, 4, 'Oper Nacht', 55.00, 1),
(16, 8, 3, 'Theaterstück: Hamlet', 29.90, 1),
(17, 9, 3, 'Theaterstück: Hamlet', 29.90, 1),
(18, 9, 4, 'Oper Nacht', 55.00, 1),
(20, 10, 23, 'Theaterstück: Faust 2', 20.50, 1),
(21, 11, 3, 'Theaterstück: Hamlet', 29.90, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `rating` float DEFAULT 0,
  `description` text DEFAULT NULL,
  `available` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `tickets`
--

INSERT INTO `tickets` (`id`, `title`, `category`, `price`, `image`, `rating`, `description`, `available`) VALUES
(2, 'Jazz Night', 'Konzert', 35.00, 'jazz.webp', 4.1, '', 0),
(3, 'Theaterstück: Hamlet', 'Konzert', 29.90, 'hamlet.webp', 4.9, '', 0),
(4, 'Oper Nacht', 'Theater', 55.00, 'oper.jpg', 4.9, '', 0),
(5, 'Bundesliga Spiel', 'Sport', 50.00, 'Bundesliga.avif', 4, '', 0),
(6, 'Marathon 2025', 'Sport', 40.00, 'marathon.webp', 2.5, '', 0),
(7, 'Theaterstück: Faust', 'Theater', 29.90, 'Faust.jpg', 4, '', 0),
(10, 'Rock Konzert', 'Konzert', 45.25, 'rock.webp', 3.5, '', 0),
(13, 'Klassik: Piano', 'Konzert', 29.99, 'piano.webp', 4.8, '', 0),
(23, 'Theaterstück: Faust 2', 'Theater', 20.50, 'faust2.jpg', 4.3, '', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `vouchers`
--

CREATE TABLE `vouchers` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `value` decimal(10,2) NOT NULL,
  `valid_until` date NOT NULL,
  `used` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `vouchers`
--

INSERT INTO `vouchers` (`id`, `code`, `value`, `valid_until`, `used`) VALUES
(1, 'test10', 10.00, '2025-12-31', 1),
(2, 'gutschein5', 5.00, '2025-12-31', 0),
(3, 'GS81V', 15.00, '2025-05-25', 0),
(4, 'ZN14D', 10.00, '2025-05-27', 0),
(5, 'AV284', 24.00, '2025-05-23', 0);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `benutzer`
--
ALTER TABLE `benutzer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `benutzername` (`benutzername`);

--
-- Indizes für die Tabelle `login_tokens`
--
ALTER TABLE `login_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `benutzer`
--
ALTER TABLE `benutzer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT für Tabelle `login_tokens`
--
ALTER TABLE `login_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT für Tabelle `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT für Tabelle `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT für Tabelle `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
