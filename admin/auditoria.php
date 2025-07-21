<?php
session_start();
if (empty($_SESSION['is_admin'])) header('Location: dashboard.php');
require_once __DIR__ . '/../config/db.php';

$stmt = $pdo->query(
  "SELECT * FROM auditoria ORDER BY created_at DESC LIMIT 100"
);
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html><html lang="pt"><body>
  <h2>Auditoria</h2>
  <table>
    <tr><th>Data</th><th>Entidade</th><th>Ação</th><th>Quem</th><th>Detalhe</th></tr>
    <?php foreach($logs as $l): ?>
      <tr>
        <td><?= $l['created_at'] ?></td>
        <td><?= $l['entidade'] ?></td>
        <td><?= $l['acao'] ?></td>
        <td><?= $l['user_performed'] ?></td>
        <td><?= htmlspecialchars($l['detalhe']) ?></td>
      </tr>
    <?php endforeach; ?>
  </table>
</body></html>

