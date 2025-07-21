<?php
// auth/register.php
session_start();
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome  = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $hash  = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Verificar email único
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetchColumn() > 0) {
        $error = "Email já registado.";
    } else {
        $stmt = $pdo->prepare(
          "INSERT INTO users (nome, email, senha_hash) VALUES (?, ?, ?)"
        );
        $stmt->execute([$nome, $email, $hash]);
        header('Location: ../public/login.php?registered=1');
        exit;
    }
}
?>
<!-- Aqui copie o seu HTML de register.html, mudando action para este ficheiro -->
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registro | PHIL ASEAN PROVIDER & LOGISTICS</title>
  <link rel="icon" href="assets/phil.jpeg" type="image/jpeg">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="styles.css">
</head>
<body>

  <header>
    <div class="container header-container">
      <div class="logo">
        <img src="assets/phil.jpeg" alt="Logo PHIL ASEAN" id="logo-img">
        <span>PHIL ASEAN PROVIDER & LOGISTICS</span>
      </div>
      <nav>
        <button class="mobile-menu-btn" id="mobile-menu-btn">
          <i class="fas fa-bars"></i>
        </button>
        <ul id="main-menu">
          <li><a href="index.html"><i class="fas fa-home"></i> Início</a></li>
          <li><a href="index.html#services"><i class="fas fa-ship"></i> Serviços</a></li>
          <li><a href="index.html#about"><i class="fas fa-info-circle"></i> Sobre</a></li>
          <li><a href="login.html"><i class="fas fa-sign-in-alt"></i> Login</a></li>
          <li><a href="register.html"><i class="fas fa-user-plus"></i> Registro</a></li>
          <li><a href="index.html#contact"><i class="fas fa-envelope"></i> Contato</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <main>
    <div class="section-title">
      <h2>Registro</h2>
    </div>
    <form id="registerForm">
      <div class="form-group">
        <label for="name">Nome Completo</label>
        <input id="name" name="name" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input id="email" name="email" type="email" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="password">Senha</label>
        <input id="password" name="password" type="password" class="form-control" required>
      </div>
      <button type="submit" class="btn submit-btn">Registrar</button>
      <div class="link-group">
        <p>Já tem conta? <a href="login.html">Faça login</a></p>
      </div>
    </form>
  </main>

  <footer>
    <p>© 2025 PHIL ASEAN PROVIDER & LOGISTICS. Todos os direitos reservados.</p>
  </footer>

  <script>
    document.getElementById('mobile-menu-btn').addEventListener('click', () => {
      document.getElementById('main-menu').classList.toggle('show');
    });
  </script>
  <script src="script.js" defer></script>
<!-- Modal genérico para alert/confirm -->
<div id="dialog-overlay" class="hidden">
  <div id="dialog-box">
    <div id="dialog-message"></div>
    <div id="dialog-buttons">
      <button id="dialog-ok">OK</button>
      <button id="dialog-cancel" class="hidden">Cancelar</button>
    </div>
  </div>
</div>


</body>
</html>
