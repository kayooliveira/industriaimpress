<?php
session_start();
require_once '../../classes/autoload.php';
$fname = filter_input(INPUT_POST,'fname', FILTER_SANITIZE_SPECIAL_CHARS);
$lname = filter_input(INPUT_POST,'lname', FILTER_SANITIZE_SPECIAL_CHARS);
$username = filter_input(INPUT_POST,'username', FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST,'email', FILTER_VALIDATE_EMAIL);
$contact = filter_input(INPUT_POST,'contact', FILTER_SANITIZE_NUMBER_INT);
$document = filter_input(INPUT_POST,'document', FILTER_SANITIZE_NUMBER_INT);
$address = filter_input(INPUT_POST,'address', FILTER_SANITIZE_SPECIAL_CHARS);
$password = filter_input(INPUT_POST,'password', FILTER_SANITIZE_SPECIAL_CHARS);
$password = md5($password);
$birthdate= filter_input(INPUT_POST,'birthdate', FILTER_SANITIZE_SPECIAL_CHARS);
$doctype = filter_input(INPUT_POST,'doctype', FILTER_SANITIZE_SPECIAL_CHARS);
if(isset($_POST['company'])){
    $company = filter_input(INPUT_POST,'company', FILTER_SANITIZE_SPECIAL_CHARS);
}
else{ $company = "Não_Informado";}
if(isset($_POST['ie'])){
    $ie = filter_input(INPUT_POST,'ie', FILTER_SANITIZE_SPECIAL_CHARS);
}
else{ $ie = 'isento';}


$users = new users();
$cadNewUser = $users->cadNewUser($fname,$lname,$username,$email,$contact,$document,$address,$password,$birthdate,$ie,$doctype,$company);
// header('location: register.php');
header("Location: register.php", true, 301);
?>