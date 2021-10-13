<?php 
session_start();

if(!isset($_SESSION['userLogged'])){
    header('location: ../index.php');
  }
require_once '../classes/autoload.php';
  
  function sanitizeString($str) {
    $str = preg_replace('/[áàãâä]/ui', 'a', $str);
    $str = preg_replace('/[éèêë]/ui', 'e', $str);
    $str = preg_replace('/[íìîï]/ui', 'i', $str);
    $str = preg_replace('/[óòõôö]/ui', 'o', $str);
    $str = preg_replace('/[úùûü]/ui', 'u', $str);
    $str = preg_replace('/[ç]/ui', 'c', $str);
    $str = preg_replace('/[](),;:|!#$%&/=?~^><ªº-/', '_', $str);
    $str = preg_replace('/[^a-z0-9]/i', '_', $str);
    $str = preg_replace('/_+/', '_', $str); // ideia do Bacco :)
    return $str;
}

$productid = $_GET['product_id'];
$orders = new orders();
$users = new users();
$ftperm = ['jpg','png','plt','jpeg','cdr','pdf'];
$userid = $_SESSION['userLoggedId'];
$userdata = $users->fetchUserById($userid);
$userdebt = number_format($userdata['debt']);
$userdebtlimit = number_format($userdata['debtlimit']);
if($userdebt>=$userdebtlimit){
  $_SESSION['nolimit']= 'Você não possui limite de crédito suficiente para efetuar esta compra, por gentileza, efetue os pagamentos que estão pendentes, clique <a href="../orders/user/my-orders.php">aqui</a> para verificar seus pedidos anteriores.';
  header('location: ../buy.php?product_id='.$productid);
  return;
}
if($userLimit >= 600)
$username = $_SESSION['userLoggedName'];
$description = $_POST['description'];
$scalex = $_POST['scalex'];
$qnt = $_POST['qnt'];
$pdescription = "Não informado";
if(isset($_POST['pdescription'])){
$pdescription = $_POST['pdescription'];
}
$scaley = $_POST['scaley'];
$scalexy = $_POST['scalexy'];
$value = $_POST['value'];
$havelimit = number_format($value) + (number_format($userdata['debt']));
$file = $_FILES['file'];
if(isset($_FILES['file2'])){
$file2 = $_FILES['file2'];
$filename2 = $_FILES['file2']['name'];
$filedirectory2 = $file2['tmp_name'];
$serverfilename2 = $username.'/'.sanitizeString($description).'/'.'_'.$filename2;
$pathSave2 = "../orders/orders-files/".$username.'/'.sanitizeString($description).'/'."_".$filename2;
$fv = '1';
}else{
$filedirectory2 = '';
$serverfilename2 = '';
$pathSave2 = '';
$file2 = '';
$fv = '0';
}
$filedirectory = $file['tmp_name'];
$filename = $_FILES['file']['name'];
$serverfilename = $username.'/'.sanitizeString($description).'/'.'_'.$filename;
$serverfilenameFV = $serverfilename.';'.$serverfilename2;
$pathDir = "../orders/orders-files/".$username.'/'.sanitizeString($description);
$pathSave = "../orders/orders-files/".$username.'/'.sanitizeString($description).'/'."_".$filename;
    $extensao = explode('.',$filename);
    $extensao2 = explode('.',$filename2);
    $extensao = end($extensao);
    if(in_array($extensao, $ftperm) | in_array($extensao2,$ftperm)){
        try{
        $vorders = $orders->addNewOrder($userid,$serverfilenameFV,$description,$value,$scalex,$scaley,$scalexy,$productid,$fv,$username,$qnt, $pdescription);
        }catch(Exception $e){
        $_SESSION['cadordererror'] = '' ;
        }
        if(!is_dir($pathDir)){
            mkdir($pathDir,0777,true);
        }
        move_uploaded_file($filedirectory,$pathSave);
        move_uploaded_file($filedirectory2,$pathSave2);
        header('location: ../buy.php?product_id='.$productid);
        $_SESSION['cadordersuccess'] = '' ;

    }else{
            $_SESSION['wrongextension']  = '';
          // header('location: compra.php?product_id='.$product_id);
    }
        






?>