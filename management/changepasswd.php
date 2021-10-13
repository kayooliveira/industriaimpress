<?php
session_start();
if(isset($_SESSION['useradm'])){
    header("location:index.php");
}
require_once '../classes/autoload.php';
$users = new users();
$values = $users->fetchUserById($id);
$content = file_get_contents("changepass.html");
require("/home1/indus171/public_html/phpmailer/PHPMailer/src/PHPMailer.php");
require("/home1/indus171/public_html/phpmailer/PHPMailer/src/SMTP.php");
 $mail = new PHPMailer\PHPMailer\PHPMailer();
 // enable SMTP
 
$mail -> charSet = "UTF-8";
 $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
 $mail->SMTPAuth = true; // authentication enabled
 $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
 $mail->Host = "mail.industriaimpress.com.br";
 $mail->Port = 465; // or 587
 $mail->IsHTML(true);
 $mail->Username = "contato@industriaimpress.com.br";
 $mail->Password = "Jxci1305.";
 $mail->SetFrom("contato@industriaimpress.com.br");
 $mail->Subject = "ALTERAÇÃO DE SENHA";
 $mail->Body = $content;
 $mail->AddAddress($values['email']);
    if(!$mail->Send()) {
       echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
       echo "Mensagem enviada com sucesso";
    }
$users->changePasswd($id,$newpass);
header('location: userinfo.php')
?>