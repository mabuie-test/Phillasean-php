<?php
session_start();
if (empty($_SESSION['is_admin'])) header('Location: dashboard.php');
require_once __DIR__ . '/../config/db.php';

$where = [];
$params = [];

// Filtros simples via GET
if (!empty($_GET['status'])) {
  $where[]   = 's.status = ?';
  $params[]  = $_GET['status'];
}
if (!empty($_GET['cliente'])) {
  $where[]  = 'u.nome LIKE ?';
  $params[] = '%'.$_GET['cliente'].'%';
}

$sql = "SELECT f.id,f.filepath,s.status,u.nome,s.created_at
        FROM faturas f
        JOIN solicitacoes s ON f.solicitacao_id=s.id
        JOIN users u ON s.user_id=u.id";
if ($where) {
  $sql .= ' WHERE '.implode(' AND ', $where);
}
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$faturas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt">
<head>…</head>
<body>
  <h2>Faturas</h2>
  <form method="GET">
    Cliente: <input name="cliente" value="<?= htmlspecialchars($_GET['cliente'] ?? '') ?>">
    Status:
    <select name="status">
      <option value="">Todos</option>
      <option value="pendente">Pendente</option>
      <option value="concluída">Concluída</option>
    </select>
    <button>Filtrar</button>
  </form>
  <table>
    <tr><th>ID</th><th>Cliente</th><th>Status</th><th>Data</th><th>PDF</th></tr>
    <?php foreach($faturas as $f): ?>
      <tr>
        <td><?= $f['id'] ?></td>
        <td><?= htmlspecialchars($f['nome']) ?></td>
        <td><?= $f['status'] ?></td>
        <td><?= $f['created_at'] ?></td>
        <td>
          <a href="download_fatura.php?id=<?= $f['id'] ?>">Download</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
</body>
</html>
