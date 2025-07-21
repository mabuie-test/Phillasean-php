<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>…</head>
<body>
  <?php include 'index.php'; // apenas o nav ?>
  <!-- Formulário de reserva: action="../user/submit_solicitacao.php" method="POST" -->
</body>
</html>
