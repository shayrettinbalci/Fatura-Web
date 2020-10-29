-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost
-- Üretim Zamanı: 28 Tem 2018, 21:33:18
-- Sunucu sürümü: 5.7.17-log
-- PHP Sürümü: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `faturadb`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `fatura`
--

CREATE TABLE `fatura` (
  `faturaID` int(11) NOT NULL,
  `kullanici_isim` varchar(49) COLLATE utf32_turkish_ci NOT NULL,
  `kullanici_Fadi` varchar(50) COLLATE utf32_turkish_ci NOT NULL,
  `musteri` varchar(49) COLLATE utf32_turkish_ci NOT NULL,
  `partner` varchar(49) COLLATE utf32_turkish_ci NOT NULL,
  `manager` varchar(49) COLLATE utf32_turkish_ci NOT NULL,
  `fatura_no` varchar(255) COLLATE utf32_turkish_ci DEFAULT NULL,
  `giris_tarih` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fatura_tarihi` varchar(15) COLLATE utf32_turkish_ci NOT NULL,
  `tutar` float NOT NULL,
  `birim` varchar(11) COLLATE utf32_turkish_ci NOT NULL,
  `vergi_yuzde` int(11) NOT NULL,
  `isin_turu` varchar(49) COLLATE utf32_turkish_ci NOT NULL,
  `damga_vergisi` varchar(49) COLLATE utf32_turkish_ci NOT NULL,
  `fatura_turu` varchar(255) COLLATE utf32_turkish_ci NOT NULL,
  `onay_durumu` tinyint(1) DEFAULT '0',
  `aciklama` text COLLATE utf32_turkish_ci,
  `istek_iptal` text COLLATE utf32_turkish_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanici`
--

CREATE TABLE `kullanici` (
  `ID` int(11) NOT NULL,
  `kullanici_adi` varchar(50) COLLATE utf32_turkish_ci NOT NULL,
  `kullanici_parola` varchar(255) COLLATE utf32_turkish_ci NOT NULL,
  `kullanici_isim` varchar(36) COLLATE utf32_turkish_ci NOT NULL,
  `kullanici_email` varchar(49) COLLATE utf32_turkish_ci NOT NULL,
  `kullanici_yetki` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_turkish_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `musteri`
--

CREATE TABLE `musteri` (
  `musteri_ID` int(11) NOT NULL,
  `musteri_ad` varchar(255) COLLATE utf8mb4_turkish_ci NOT NULL,
  `musteri_adres` varchar(255) COLLATE utf8mb4_turkish_ci NOT NULL,
  `musteri_vergino` bigint(11) NOT NULL,
  `musteri_turu` varchar(255) COLLATE utf8mb4_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo için indeksler `fatura`
--
ALTER TABLE `fatura`
  ADD PRIMARY KEY (`faturaID`);

--
-- Tablo için indeksler `kullanici`
--
ALTER TABLE `kullanici`
  ADD PRIMARY KEY (`ID`,`kullanici_adi`,`kullanici_email`);

--
-- Tablo için indeksler `musteri`
--
ALTER TABLE `musteri`
  ADD PRIMARY KEY (`musteri_ID`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `fatura`
--
ALTER TABLE `fatura`
  MODIFY `faturaID` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `kullanici`
--
ALTER TABLE `kullanici`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `musteri`
--
ALTER TABLE `musteri`
  MODIFY `musteri_ID` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
