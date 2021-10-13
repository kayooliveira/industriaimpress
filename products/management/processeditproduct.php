<?php 
session_start();
require_once '../../classes/autoload.php';
if(!isset($_SESSION['useradm'])){
    header('Location: ../../secure/login/login.php');
  };
  
  function sanitizeString($str) {
    $str = preg_replace('/[áàãâä]/ui', 'a', $str);
    $str = preg_replace('/[éèêë]/ui', 'e', $str);
    $str = preg_replace('/[íìîï]/ui', 'i', $str);
    $str = preg_replace('/[óòõôö]/ui', 'o', $str);
    $str = preg_replace('/[úùûü]/ui', 'u', $str);
    $str = preg_replace('/[ç]/ui', 'c', $str);
    // $str = preg_replace('/[,(),;:|!"#$%&/=?~^><ªº-]/', '_', $str);
    $str = preg_replace('/[^a-z0-9]/i', '_', $str);
    $str = preg_replace('/_+/', '_', $str); // ideia do Bacco :)
    return $str;
}

$products = new products();
$ftperm = ['jpg'];
$id = $_SESSION['userLoggedId'];
$userLoggedName = $_SESSION['userLoggedName'];
$name = $_POST['name'];
$description = $_POST['description'];
$vm = $_POST['vm'];
$vp = $_POST['vp'];
$category = $_POST['category'];
$status = $_POST['status'];
$fv = $_POST['fv'];
$timep = $_POST['timep'];
$file = $_FILES['file'];
$filedirectory = $file['tmp_name'];
$filename = $_FILES['file']['name'];
$serverfilename = '_'.$filename;
$pathDir = "../products-img/".sanitizeString($name);
$pathSave = "../products-img/".sanitizeString($name).'/'."_".$filename;
    $extensao = explode('.',$filename);
    $extensao = end($extensao);
    if(in_array($extensao, $ftperm)){
        $vproduct = $products->insertProducts($name,$serverfilename,$description,$vm,$vp,$fv,$timep,$category,$status);
        if(!is_dir($pathDir)){
            mkdir($pathDir,0777,true);
        }
        move_uploaded_file($filedirectory,$pathSave);
    }else{
            $_SESSION['wrongextension'] ;
          // header('location: compra.php?product_id='.$product_id);
    }
        






?>