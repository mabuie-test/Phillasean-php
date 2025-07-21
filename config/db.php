<?php
// config/db.php
define('DB_HOST',     'localhost');
define('DB_NAME',     'phil_logistics');
define('DB_USER',     'seu_usuario');
define('DB_PASS',     'sua_senha');

try {
    $pdo = new PDO(
        "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4",
        DB_USER, DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die("Erro na BD: " . $e->getMessage());
}
