<?php
require_once '../classes/autoload.php';
if(isset($_GET['id'])){
    $id = $_GET['id'];
}else{
    header('location: searchuser.php');
}
if(isset($_GET['status'])){
    $status = $_GET['status'];
    if($status === '0'){
        $status = 1;
    }else if($status === '1') {
        $status = 0;
    }
}else{
    header('location: searchuser.php');
}



$users = new users();
$values = $users->updateStatus('impress_users',$status,$id);
header('location:searchuser.php')
?>

<!-- BODY CONTENT -->


<!-- BODY CONTENT -->

<!-- SCRIPTS CONTENT -->
<!-- SCRIPTS CONTENT -->
