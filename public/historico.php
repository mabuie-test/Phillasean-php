<?php
// user/historico.php
session_start();
header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Não autenticado']);
    exit;
}

require_once __DIR__ . '/../config/db.php';

$stmt = $pdo->prepare(
  "SELECT s.id AS solicitacao_id, s.detalhes, s.status, s.created_at,
          f.id AS fatura_id, f.filepath
     FROM solicitacoes s
LEFT JOIN faturas f ON f.solicitacao_id = s.id
    WHERE s.user_id = ?
 ORDER BY s.created_at DESC"
);
$stmt->execute([$_SESSION['user_id']]);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($data);
