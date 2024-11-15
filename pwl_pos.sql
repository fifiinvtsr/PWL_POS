-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 15 Nov 2024 pada 14.10
-- Versi server: 8.0.30
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pwl_pos`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_09_12_043600_create_m_level_table', 1),
(6, '2024_09_19_021158_create_m_user_table', 1),
(7, '2024_09_19_021438_create_m_kategori_table', 1),
(8, '2024_09_19_021554_create_m_barang_table', 1),
(9, '2024_09_19_021912_create_m_supplier_table', 1),
(10, '2024_09_19_021950_create_t_penjualan_table', 1),
(11, '2024_09_19_022037_create_t_penjualan_detail_table', 1),
(12, '2024_09_29_150207_add_kategori_kode_to_m_kategori_table', 2),
(13, '2024_09_30_034909_create_m_kategori_table', 3),
(14, '2024_09_30_051931_create_m_user_table', 4),
(15, '2024_09_30_052222_create_m_kategori_table', 5),
(16, '2024_09_30_052903_create_m_kategori_table', 6),
(17, '2024_09_30_053754_create_m_supplier_table', 7),
(18, '2024_09_30_054400_create_m_kategori_table', 8),
(19, '2024_10_22_105956_create_t_stok_table', 9),
(20, '2024_11_06_081518_add_image_to_m_user_table', 10),
(21, '2024_11_06_084337_add_image_to_m_barang_table', 11);

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_barang`
--

CREATE TABLE `m_barang` (
  `barang_id` bigint UNSIGNED NOT NULL,
  `kategori_id` bigint UNSIGNED NOT NULL,
  `barang_kode` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `barang_nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga_beli` int NOT NULL,
  `harga_jual` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `m_barang`
--

INSERT INTO `m_barang` (`barang_id`, `kategori_id`, `barang_kode`, `barang_nama`, `harga_beli`, `harga_jual`, `created_at`, `updated_at`) VALUES
(1, 1, 'BRK001', 'Indomie Goreng', 2200, 2500, NULL, NULL),
(2, 2, 'BRK002', 'Roti Bakar', 2000, 3000, NULL, '2024-09-30 03:38:46'),
(3, 1, 'BRK003', 'Mie Instan', 2500, 3000, NULL, NULL),
(4, 1, 'BRK004', 'Snack Keripik', 3000, 3500, NULL, NULL),
(6, 2, 'BRK006', 'Teh Botol', 2500, 3000, NULL, NULL),
(7, 2, 'BRK007', 'Air Mineral', 1000, 1500, NULL, NULL),
(8, 2, 'BRK008', 'Jus Jeruk', 5000, 6000, NULL, NULL),
(9, 2, 'BRK009', 'Kopi Instan', 3000, 3500, NULL, NULL),
(11, 3, 'BRK011', 'Kaos Polos', 30000, 35000, NULL, NULL),
(12, 3, 'BRK012', 'Jaket', 70000, 80000, NULL, NULL),
(14, 3, 'BRK014', 'Kemeja', 45000, 50000, NULL, NULL),
(15, 3, 'BRK015', 'Dress', 60000, 70000, NULL, NULL),
(18, 2, 'BRK068', 'Milo Cubes', 9500, 10000, '2024-10-03 20:47:46', '2024-10-03 20:47:46'),
(19, 5, 'BRK20', 'Cat Akrilik', 20000, 50000, '2024-10-03 20:58:31', '2024-10-03 21:01:12'),
(20, 1, 'SBK-003', 'Telur Omega (10 butir)', 22000, 25000, '2024-10-16 20:56:49', NULL),
(21, 2, 'SNK-003', 'Sari Roti', 11500, 12500, '2024-10-16 20:56:49', NULL),
(22, 3, 'MND-003', 'Shampoo Pantene', 17500, 18500, '2024-10-16 20:56:49', NULL),
(23, 4, 'BAY-003', 'Baju Bayi 2th', 89000, 92500, '2024-10-16 20:56:49', NULL),
(24, 5, 'MNM-003', 'Cle 600mL', 3750, 4300, '2024-10-16 20:56:49', NULL),
(25, 3, 'BRK006', 'Teh Kotak', 4000, 5000, '2024-11-06 00:51:30', '2024-11-06 00:51:30'),
(26, 3, 'BRK006', 'Teh Kotak', 4000, 5000, '2024-11-06 00:54:14', '2024-11-06 00:54:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_kategori`
--

CREATE TABLE `m_kategori` (
  `kategori_id` bigint UNSIGNED NOT NULL,
  `kategori_kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori_nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `m_kategori`
--

INSERT INTO `m_kategori` (`kategori_id`, `kategori_kode`, `kategori_nama`, `created_at`, `updated_at`) VALUES
(1, 'KD001', 'Minuman', NULL, '2024-09-30 03:11:19'),
(2, 'KD002', 'Makanan', NULL, NULL),
(3, 'KD003', 'Pakaian', NULL, NULL),
(4, 'KD004', 'Kendaraan', NULL, NULL),
(5, 'KD005', 'Peralatan', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_level`
--

CREATE TABLE `m_level` (
  `level_id` bigint UNSIGNED NOT NULL,
  `level_kode` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level_nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `m_level`
--

INSERT INTO `m_level` (`level_id`, `level_kode`, `level_nama`, `created_at`, `updated_at`) VALUES
(1, 'ADM', 'Administrator', NULL, NULL),
(2, 'MNG', 'Manager', NULL, NULL),
(3, 'STF', 'Staff/Kasirr', NULL, '2024-10-03 21:32:57'),
(4, 'CST', 'Customer', NULL, NULL),
(6, 'Manager', 'Mitra Wonosantri Singosari', '2024-10-03 20:09:34', '2024-10-23 03:22:36'),
(7, '1', 'SPR001', '2024-10-23 03:25:38', NULL),
(8, '2', 'SPR003', '2024-10-23 03:25:38', NULL),
(9, '3', 'SPR004', '2024-10-23 03:25:38', NULL),
(10, '4', 'SPR06', '2024-10-23 03:25:38', NULL),
(17, '6', 'ADM', '2024-10-23 04:12:16', NULL),
(18, '7', 'CST', '2024-10-23 04:12:16', NULL),
(19, '8', 'Manager', '2024-10-23 04:12:16', NULL),
(20, '9', 'MNG', '2024-10-23 04:12:16', NULL),
(21, '10', 'STF', '2024-10-23 04:12:16', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_supplier`
--

CREATE TABLE `m_supplier` (
  `supplier_id` bigint UNSIGNED NOT NULL,
  `supplier_kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_alamat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `m_supplier`
--

INSERT INTO `m_supplier` (`supplier_id`, `supplier_kode`, `supplier_nama`, `supplier_alamat`, `created_at`, `updated_at`) VALUES
(1, 'SPR001', 'Serba Guna Malang', 'Jalan Dr Cipto, Malang', NULL, NULL),
(3, 'SPR003', 'Surabaya Perkasa', 'Jalan Ahmad Yani, Surabaya', NULL, NULL),
(4, 'SPR004', 'Karya Sejahtera Surabaya', 'Jalan Basuki Rahmat, Surabaya', NULL, NULL),
(6, 'SPR06', 'Supplier Kopi', 'Singosari', '2024-09-30 03:25:03', '2024-09-30 03:25:03'),
(7, 'SPR07', 'Wonosantri', 'Singosari', '2024-10-03 19:56:59', '2024-10-03 19:56:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_user`
--

CREATE TABLE `m_user` (
  `user_id` bigint UNSIGNED NOT NULL,
  `level_id` bigint UNSIGNED NOT NULL,
  `username` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `m_user`
--

INSERT INTO `m_user` (`user_id`, `level_id`, `username`, `nama`, `password`, `created_at`, `updated_at`, `image`) VALUES
(1, 1, 'admin', 'Administrator', '$2y$12$rKX5ST91bVXsApfRDday4.sN40TLJSbpVbFWunbYta1pXgZawd.Am', NULL, '2024-10-22 15:33:27', ''),
(2, 2, 'manager', 'Manager', '$2y$12$NTxPxboLoPuRkyk14cGq4O//ibsthNcPpLBGUCcC./6blTleCfWbu', NULL, NULL, ''),
(3, 3, 'staff', 'Staff/Kasir', '$2y$12$Khf21XAeg1Jne5OHXK/Jquax4tWS7sl4x0KrzZ75uPqi5T6l6CQnW', NULL, NULL, ''),
(4, 3, 'fifinovita13', 'FIFI NOVITASARI', '$2y$12$DcUkfG9iqhsQg6GI2qLXWOiUpKHeZBdci2UOcStbhMjg0LPK3Vs1K', '2024-09-30 01:28:28', '2024-09-30 01:28:28', ''),
(5, 3, 'adminandreas', 'Fifi', '$2y$12$chHR/gycyhj0eghwsSDD.ec13KfjsJGlfyAbNxtOYIrLcPRhIY06m', '2024-10-02 19:24:32', '2024-10-02 19:24:32', ''),
(6, 1, 'adminfififi', 'Fifi Novitasari', '12345678', '2024-10-03 07:42:25', '2024-10-03 07:42:25', ''),
(7, 2, 'fifinovita12344', 'FIFI NOVITASARI', '12345678', '2024-10-03 07:48:07', '2024-10-03 07:48:07', ''),
(10, 1, 'adminfifi', 'Fifi Novitasari', '$2y$12$HmbQYAa.dO5uTkV4hd0YV.X0Kj3NxvtFXUPxp8cWMkh3A1cs0l/uK', '2024-10-11 23:52:26', '2024-10-11 23:52:26', ''),
(11, 1, 'adminfifi12', 'Fifi Novitasari', '$2y$12$f4tGye70dC.eKrZKlnh1sOh4xkXUYv33damVGB1ZC5tIXUbI1Mohi', '2024-10-22 17:27:51', '2024-10-22 17:27:51', ''),
(12, 6, 'wonosantri', 'Wonosantri Singosari', '$2y$12$Hn/Kcl92qGDH9uSKlbDvc..ogkdLqYs.smQd1gnGVD/6tATO4eQ2K', '2024-10-23 03:04:23', '2024-10-23 03:04:23', ''),
(13, 3, 'fifi1312', 'FIFI', '$2y$12$FVRZyxT2TCiKkFzoLp8I6eU0spSzFo6QLZwEsSUe.uWSMJEzSEsw6', '2024-10-23 04:08:29', '2024-10-23 04:08:29', ''),
(14, 2, 'penggunasatu', 'Pengguna 1', '$2y$12$fEQtMNXDH3jdp0bk9EcgUeCersp0QCx8dHG4SRZlotBMKQ9YLIs1W', '2024-11-05 19:17:38', '2024-11-05 19:17:38', ''),
(19, 2, 'penggunadua', 'Pengguna 2', '$2y$12$Jf4eNaA5ITDdsUQZ5qQqO.I7JwA9IYyDAX9S922eEBBdlI6UMO08W', '2024-11-06 00:34:01', '2024-11-06 00:34:01', ''),
(21, 2, 'penggunaempat', 'pengguna4', '$2y$12$P0B9eqhjb3LlGfWgqiobl.Qzuk/AKhSERW/xBkv0BdaIeB1haNDjq', '2024-11-06 01:35:27', '2024-11-06 01:35:27', 'h5KXdYzKTCAEuOJSirf0PW7h6jyrpdJafGrPZWBo.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_penjualan`
--

CREATE TABLE `t_penjualan` (
  `penjualan_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `pembeli` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `penjualan_kode` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `penjualan_tanggal` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `t_penjualan`
--

INSERT INTO `t_penjualan` (`penjualan_id`, `user_id`, `pembeli`, `penjualan_kode`, `penjualan_tanggal`, `created_at`, `updated_at`) VALUES
(1, 3, 'Andreas', 'TRS001', '2024-07-11 00:00:00', NULL, NULL),
(2, 3, 'Afifah', 'TRS002', '2024-07-12 00:00:00', NULL, NULL),
(3, 3, 'Dyah', 'TRS003', '2024-07-13 00:00:00', NULL, NULL),
(4, 3, 'Rifqi', 'TRS004', '2024-07-14 00:00:00', NULL, NULL),
(5, 1, 'Nabila', 'TRS005', '2024-07-15 00:00:00', NULL, '2024-10-23 03:51:10'),
(6, 3, 'Fafa', 'TRS006', '2024-07-16 00:00:00', NULL, NULL),
(7, 3, 'Fifi', 'TRS007', '2024-07-17 00:00:00', NULL, NULL),
(8, 3, 'Ifa', 'TRS008', '2024-07-18 00:00:00', NULL, NULL),
(9, 3, 'Wildan', 'TRS009', '2024-07-19 00:00:00', NULL, NULL),
(10, 3, 'Nasywa', 'TRS010', '2024-07-20 00:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_penjualan_detail`
--

CREATE TABLE `t_penjualan_detail` (
  `detail_id` bigint UNSIGNED NOT NULL,
  `penjualan_id` bigint UNSIGNED NOT NULL,
  `barang_id` bigint UNSIGNED NOT NULL,
  `harga` int NOT NULL,
  `jumlah` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_stok`
--

CREATE TABLE `t_stok` (
  `stok_id` bigint UNSIGNED NOT NULL,
  `supplier_id` bigint UNSIGNED NOT NULL,
  `barang_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `stok_tanggal` datetime NOT NULL,
  `stok_jumlah` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `t_stok`
--

INSERT INTO `t_stok` (`stok_id`, `supplier_id`, `barang_id`, `user_id`, `stok_tanggal`, `stok_jumlah`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '2024-10-22 14:28:15', 60, NULL, '2024-10-22 15:53:56'),
(2, 3, 2, 3, '2024-10-22 14:36:11', 20, NULL, '2024-10-23 03:47:07'),
(3, 4, 3, 3, '2024-10-22 15:37:46', 30, NULL, NULL),
(26, 3, 4, 11, '2024-12-23 00:00:00', 50, '2024-10-23 04:19:35', '2024-10-23 04:19:35');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `m_barang`
--
ALTER TABLE `m_barang`
  ADD PRIMARY KEY (`barang_id`),
  ADD KEY `m_barang_kategori_id_foreign` (`kategori_id`);

--
-- Indeks untuk tabel `m_kategori`
--
ALTER TABLE `m_kategori`
  ADD PRIMARY KEY (`kategori_id`);

--
-- Indeks untuk tabel `m_level`
--
ALTER TABLE `m_level`
  ADD PRIMARY KEY (`level_id`),
  ADD UNIQUE KEY `m_level_level_kode_unique` (`level_kode`);

--
-- Indeks untuk tabel `m_supplier`
--
ALTER TABLE `m_supplier`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indeks untuk tabel `m_user`
--
ALTER TABLE `m_user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `m_user_username_unique` (`username`),
  ADD KEY `m_user_level_id_index` (`level_id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `t_penjualan`
--
ALTER TABLE `t_penjualan`
  ADD PRIMARY KEY (`penjualan_id`),
  ADD KEY `t_penjualan_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `t_penjualan_detail`
--
ALTER TABLE `t_penjualan_detail`
  ADD PRIMARY KEY (`detail_id`),
  ADD KEY `t_penjualan_detail_barang_id_foreign` (`barang_id`),
  ADD KEY `t_penjualan_detail_penjualan_id_foreign` (`penjualan_id`);

--
-- Indeks untuk tabel `t_stok`
--
ALTER TABLE `t_stok`
  ADD PRIMARY KEY (`stok_id`),
  ADD KEY `t_stok_supplier_id_index` (`supplier_id`),
  ADD KEY `t_stok_barang_id_index` (`barang_id`),
  ADD KEY `t_stok_user_id_index` (`user_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `m_barang`
--
ALTER TABLE `m_barang`
  MODIFY `barang_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `m_kategori`
--
ALTER TABLE `m_kategori`
  MODIFY `kategori_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `m_level`
--
ALTER TABLE `m_level`
  MODIFY `level_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `m_supplier`
--
ALTER TABLE `m_supplier`
  MODIFY `supplier_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `m_user`
--
ALTER TABLE `m_user`
  MODIFY `user_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `t_penjualan`
--
ALTER TABLE `t_penjualan`
  MODIFY `penjualan_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `t_penjualan_detail`
--
ALTER TABLE `t_penjualan_detail`
  MODIFY `detail_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `t_stok`
--
ALTER TABLE `t_stok`
  MODIFY `stok_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `m_barang`
--
ALTER TABLE `m_barang`
  ADD CONSTRAINT `m_barang_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `m_kategori` (`kategori_id`);

--
-- Ketidakleluasaan untuk tabel `m_user`
--
ALTER TABLE `m_user`
  ADD CONSTRAINT `m_user_level_id_foreign` FOREIGN KEY (`level_id`) REFERENCES `m_level` (`level_id`);

--
-- Ketidakleluasaan untuk tabel `t_penjualan`
--
ALTER TABLE `t_penjualan`
  ADD CONSTRAINT `t_penjualan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `m_user` (`user_id`);

--
-- Ketidakleluasaan untuk tabel `t_penjualan_detail`
--
ALTER TABLE `t_penjualan_detail`
  ADD CONSTRAINT `t_penjualan_detail_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `m_barang` (`barang_id`),
  ADD CONSTRAINT `t_penjualan_detail_penjualan_id_foreign` FOREIGN KEY (`penjualan_id`) REFERENCES `t_penjualan` (`penjualan_id`);

--
-- Ketidakleluasaan untuk tabel `t_stok`
--
ALTER TABLE `t_stok`
  ADD CONSTRAINT `t_stok_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `m_barang` (`barang_id`),
  ADD CONSTRAINT `t_stok_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `m_supplier` (`supplier_id`),
  ADD CONSTRAINT `t_stok_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `m_user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
