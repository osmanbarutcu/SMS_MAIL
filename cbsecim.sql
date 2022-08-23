-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost
-- Üretim Zamanı: 26 May 2018, 19:22:42
-- Sunucu sürümü: 5.7.17-log
-- PHP Sürümü: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `cbsecim`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ayar`
--

CREATE TABLE `ayar` (
  `ayar_id` int(11) NOT NULL,
  `ayar_ad` varchar(250) COLLATE utf8_turkish_ci NOT NULL,
  `ayar_tur` varchar(250) COLLATE utf8_turkish_ci NOT NULL,
  `ayar_aciklama` varchar(250) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `ayar`
--

INSERT INTO `ayar` (`ayar_id`, `ayar_ad`, `ayar_tur`, `ayar_aciklama`) VALUES
(1, 'title', 'Edukey Cum. Bşk. Seçim Anket Scripti', ''),
(2, 'description', 'Edukey Cum. Bşk. Seçim Anket Scripti Eğitim Sürümü Olarak Kodlanmıştır.\r\n', ''),
(3, 'keywords', 'edukey, anket script, aday scripti, edukey script, emrah yüksel', ''),
(5, 'oyturu', '1', '0 - Sms İle1 - Mail ile Oy Verme');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `cbaday`
--

CREATE TABLE `cbaday` (
  `cbaday_id` int(11) NOT NULL,
  `cbaday_adsoyad` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `cbaday_resimyol` varchar(250) COLLATE utf8_turkish_ci NOT NULL,
  `aday_sira` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `cbaday`
--

INSERT INTO `cbaday` (`cbaday_id`, `cbaday_adsoyad`, `cbaday_resimyol`, `aday_sira`) VALUES
(7, 'Doğu Perinçek', 'dimg/adayresim/5aff30cab642f.jpg', 5),
(8, 'Meral Akşener', 'dimg/adayresim/5aff30d4c119d.jpg', 2),
(9, 'Muharrem İnce', 'dimg/adayresim/5aff30dff0c38.jpg', 0),
(10, 'Recep Tayyip Erdoğan', 'dimg/adayresim/5aff32425cf66.jpg', 1),
(11, 'Selahattin Demirtaş', 'dimg/adayresim/5aff30f9e98ed.jpg', 3),
(12, 'Temel Karamollaoğlu', 'dimg/adayresim/5aff31fc137e4.jpg', 4);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanici`
--

CREATE TABLE `kullanici` (
  `kullanici_id` int(11) NOT NULL,
  `kullanici_zaman` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `kullanici_mail` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `kullanici_password` varchar(50) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `kullanici`
--

INSERT INTO `kullanici` (`kullanici_id`, `kullanici_zaman`, `kullanici_mail`, `kullanici_password`) VALUES
(1, '2018-05-17 22:23:35', 'info@emrahyuksel.com.tr', 'e10adc3949ba59abbe56e057f20f883e');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `oy`
--

CREATE TABLE `oy` (
  `oy_id` int(11) NOT NULL,
  `oy_zaman` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cbaday_id` int(11) NOT NULL,
  `oy_araci` varchar(50) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `ayar`
--
ALTER TABLE `ayar`
  ADD PRIMARY KEY (`ayar_id`);

--
-- Tablo için indeksler `cbaday`
--
ALTER TABLE `cbaday`
  ADD PRIMARY KEY (`cbaday_id`);

--
-- Tablo için indeksler `kullanici`
--
ALTER TABLE `kullanici`
  ADD PRIMARY KEY (`kullanici_id`);

--
-- Tablo için indeksler `oy`
--
ALTER TABLE `oy`
  ADD PRIMARY KEY (`oy_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `ayar`
--
ALTER TABLE `ayar`
  MODIFY `ayar_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Tablo için AUTO_INCREMENT değeri `cbaday`
--
ALTER TABLE `cbaday`
  MODIFY `cbaday_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- Tablo için AUTO_INCREMENT değeri `kullanici`
--
ALTER TABLE `kullanici`
  MODIFY `kullanici_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Tablo için AUTO_INCREMENT değeri `oy`
--
ALTER TABLE `oy`
  MODIFY `oy_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
