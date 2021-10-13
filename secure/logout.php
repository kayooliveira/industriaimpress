<?php
session_start();

session_destroy();

header("Location: login/login.php", true, 301);
?>