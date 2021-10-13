<?php
session_start();

if(isset($_SESSION['userLogged'])){
    header('location: login.php');
  }
require_once '../../classes/autoload.php';
$username = filter_input(INPUT_POST,'username', FILTER_SANITIZE_SPECIAL_CHARS);
$password = filter_input(INPUT_POST,'password', FILTER_SANITIZE_SPECIAL_CHARS);
$password = md5($password);

$users = new users();
$loginUser = $users->userLogin($username, $password);
    header('location:../../index.php');
?>