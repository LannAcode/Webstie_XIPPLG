-- ==========================================================================
-- DATABASE SCHEMA PRODUCTION WEBSITE XI PPLG (BERSIH MURNI TANPA DEMO)
-- Database: db_xi_pplg
-- Table: pesan_kontak
-- ==========================================================================

CREATE DATABASE IF NOT EXISTS `db_xi_pplg` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `db_xi_pplg`;

-- Tabel Pesan Kontak
CREATE TABLE IF NOT EXISTS `pesan_kontak` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nama` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `subjek` VARCHAR(150) NOT NULL,
    `pesan` TEXT NOT NULL,
    `status` ENUM('belum_dibaca', 'sudah_dibaca') DEFAULT 'belum_dibaca',
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
