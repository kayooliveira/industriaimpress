<?php 
session_start();
require_once '../../classes/autoload.php';
if(!isset($_SESSION['useradm'])){
    header('Location: ../../secure/login/login.php');
  };


$products = new products();
$id = $_POST['id'];
$product = $products->filterProductById($id);
if($product['status'] === '0'){
    $status = '1';
}elseif($product['status' === '1']){
    $status = '0';
}
$fetchReturn = $products->alterStatusProduct($status,$id);
if($fetchReturn>0){
    return 'Erro ao atualizar status do produto';
}else{
    return 'Status do produto atualizado';
}



?>