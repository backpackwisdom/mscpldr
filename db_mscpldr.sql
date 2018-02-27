-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2018. Feb 27. 11:42
-- Kiszolgáló verziója: 10.1.29-MariaDB
-- PHP verzió: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `db_mscpldr`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `albums`
--

CREATE TABLE `albums` (
  `id` int(10) UNSIGNED NOT NULL,
  `n_felh_id` int(10) UNSIGNED NOT NULL,
  `c_albumnev` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `c_eloado` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `n_kiadev` int(11) NOT NULL,
  `c_albumlink` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `c_boritonev` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `c_leiras` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `n_mufaj_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `albumtracks`
--

CREATE TABLE `albumtracks` (
  `id` int(10) UNSIGNED NOT NULL,
  `n_album_id` int(10) UNSIGNED NOT NULL,
  `n_szam_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `favorites`
--

CREATE TABLE `favorites` (
  `id` int(10) UNSIGNED NOT NULL,
  `c_tipus` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `n_tipus_id` int(11) NOT NULL,
  `n_felh_id` int(10) UNSIGNED NOT NULL,
  `d_jelol_datum` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `followers`
--

CREATE TABLE `followers` (
  `id` int(10) UNSIGNED NOT NULL,
  `c_koveto` int(10) UNSIGNED NOT NULL,
  `c_kovetett` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `genres`
--

CREATE TABLE `genres` (
  `id` int(10) UNSIGNED NOT NULL,
  `c_mufajnev` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `genres`
--

INSERT INTO `genres` (`id`, `c_mufajnev`) VALUES
(1, 'Ambient'),
(2, 'Breakbeat'),
(3, 'Downtempo'),
(4, 'Drum and bass'),
(5, 'Electro'),
(6, 'Hardcore'),
(7, 'Hardstyle'),
(8, 'House'),
(9, 'Industrial'),
(10, 'IDM'),
(11, 'Techno'),
(12, 'Trance'),
(13, 'Alternative rock'),
(14, 'Indie rock'),
(15, 'Post-punk'),
(16, 'Punk'),
(17, 'Progressive rock'),
(18, 'Metal'),
(19, 'Grunge rock');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- A tábla adatainak kiíratása `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(9, '2018_01_18_140018_create_users_table', 1),
(10, '2018_01_23_112537_create_followers_table', 1),
(11, '2018_01_23_155821_create_genres_table', 1),
(12, '2018_01_23_164400_create_tracks_table', 1),
(13, '2018_01_26_183855_create_posts_table', 1),
(14, '2018_01_28_162158_create_favorites_table', 1),
(15, '2018_01_29_180911_create_albums_table', 1),
(16, '2018_01_29_181443_create_albumtracks_table', 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `posts`
--

CREATE TABLE `posts` (
  `id` int(10) UNSIGNED NOT NULL,
  `n_felh_id` int(10) UNSIGNED NOT NULL,
  `c_tipus` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `n_tipus_id` int(11) NOT NULL,
  `n_valasz_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `c_szoveg` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `tracks`
--

CREATE TABLE `tracks` (
  `id` int(10) UNSIGNED NOT NULL,
  `n_felhid` int(10) UNSIGNED NOT NULL,
  `c_cim` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `c_eloado` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `c_album` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `c_zenenev` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `c_zenelink` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `c_boritonev` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `n_kiadev` int(11) NOT NULL,
  `c_leiras` text COLLATE utf8mb4_unicode_ci,
  `n_mufajazon` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `c_felhnev` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `c_jelszo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `c_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `c_avatarlink` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'noavatar.jpg',
  `c_statusz` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`id`),
  ADD KEY `albums_n_felh_id_foreign` (`n_felh_id`),
  ADD KEY `albums_n_mufaj_id_foreign` (`n_mufaj_id`);

--
-- A tábla indexei `albumtracks`
--
ALTER TABLE `albumtracks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `albumtracks_n_album_id_foreign` (`n_album_id`),
  ADD KEY `albumtracks_n_szam_id_foreign` (`n_szam_id`);

--
-- A tábla indexei `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `favorites_n_felh_id_foreign` (`n_felh_id`);

--
-- A tábla indexei `followers`
--
ALTER TABLE `followers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `followers_c_koveto_foreign` (`c_koveto`),
  ADD KEY `followers_c_kovetett_foreign` (`c_kovetett`);

--
-- A tábla indexei `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posts_n_felh_id_foreign` (`n_felh_id`);

--
-- A tábla indexei `tracks`
--
ALTER TABLE `tracks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tracks_n_felhid_foreign` (`n_felhid`),
  ADD KEY `tracks_n_mufajazon_foreign` (`n_mufajazon`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `albums`
--
ALTER TABLE `albums`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `albumtracks`
--
ALTER TABLE `albumtracks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `followers`
--
ALTER TABLE `followers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT a táblához `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT a táblához `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `tracks`
--
ALTER TABLE `tracks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `albums`
--
ALTER TABLE `albums`
  ADD CONSTRAINT `albums_n_felh_id_foreign` FOREIGN KEY (`n_felh_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `albums_n_mufaj_id_foreign` FOREIGN KEY (`n_mufaj_id`) REFERENCES `genres` (`id`);

--
-- Megkötések a táblához `albumtracks`
--
ALTER TABLE `albumtracks`
  ADD CONSTRAINT `albumtracks_n_album_id_foreign` FOREIGN KEY (`n_album_id`) REFERENCES `albums` (`id`),
  ADD CONSTRAINT `albumtracks_n_szam_id_foreign` FOREIGN KEY (`n_szam_id`) REFERENCES `tracks` (`id`);

--
-- Megkötések a táblához `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_n_felh_id_foreign` FOREIGN KEY (`n_felh_id`) REFERENCES `users` (`id`);

--
-- Megkötések a táblához `followers`
--
ALTER TABLE `followers`
  ADD CONSTRAINT `followers_c_kovetett_foreign` FOREIGN KEY (`c_kovetett`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `followers_c_koveto_foreign` FOREIGN KEY (`c_koveto`) REFERENCES `users` (`id`);

--
-- Megkötések a táblához `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_n_felh_id_foreign` FOREIGN KEY (`n_felh_id`) REFERENCES `users` (`id`);

--
-- Megkötések a táblához `tracks`
--
ALTER TABLE `tracks`
  ADD CONSTRAINT `tracks_n_felhid_foreign` FOREIGN KEY (`n_felhid`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tracks_n_mufajazon_foreign` FOREIGN KEY (`n_mufajazon`) REFERENCES `genres` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
