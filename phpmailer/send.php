<?php
require("/home1/indus171/public_html/phpmailer/PHPMailer/src/PHPMailer.php");
require("/home1/indus171/public_html/phpmailer/PHPMailer/src/SMTP.php");
 $mail = new PHPMailer\PHPMailer\PHPMailer();
 $mail->IsSMTP(); // enable SMTP
 $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
 $mail->SMTPAuth = true; // authentication enabled
 $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
 $mail->Host = "servidor.hostgator.com.br";
 $mail->Port = 465; // or 587
 $mail->IsHTML(true);
 $mail->Username = "contato@industriaimpress.com.br";
 $mail->Password = "Jxci1305.";
 $mail->SetFrom("contato@industriaimpress.com.br");
 $mail->Subject = "ALTERAÇÃO DE SENHA";
 $mail->Body = "Sua senha foi alterada por um administrador em https://industriaimpress.com.br";
 $mail->AddAddress($_GET['mail']);
    if(!$mail->Send()) {
       echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
       echo "Mensagem enviada com sucesso";
    }
?>