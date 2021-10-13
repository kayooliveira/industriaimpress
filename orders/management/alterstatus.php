<?php
session_start();
require_once '../../classes/autoload.php';
if(isset($_GET['order_id'])){
    $id = $_GET['order_id'];
}else{
    header('location: all-orders.php');
}
if(!isset($_SESSION['useradm'])){
    header('location: ../../index.php');

}
$orders = new orders();
$users = new users();
$orderdata = $orders->fetchOrderbyId($id);
$userid = $orderdata['userid'];
$userdata = $users->fetchUserById($userid);

$orderValue = floatval($orderdata['value']);
$userAtualLimit = floatval($userdata['debt']);
$newLimit = $userAtualLimit + $orderValue;
$status = $_POST['status'];
if($status === '8'){
    $users->updateLimit($newLimit,$userid);
}
if($status === '-1'){
    $cancelMessage = $_POST['cancelmessage'];
    
    $orders->updateCancelMessage($cancelMessage,$id);
    
}
$orders->updateStatus($status,$id);
header('location: all-orders.php');
?>

<!-- BODY CONTENT -->


<!-- BODY CONTENT -->

<!-- SCRIPTS CONTENT -->
<!-- SCRIPTS CONTENT -->
