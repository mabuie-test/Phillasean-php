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
