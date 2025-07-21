<?php
// user/submit_solicitacao.php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../public/login.php');
    exit;
}

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/settings.php';
require_once __DIR__ . '/../mailer/send_mail.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uid      = $_SESSION['user_id'];
    $detalhes = trim($_POST['detalhes']);

    // 1) Inserir solicitação
    $stmt = $pdo->prepare(
      "INSERT INTO solicitacoes (user_id, detalhes) VALUES (?, ?)"
    );
    $stmt->execute([$uid, $detalhes]);
    $sol_id = $pdo->lastInsertId();

    // 2) Gerar fatura (exemplo com FPDF)
    require_once __DIR__ . '/../../vendor/fpdf/fpdf.php';
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(0,10,"Fatura #$sol_id",0,1);
    $pdf->Cell(0,10,"Detalhes: $detalhes",0,1);
    $path = PDF_DIR . "fatura_{$sol_id}.pdf";
    $pdf->Output('F', $path);

    // 3) Guardar referência em BD
    $stmt = $pdo->prepare(
      "INSERT INTO faturas (solicitacao_id, filepath) VALUES (?, ?)"
    );
    $stmt->execute([$sol_id, basename($path)]);

    // 4) Enviar email à instituição
    $subject = "Nova Solicitação #$sol_id";
    $body    = "Foi criada a solicitação #$sol_id com detalhes:\n\n$detalhes\n\nLink: "
             . BASE_URL . "user/download_fatura.php?id=$sol_id";
    send_mail(INSTITUICAO_EMAIL, $subject, $body);

    header("Location: ../public/cliente.php?ok=1");
    exit;
}
