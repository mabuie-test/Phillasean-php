<?php
// user/download_fatura.php
session_start();
if (!isset($_SESSION['user_id'])) {
    die('Acesso negado');
}
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/settings.php';

$id = intval($_GET['id'] ?? 0);
// Verifica se a fatura pertence ao utilizador
$stmt = $pdo->prepare(
  "SELECT f.filepath FROM faturas f 
     JOIN solicitacoes s ON f.solicitacao_id=s.id
   WHERE f.solicitacao_id=? AND s.user_id=?"
);
$stmt->execute([$id, $_SESSION['user_id']]);
$file = $stmt->fetchColumn();

if ($file && file_exists(PDF_DIR.$file)) {
    header('Content-Type: application/pdf');
    header("Content-Disposition: attachment; filename=\"{$file}\"");
    readfile(PDF_DIR.$file);
    exit;
}
die('Fatura não encontrada.');
