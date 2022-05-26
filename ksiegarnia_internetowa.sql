-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 12 Cze 2021, 14:56
-- Wersja serwera: 10.4.19-MariaDB
-- Wersja PHP: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `ksiegarnia_internetowa`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `administratorzy`
--

CREATE TABLE `administratorzy` (
  `ID_administratora` int(11) NOT NULL,
  `Adres_email` varchar(32) NOT NULL,
  `Nazwa_użytkownika` varchar(32) NOT NULL,
  `Hasło` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `administratorzy`
--

INSERT INTO `administratorzy` (`ID_administratora`, `Adres_email`, `Nazwa_użytkownika`, `Hasło`) VALUES
(1, 'admin1@gmail.com', 'admin1', '$2y$10$7SsPIen8QoxpahLtK83WPeCvzHsFPouLRTkqNoBZ5vbw8G.4cZQpK'),
(3, 'admin2@gmail.com', 'admin2', '$2y$10$Ls.GtHosTr0EjledL0v0NuwVvBHa39/vTlnJl1ka20XvMw4do62Sm');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `autorzy`
--

CREATE TABLE `autorzy` (
  `ID_autora` int(11) NOT NULL,
  `Imie` varchar(32) NOT NULL,
  `Nazwisko` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `autorzy`
--

INSERT INTO `autorzy` (`ID_autora`, `Imie`, `Nazwisko`) VALUES
(1, 'John Ronald Reuel', 'Tolkien'),
(2, 'J.K.', 'Rowling'),
(3, 'Andrzej ', 'Sapkowski'),
(4, 'Olga', 'Tokarczuk'),
(5, 'Stephen', 'King'),
(6, 'Katarzyna', 'Bonda'),
(7, 'Aleksander ', 'Fredro'),
(9, 'Philip ', 'K. Dick'),
(10, 'Marek ', 'Aureliusz'),
(11, 'William ', 'Szekspir'),
(12, 'Alexander ', 'Dumas'),
(13, 'Stephen', 'Hawking'),
(14, 'Lee', 'Child'),
(15, 'Bolesław', 'Prus');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `faktury`
--

CREATE TABLE `faktury` (
  `ID_faktury` int(11) NOT NULL,
  `Nr_faktury` varchar(30) NOT NULL,
  `Data_wystawienia` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `faktury`
--

INSERT INTO `faktury` (`ID_faktury`, `Nr_faktury`, `Data_wystawienia`) VALUES
(5, 'KL/234', '2021-05-18'),
(6, 'KL/2334', '2021-05-18'),
(9, 'KW/345', '2021-05-26'),
(10, 'KBB/345', '2021-05-18'),
(12, 'KS/89403', '2021-06-12'),
(13, 'KS/13752', '2021-06-12');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kategorie`
--

CREATE TABLE `kategorie` (
  `ID_kategorii` int(11) NOT NULL,
  `Nazwa` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `kategorie`
--

INSERT INTO `kategorie` (`ID_kategorii`, `Nazwa`) VALUES
(1, 'Fantastyka'),
(2, 'Przygodowe'),
(3, 'Kryminał'),
(4, 'Horror'),
(5, 'Naukowe'),
(6, 'Filozoficzne'),
(7, 'Komedia'),
(8, 'Sci-fi'),
(9, 'Literatura Piękna'),
(10, 'Dramat'),
(11, 'Fikcja');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `klienci`
--

CREATE TABLE `klienci` (
  `ID_klienta` int(11) NOT NULL,
  `Imię` varchar(32) NOT NULL,
  `Nazwisko` varchar(32) NOT NULL,
  `Adres_zamieszkania` varchar(64) NOT NULL,
  `Nr_telefonu` int(32) NOT NULL,
  `Adres_email` varchar(32) NOT NULL,
  `Nazwa_użytkownika` varchar(32) NOT NULL,
  `Hasło` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `klienci`
--

INSERT INTO `klienci` (`ID_klienta`, `Imię`, `Nazwisko`, `Adres_zamieszkania`, `Nr_telefonu`, `Adres_email`, `Nazwa_użytkownika`, `Hasło`) VALUES
(23, 'Jan', 'Kowalski', 'Kwiatowa 45 Rzeszów 32-510', 124356324, 'janek@wp.pl', 'janek', '$2y$10$YbcabiRbLTT6R.FPIKgj/.c/aUGWh81Yxwnl4X5qo3m037E/4XK9S'),
(24, 'Andrzej', 'Nowak', 'Fajna 2a/21 Poznań 30-100', 123453408, 'andrzej@wp.pl', 'andy1', '$2y$10$f8SnjSLE4HBB6ny8DyCE3uSJrpR4TxdDlaeua8tzTfx.I7mBhMNU6'),
(25, 'Andrzej', 'Muł', 'Biała 123 Rzeszów 30-252', 234543454, 'andy@wp.pl', 'andrzej2', '$2y$10$LejnVOZsivZb7r1z.2zUR.gZpb8NkpKNrvDZ9y.Wo2hV5ONDXjt9m'),
(26, 'Anna', 'Kowalska', 'Krajowa 200 Bydgoszcz 40-200', 234543456, 'ania@wp.pl', 'ania2', '$2y$10$EFpexOdcq7hoclPYZ4KPueN4HBwJRr7BGALTKhOLyXfVEmHvsBD5q'),
(27, 'Rafał', 'Kowalski', 'Kwiatowa 3a/26 Szczecin 30-100', 234565431, 'rafal@interia.pl', 'rafal2', '$2y$10$rXbbjf4N1axM8/fWiV8FXuBIUOZkVgY/XoYktZLS2ZtlmgvLEkaYK'),
(29, 'Adam', 'Michalak', 'Leśnia 125 Rzeszów 32-252', 324657321, 'adamek1@wp.pl', 'adas11', '$2y$10$1GJSYwco5VNEWIkl5XQp/ONSsF.ndQc908divu/Z.hs0HNLRmk0E6');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `książki`
--

CREATE TABLE `książki` (
  `ID_ksiązki` int(11) NOT NULL,
  `ID_wydawnictwa` int(11) NOT NULL,
  `ID_kategorii` int(11) NOT NULL,
  `Tytuł` varchar(32) NOT NULL,
  `Rok_wydania` int(11) NOT NULL,
  `Cena` double NOT NULL,
  `Liczba_sztuk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `książki`
--

INSERT INTO `książki` (`ID_ksiązki`, `ID_wydawnictwa`, `ID_kategorii`, `Tytuł`, `Rok_wydania`, `Cena`, `Liczba_sztuk`) VALUES
(1, 1, 1, 'Władca Pierścieni', 2002, 15, 4),
(2, 6, 1, 'Wiedźmin Ostatnie Życzenie', 2004, 19, 0),
(3, 4, 4, 'To(It)', 1996, 25, 0),
(4, 2, 10, 'Romeo i Julia', 1988, 35, 0),
(5, 5, 3, 'Harry Potter i Zakon Feniksa', 2006, 25, 6);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `książki_autorzy`
--

CREATE TABLE `książki_autorzy` (
  `ID_książki` int(11) NOT NULL,
  `ID_autora` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `książki_autorzy`
--

INSERT INTO `książki_autorzy` (`ID_książki`, `ID_autora`) VALUES
(5, 2),
(4, 11),
(3, 5),
(2, 3),
(1, 1),
(5, 7);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `szczegóły_zamowienia`
--

CREATE TABLE `szczegóły_zamowienia` (
  `ID` int(11) NOT NULL,
  `ID_zamówienia` int(11) NOT NULL,
  `ID_książki` int(11) NOT NULL,
  `Ilość` int(11) NOT NULL,
  `Cena` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `szczegóły_zamowienia`
--

INSERT INTO `szczegóły_zamowienia` (`ID`, `ID_zamówienia`, `ID_książki`, `Ilość`, `Cena`) VALUES
(1, 1, 1, 2, 30),
(2, 1, 3, 2, 50),
(3, 1, 4, 2, 35),
(9, 10, 1, 1, 15),
(10, 10, 5, 3, 25),
(11, 11, 3, 1, 25),
(12, 10, 3, 1, 25),
(13, 11, 2, 2, 38),
(14, 12, 5, 4, 25),
(15, 13, 3, 1, 25),
(16, 14, 2, 1, 19),
(17, 15, 1, 1, 15);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `wydawnictwa`
--

CREATE TABLE `wydawnictwa` (
  `ID_wydawnictwa` int(11) NOT NULL,
  `Nazwa` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `wydawnictwa`
--

INSERT INTO `wydawnictwa` (`ID_wydawnictwa`, `Nazwa`) VALUES
(1, 'Helion'),
(2, 'WSiP'),
(3, 'Dreams'),
(4, 'Bezdroża'),
(5, 'PWN'),
(6, 'Czwarta Strona'),
(7, 'Supernowa'),
(8, 'Wydawnictwo Literackie'),
(9, 'Znak');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zamówienia`
--

CREATE TABLE `zamówienia` (
  `ID_zamowienia` int(11) NOT NULL,
  `ID_klienta` int(11) NOT NULL,
  `ID_faktury` int(11) DEFAULT NULL,
  `Rabat` int(11) NOT NULL,
  `Data_złożenia` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `zamówienia`
--

INSERT INTO `zamówienia` (`ID_zamowienia`, `ID_klienta`, `ID_faktury`, `Rabat`, `Data_złożenia`) VALUES
(1, 25, 5, 0, '2021-05-11'),
(2, 27, NULL, 0, '2021-05-18'),
(3, 25, NULL, 0, '2021-05-11'),
(4, 27, NULL, 0, '2021-05-18'),
(10, 23, 9, 5, '2021-05-17'),
(11, 23, 10, 5, '2021-05-26'),
(12, 29, NULL, 5, '2021-06-12'),
(13, 29, NULL, 0, '2021-06-12'),
(14, 29, 12, 0, '2021-06-12'),
(15, 23, 13, 0, '2021-06-12');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `administratorzy`
--
ALTER TABLE `administratorzy`
  ADD PRIMARY KEY (`ID_administratora`),
  ADD UNIQUE KEY `Nazwa_uzytkownika` (`Nazwa_użytkownika`),
  ADD KEY `Nazwa_uzytkownika_2` (`Nazwa_użytkownika`),
  ADD KEY `Nazwa_uzytkownika_3` (`Nazwa_użytkownika`);

--
-- Indeksy dla tabeli `autorzy`
--
ALTER TABLE `autorzy`
  ADD PRIMARY KEY (`ID_autora`);

--
-- Indeksy dla tabeli `faktury`
--
ALTER TABLE `faktury`
  ADD PRIMARY KEY (`ID_faktury`);

--
-- Indeksy dla tabeli `kategorie`
--
ALTER TABLE `kategorie`
  ADD PRIMARY KEY (`ID_kategorii`);

--
-- Indeksy dla tabeli `klienci`
--
ALTER TABLE `klienci`
  ADD PRIMARY KEY (`ID_klienta`),
  ADD UNIQUE KEY `Nazwa_użytkownika` (`Nazwa_użytkownika`),
  ADD KEY `Nazwa_uzytkownika` (`Nazwa_użytkownika`);

--
-- Indeksy dla tabeli `książki`
--
ALTER TABLE `książki`
  ADD PRIMARY KEY (`ID_ksiązki`),
  ADD KEY `ID_wydawnictwa` (`ID_wydawnictwa`),
  ADD KEY `ID_kategorii` (`ID_kategorii`);

--
-- Indeksy dla tabeli `książki_autorzy`
--
ALTER TABLE `książki_autorzy`
  ADD KEY `ID_książki` (`ID_książki`),
  ADD KEY `ID_autora` (`ID_autora`);

--
-- Indeksy dla tabeli `szczegóły_zamowienia`
--
ALTER TABLE `szczegóły_zamowienia`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_zamówienia` (`ID_zamówienia`),
  ADD KEY `ID_książki` (`ID_książki`);

--
-- Indeksy dla tabeli `wydawnictwa`
--
ALTER TABLE `wydawnictwa`
  ADD PRIMARY KEY (`ID_wydawnictwa`);

--
-- Indeksy dla tabeli `zamówienia`
--
ALTER TABLE `zamówienia`
  ADD PRIMARY KEY (`ID_zamowienia`),
  ADD KEY `ID_klienta` (`ID_klienta`),
  ADD KEY `ID_faktury` (`ID_faktury`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `administratorzy`
--
ALTER TABLE `administratorzy`
  MODIFY `ID_administratora` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `autorzy`
--
ALTER TABLE `autorzy`
  MODIFY `ID_autora` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT dla tabeli `faktury`
--
ALTER TABLE `faktury`
  MODIFY `ID_faktury` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT dla tabeli `kategorie`
--
ALTER TABLE `kategorie`
  MODIFY `ID_kategorii` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT dla tabeli `klienci`
--
ALTER TABLE `klienci`
  MODIFY `ID_klienta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT dla tabeli `książki`
--
ALTER TABLE `książki`
  MODIFY `ID_ksiązki` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT dla tabeli `szczegóły_zamowienia`
--
ALTER TABLE `szczegóły_zamowienia`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT dla tabeli `wydawnictwa`
--
ALTER TABLE `wydawnictwa`
  MODIFY `ID_wydawnictwa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT dla tabeli `zamówienia`
--
ALTER TABLE `zamówienia`
  MODIFY `ID_zamowienia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `książki`
--
ALTER TABLE `książki`
  ADD CONSTRAINT `książki_ibfk_1` FOREIGN KEY (`ID_wydawnictwa`) REFERENCES `wydawnictwa` (`ID_wydawnictwa`),
  ADD CONSTRAINT `książki_ibfk_2` FOREIGN KEY (`ID_kategorii`) REFERENCES `kategorie` (`ID_kategorii`);

--
-- Ograniczenia dla tabeli `książki_autorzy`
--
ALTER TABLE `książki_autorzy`
  ADD CONSTRAINT `książki_autorzy_ibfk_1` FOREIGN KEY (`ID_autora`) REFERENCES `autorzy` (`ID_autora`),
  ADD CONSTRAINT `książki_autorzy_ibfk_2` FOREIGN KEY (`ID_książki`) REFERENCES `książki` (`ID_ksiązki`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `szczegóły_zamowienia`
--
ALTER TABLE `szczegóły_zamowienia`
  ADD CONSTRAINT `szczegóły_zamowienia_ibfk_1` FOREIGN KEY (`ID_zamówienia`) REFERENCES `zamówienia` (`ID_zamowienia`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `szczegóły_zamowienia_ibfk_2` FOREIGN KEY (`ID_książki`) REFERENCES `książki` (`ID_ksiązki`);

--
-- Ograniczenia dla tabeli `zamówienia`
--
ALTER TABLE `zamówienia`
  ADD CONSTRAINT `zamówienia_ibfk_1` FOREIGN KEY (`ID_klienta`) REFERENCES `klienci` (`ID_klienta`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `zamówienia_ibfk_2` FOREIGN KEY (`ID_faktury`) REFERENCES `faktury` (`ID_faktury`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
