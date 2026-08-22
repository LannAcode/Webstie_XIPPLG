<?php
ob_start();

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

require_once __DIR__ . '/../config/db.php';

$pdo = $pdo ?? null;

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
  header("Location: login.php");
  exit;
}

if (!$pdo) {
  header("Location: index.php");
  exit;
}

$action = $_GET['action'] ?? '';
$id     = intval($_GET['id'] ?? 0);

if ($id > 0) {
  if ($action === 'toggle_status') {
    // Ambil status saat ini
    $stmt = $pdo->prepare("SELECT status FROM pesan_kontak WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $currentStatus = $stmt->fetchColumn();

    $newStatus = ($currentStatus === 'belum_dibaca') ? 'sudah_dibaca' : 'belum_dibaca';
    $updateStmt = $pdo->prepare("UPDATE pesan_kontak SET status = :status WHERE id = :id");
    $updateStmt->execute([':status' => $newStatus, ':id' => $id]);
  } elseif ($action === 'mark_read') {
    $updateStmt = $pdo->prepare("UPDATE pesan_kontak SET status = 'sudah_dibaca' WHERE id = :id");
    $updateStmt->execute([':id' => $id]);
    echo json_encode(['status' => 'success']);
    exit;
  } elseif ($action === 'delete') {
    $deleteStmt = $pdo->prepare("DELETE FROM pesan_kontak WHERE id = :id");
    $deleteStmt->execute([':id' => $id]);
  }
}

header("Location: index.php");
exit;
