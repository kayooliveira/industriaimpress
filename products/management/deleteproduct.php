<?php 
session_start();
require_once '../../classes/autoload.php';
if(!isset($_SESSION['useradm'])){
    header('Location: ../../secure/login/login.php');
  };


$products = new products();
$id = $_POST['id'];


$return = $products->deleteProduct($id);
if($return>0){
    return 'Erro ao deletar o produto';
}else{
    return 'Produto deletado';
}



?>