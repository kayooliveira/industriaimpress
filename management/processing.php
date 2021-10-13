<?php

 
session_start();
if(!isset($_SESSION['useradm'])){
    header('location: ../../index.php');

}