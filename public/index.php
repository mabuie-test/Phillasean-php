<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt">
<head>…</head>
<body>
  <nav>
    <a href="index.php">Home</a>
    <a href="reserva.php">Reservas</a>
    <?php if(!isset($_SESSION['user_id'])): ?>
      <div class="dropdown">
        Conta ▼
        <div class="menu">
          <a href="login.php">Login</a>
          <a href="register.php">Registar</a>
        </div>
      </div>
    <?php else: ?>
      <a href="cliente.php">Área Cliente</a>
      <a href="logout.php">Sair</a>
    <?php endif; ?>
  </nav>
  <!-- resto do seu index.html -->
</body>
</html>
