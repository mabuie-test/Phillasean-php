<?php
session_start();
if (empty($_SESSION['is_admin'])) header('Location: dashboard.php');
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD']==='POST') {
    $email = trim($_POST['email']);
    $hash  = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt = $pdo->prepare(
      "INSERT INTO users (nome,email,senha_hash,is_admin) VALUES (?,?,?,1)"
    );
    $stmt->execute([$_POST['nome'],$email,$hash]);
    header('Location: dashboard.php?new_admin=1');
    exit;
}
?>
<!DOCTYPE html><html lang="pt"><body>
  <h2>Criar Admin</h2>
  <form method="POST">
    <input name="nome" required placeholder="Nome">
    <input type="email" name="email" required placeholder="Email">
    <input type="password" name="password" required placeholder="Senha">
    <button>Criar</button>
  </form>
</body></html>
