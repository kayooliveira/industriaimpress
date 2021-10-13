<?php
session_start();




if(isset($_SESSION['moderator'])){
    $_SESSION['nopermissions'] = 'Seu usuário não tem permissão para executar esta ação, se acha que não deveria estar vendo esta mensagem, por favor contate um administrador geral.';
    header('location: all-orders.php');
    return;
}



if(!isset($_SESSION['useradm'])){

    header('location: ../../index.php');
    return;

}
require_once '../../classes/autoload.php';
if(isset($_GET['order_id'])){
    $id = $_GET['order_id'];
}else{
    header('location: all-orders.php');
    return;
}

$orders = new orders();
$users = new users();
$orderdata = $orders->fetchOrderbyId($id);
$userid = $orderdata['userid'];

$userdata = $users->fetchUserById($userid);
$orderValue = $orderdata['value'];
$atualLimit = $userdata['debt'];
$newLimit = (floatval($atualLimit)) - (floatval($orderValue));
$users->updateLimit($newLimit,$userid);
$orders->updatePaymentStatus($id);

header('location: all-orders.php');
?>

<!-- BODY CONTENT -->


<!-- BODY CONTENT -->

<!-- SCRIPTS CONTENT -->
<!-- SCRIPTS CONTENT -->
