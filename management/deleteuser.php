<?php 
require_once '../classes/autoload.php';
 
session_start();
if(!isset($_SESSION['useradm'])){
    header('location: https://industriaimpress.com.br');
}
if(isset($_GET['id'])){
   $id = $_GET['id']; 
}else {
    header('location: searchuser.php');
}

$users = new users();
$return = $users->deleteUser($id);
if($return === true){
    print "Usuário deletado!";
}else{
    print "Usuário inexistente!";
}