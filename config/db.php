<?php
/* ==========================================================================
   DATABASE CONNECTION CONFIGURATION (PDO MySQL XAMPP & SQLite Fallback)
   Production Ready (Clean & Synchronized)
   ========================================================================== */

require_once __DIR__ . '/env.php';

$host     = getenv('DB_HOST') ?: '127.0.0.1';
$dbname   = getenv('DB_NAME') ?: 'db_xi_pplg';
$username = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASS') ?: '';

$pdo = null;
$db_driver = 'mysql';

try {
  // 1. Koneksi Utama ke MySQL Server XAMPP / phpMyAdmin (127.0.0.1)
  $dsn = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";
  $pdo = new PDO($dsn, $username, $password, [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
  ]);
  $db_driver = 'mysql';
} catch (PDOException $e) {
  // 2. Jika MySQL XAMPP belum aktif, gunakan SQLite Fallback
  try {
    $dbDir = __DIR__ . '/../database';
    if (!is_dir($dbDir)) {
      mkdir($dbDir, 0755, true);
    }
    $sqliteFile = $dbDir . '/db_xi_pplg.sqlite';
    $pdo = new PDO("sqlite:" . $sqliteFile, null, null, [
      PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    $db_driver = 'sqlite';

    // Buat tabel otomatis di SQLite jika belum ada
    $pdo->exec("
      CREATE TABLE IF NOT EXISTS pesan_kontak (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nama TEXT NOT NULL,
        email TEXT NOT NULL,
        subjek TEXT NOT NULL,
        pesan TEXT NOT NULL,
        status TEXT DEFAULT 'belum_dibaca',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
      )
    ");
  } catch (PDOException $ex) {
    die("Koneksi Database Gagal: " . $ex->getMessage());
  }
}
