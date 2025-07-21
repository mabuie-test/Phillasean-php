<?php
use Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

define('DB_HOST',   $_ENV['DB_HOST']);
define('DB_NAME',   $_ENV['DB_NAME']);
define('DB_USER',   $_ENV['DB_USER']);
define('DB_PASS',   $_ENV['DB_PASS']);

define('SMTP_HOST', $_ENV['SMTP_HOST']);
define('SMTP_USER', $_ENV['SMTP_USER']);
define('SMTP_PASS', $_ENV['SMTP_PASS']);
define('INSTITUICAO_EMAIL', $_ENV['INST_EMAIL']);

define('PDF_DIR', __DIR__ . '/../faturas/');
define('BASE_URL', 'https://seudominio.com/');
