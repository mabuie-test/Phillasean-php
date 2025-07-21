<?php
// public/cliente.php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/settings.php';

// Buscar histórico de solicitações + faturas
$stmt = $pdo->prepare(
  "SELECT s.id AS solicitacao_id, s.detalhes, s.status, s.created_at,
          f.id AS fatura_id, f.filepath
     FROM solicitacoes s
LEFT JOIN faturas f ON f.solicitacao_id = s.id
    WHERE s.user_id = ?
 ORDER BY s.created_at DESC"
);
$stmt->execute([$_SESSION['user_id']]);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <title>Área do Cliente</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <?php include 'index.php'; // só o header/nav ?>
  <main>
    <h1>Bem‑vindo, Cliente #<?= $_SESSION['user_id'] ?></h1>

    <?php if (empty($rows)): ?>
      <p>Ainda não submeteu nenhuma solicitação.</p>
    <?php else: ?>
      <table>
        <thead>
          <tr>
            <th>ID Solicitação</th>
            <th>Detalhes</th>
            <th>Status</th>
            <th>Data</th>
            <th>Fatura</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($rows as $r): ?>
          <tr>
            <td><?= $r['solicitacao_id'] ?></td>
            <td><?= htmlspecialchars($r['detalhes']) ?></td>
            <td><?= $r['status'] ?></td>
            <td><?= $r['created_at'] ?></td>
            <td>
              <?php if ($r['fatura_id']): ?>
                <a href="../user/download_fatura.php?id=<?= $r['solicitacao_id'] ?>">
                  Download PDF
                </a>
              <?php else: ?>
                —
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>

  </main>
  <script src="script.js"></script>
</body>
</html>
