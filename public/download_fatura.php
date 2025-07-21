<?php
// admin/download_fatura.php
session_start();
if (empty($_SESSION['is_admin'])) {
    header('Location: dashboard.php');
    exit;
}

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/settings.php';

$id = intval($_GET['id'] ?? 0);

// Pegar o nome do ficheiro
$stmt = $pdo->prepare(
  "SELECT filepath FROM faturas WHERE id = ?"
);
$stmt->execute([$id]);
$file = $stmt->fetchColumn();

$full = PDF_DIR . $file;
if ($file && file_exists($full)) {
    header('Content-Type: application/pdf');
    header("Content-Disposition: attachment; filename=\"{$file}\"");
    readfile($full);
    exit;
}

http_response_code(404);
echo "Fatura não encontrada.";
