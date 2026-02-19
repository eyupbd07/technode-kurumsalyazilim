-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 19 Şub 2026, 17:56:10
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `kurumsal_db`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `admin_hesap`
--

CREATE TABLE `admin_hesap` (
  `id` int(11) NOT NULL,
  `kullanici_adi` varchar(50) NOT NULL,
  `ad_soyad` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `sifre` varchar(255) NOT NULL,
  `rol` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `admin_hesap`
--

INSERT INTO `admin_hesap` (`id`, `kullanici_adi`, `ad_soyad`, `email`, `sifre`, `rol`) VALUES
(1, 'admin', 'admin', NULL, 'e10adc3949ba59abbe56e057f20f883e', 1),
(2, 'eyupbdm21@gmail.com', NULL, NULL, 'e10a676f0dae6e8330cb137f2815407e', 0),
(7, 'test', NULL, NULL, 'e10adc3949ba59abbe56e057f20f883e', 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `iletisim_formu`
--

CREATE TABLE `iletisim_formu` (
  `id` int(11) NOT NULL,
  `ad_soyad` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `konu` varchar(255) DEFAULT NULL,
  `mesaj` text NOT NULL,
  `tarih` timestamp NOT NULL DEFAULT current_timestamp(),
  `durum` int(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `iletisim_formu`
--

INSERT INTO `iletisim_formu` (`id`, `ad_soyad`, `email`, `konu`, `mesaj`, `tarih`, `durum`) VALUES
(1, 'Test', 'test@gmail.com', NULL, 'test', '2026-02-19 14:37:51', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `site_ayarlar`
--

CREATE TABLE `site_ayarlar` (
  `id` int(11) NOT NULL,
  `site_baslik` varchar(255) DEFAULT NULL,
  `site_desc` varchar(255) DEFAULT NULL,
  `site_logo` varchar(255) DEFAULT NULL,
  `site_footer` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tablo döküm verisi `site_ayarlar`
--

INSERT INTO `site_ayarlar` (`id`, `site_baslik`, `site_desc`, `site_logo`, `site_footer`) VALUES
(1, 'TechNode Portfolio', 'Modern Graphic Design & Development', NULL, '© 2026 TechNode - Eyüp Bademci');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `admin_hesap`
--
ALTER TABLE `admin_hesap`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `iletisim_formu`
--
ALTER TABLE `iletisim_formu`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `site_ayarlar`
--
ALTER TABLE `site_ayarlar`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `admin_hesap`
--
ALTER TABLE `admin_hesap`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Tablo için AUTO_INCREMENT değeri `iletisim_formu`
--
ALTER TABLE `iletisim_formu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `site_ayarlar`
--
ALTER TABLE `site_ayarlar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
