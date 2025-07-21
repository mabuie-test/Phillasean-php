<?php
// mailer/send_mail.php
use PHPMailer\PHPMailer\PHPMailer;
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../config/settings.php';

function send_mail($to, $subject, $body) {
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host       = SMTP_HOST;
    $mail->SMTPAuth   = true;
    $mail->Username   = SMTP_USER;
    $mail->Password   = SMTP_PASS;
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom(SMTP_USER, 'PHIL Logistics');
    $mail->addAddress($to);
    $mail->Subject = $subject;
    $mail->Body    = $body;

    return $mail->send();
}
