-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 18 Des 2025 pada 08.05
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pelaporan_kerusakan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `reports`
--

CREATE TABLE `reports` (
  `report_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `judul` varchar(150) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `lokasi` varchar(100) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `status` enum('OPEN','PROCESS','DONE','REJECT') DEFAULT 'OPEN',
  `assigned_to` int(11) DEFAULT NULL,
  `tanggal_lapor` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `reports`
--

INSERT INTO `reports` (`report_id`, `user_id`, `judul`, `deskripsi`, `lokasi`, `foto`, `status`, `assigned_to`, `tanggal_lapor`) VALUES
(1, 6, 'kerusakan AC', 'air bocor', 'Smkn 4 padalarang, kelas xii oracle', '1766033231.png', 'DONE', 8, '2025-12-18 11:47:11'),
(2, 6, 'kerusakan laptop', 'sssd rusak', 'bandung', '1766037309.png', 'DONE', NULL, '2025-12-18 12:55:09'),
(3, 6, 'kerusakan laptop', 'ssd harus diganti', 'Smkn 4 padalarang', '1766037725.png', 'REJECT', NULL, '2025-12-18 13:02:05'),
(4, 6, 'kerusakan AC', 'AC bocor', 'Smkn 4 padalarang, kelas xii oracle', '1766039757.png', 'DONE', NULL, '2025-12-18 13:35:57');

--
-- Trigger `reports`
--
DELIMITER $$
CREATE TRIGGER `trg_tracking_update` AFTER UPDATE ON `reports` FOR EACH ROW BEGIN
    IF OLD.status <> NEW.status THEN
        INSERT INTO tracking_progress (
            report_id,
            technician_id,
            status_awal,
            status_akhir,
            catatan
        )
        VALUES (
            NEW.report_id,
            NEW.assigned_to,
            OLD.status,
            NEW.status,
            'Perubahan status otomatis oleh sistem'
        );
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tracking_progress`
--

CREATE TABLE `tracking_progress` (
  `tracking_id` int(11) NOT NULL,
  `report_id` int(11) DEFAULT NULL,
  `technician_id` int(11) DEFAULT NULL,
  `status_awal` enum('OPEN','PROCESS','DONE','REJECT') DEFAULT NULL,
  `status_akhir` enum('OPEN','PROCESS','DONE','REJECT') DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tracking_progress`
--

INSERT INTO `tracking_progress` (`tracking_id`, `report_id`, `technician_id`, `status_awal`, `status_akhir`, `catatan`, `timestamp`) VALUES
(1, 1, NULL, 'OPEN', 'PROCESS', 'Perubahan status otomatis oleh sistem', '2025-12-18 11:52:01'),
(2, 1, 8, 'PROCESS', 'DONE', 'Perubahan status otomatis oleh sistem', '2025-12-18 12:53:56'),
(3, 1, 8, 'PROCESS', 'DONE', 'ac sudah selesai diperbaiki', '2025-12-18 12:53:56'),
(4, 2, NULL, 'OPEN', 'PROCESS', 'Perubahan status otomatis oleh sistem', '2025-12-18 12:55:21'),
(5, 2, NULL, 'PROCESS', 'DONE', 'Perubahan status otomatis oleh sistem', '2025-12-18 12:55:35'),
(6, 2, 8, 'PROCESS', 'DONE', 'selesai', '2025-12-18 12:55:35'),
(7, 4, NULL, 'OPEN', 'PROCESS', 'Perubahan status otomatis oleh sistem', '2025-12-18 13:36:15'),
(8, 4, NULL, 'PROCESS', 'DONE', 'Perubahan status otomatis oleh sistem', '2025-12-18 13:36:32'),
(9, 4, 8, 'PROCESS', 'DONE', 'ac sudah diperbaiki', '2025-12-18 13:36:32'),
(10, 3, NULL, 'OPEN', 'REJECT', 'Perubahan status otomatis oleh sistem', '2025-12-18 13:37:40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('siswa','admin','teknisi') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`user_id`, `nama`, `username`, `password`, `role`) VALUES
(6, 'Rafi', 'siswa1', '$2y$10$FnLIA42XrhtBg36YtmrV2ukTfOEBGd24iP1biq9ZPIrbqAfon5pi6', 'siswa'),
(7, 'Dimas', 'admin1', '$2y$10$FnLIA42XrhtBg36YtmrV2ukTfOEBGd24iP1biq9ZPIrbqAfon5pi6', 'admin'),
(8, 'Ridwan', 'teknisi1', '$2y$10$FnLIA42XrhtBg36YtmrV2ukTfOEBGd24iP1biq9ZPIrbqAfon5pi6', 'teknisi');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `assigned_to` (`assigned_to`);

--
-- Indeks untuk tabel `tracking_progress`
--
ALTER TABLE `tracking_progress`
  ADD PRIMARY KEY (`tracking_id`),
  ADD KEY `report_id` (`report_id`),
  ADD KEY `technician_id` (`technician_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `reports`
--
ALTER TABLE `reports`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tracking_progress`
--
ALTER TABLE `tracking_progress`
  MODIFY `tracking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `reports_ibfk_2` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`user_id`);

--
-- Ketidakleluasaan untuk tabel `tracking_progress`
--
ALTER TABLE `tracking_progress`
  ADD CONSTRAINT `tracking_progress_ibfk_1` FOREIGN KEY (`report_id`) REFERENCES `reports` (`report_id`),
  ADD CONSTRAINT `tracking_progress_ibfk_2` FOREIGN KEY (`technician_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
