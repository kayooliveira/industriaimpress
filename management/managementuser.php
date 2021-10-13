<?php 

 
session_start();
if(!isset($_SESSION['useradm'])){
    header('location: https://industriaimpress.com.br');
}

echo "em breve";