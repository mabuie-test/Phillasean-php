<?php
session_start();
if (empty($_SESSION['is_admin'])) {
    header('Location: ../public/index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>…</head>
<body>
  <h1>Dashboard Admin</h1>
  <a href="criar_admin.php">Criar Novo Admin</a> |
  <a href="filtrar_faturas.php">Ver / Filtrar Faturas</a> |
  <a href="auditoria.php">Auditoria</a>

  <!-- Talvez incluir aqui um resumo rápido (total de faturas, pendentes, etc) -->
</body>
</html>
