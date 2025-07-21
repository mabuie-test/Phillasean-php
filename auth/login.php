<?php
// auth/login.php
session_start();
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $pass  = $_POST['password'];

    $stmt = $pdo->prepare(
      "SELECT id, senha_hash, is_admin FROM users WHERE email = ?"
    );
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($pass, $user['senha_hash'])) {
        $_SESSION['user_id']  = $user['id'];
        $_SESSION['is_admin'] = (bool)$user['is_admin'];
        $destino = $user['is_admin']
                 ? '../admin/dashboard.php'
                 : '../public/cliente.php';
        header("Location: $destino");
        exit;
    } else {
        $error = "Credenciais inválidas.";
    }
}
?>
<!-- Aqui copie o HTML de login.html, apontando o form para este ficheiro -->
