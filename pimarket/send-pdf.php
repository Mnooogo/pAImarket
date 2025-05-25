<?php
$storageFolder = __DIR__ . '/pdf-orders/';
if (!is_dir($storageFolder)) {
    mkdir($storageFolder, 0755, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['pdf']) && isset($_POST['email'])) {
    $to = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    if (!$to) {
        echo json_encode(["sent" => false, "error" => "Invalid email"]);
        exit;
    }

    $filename = $_FILES['pdf']['name'];
    $tempPath = $_FILES['pdf']['tmp_name'];
    $archivedPath = $storageFolder . basename($filename);
    move_uploaded_file($tempPath, $archivedPath); // 🗂️ Архивиране

    // Имейл изпращане (остава както беше)...
    
}

    $filename = $_FILES['pdf']['name'];
    $tempPath = $_FILES['pdf']['tmp_name'];

    $subject = "📦 Your PiMarket Order PDF";
    $body = "Dear customer,\n\nAttached is your PDF report with filtered orders from PiMarket.\n\nBest regards,\nPiMarket Team";
    $boundary = md5(time());

    $headers = "From: PiMarket <noreply@playforall.online>\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n\r\n";

    $message = "--$boundary\r\n";
    $message .= "Content-Type: text/plain; charset=utf-8\r\n\r\n";
    $message .= "$body\r\n\r\n";

    $pdfData = chunk_split(base64_encode(file_get_contents($tempPath)));
    $message .= "--$boundary\r\n";
    $message .= "Content-Type: application/pdf; name=\"$filename\"\r\n";
    $message .= "Content-Transfer-Encoding: base64\r\n";
    $message .= "Content-Disposition: attachment; filename=\"$filename\"\r\n\r\n";
    $message .= "$pdfData\r\n";
    $message .= "--$boundary--";

    $success = mail($to, $subject, $message, $headers);

    echo json_encode(["sent" => $success]);
    exit;


echo json_encode(["sent" => false, "error" => "Invalid request"]);
