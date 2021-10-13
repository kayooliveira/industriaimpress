<?php
require_once '../../classes/autoload.php';

if(!isset($_SESSION['userLogged'])){
    header('location: ../../index.php');

}
if(isset($_GET['order_id'])){
    $id = $_GET['order_id'];
}else{
    header('location: my-orders.php');
}



$orders = new orders();
$values = $orders->cancelOrder($id);
$cancelMessage = 'Cancelado pelo Cliente!';
$orders->updateCancelMessage($cancelMessage,$id);
header('location: my-orders.php');
?>

<!-- BODY CONTENT -->


<!-- BODY CONTENT -->

<!-- SCRIPTS CONTENT -->
<!-- SCRIPTS CONTENT -->
