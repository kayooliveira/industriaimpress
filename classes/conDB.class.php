<?php 

 abstract class conDB {
    private $hostDB = "mysql:host=localhost;dbname=impress";
    private $userDB = "root";
    private $passDB = "";

    protected function condb(){
        try {
            $conDB = new PDO($this->hostDB,$this->userDB,$this->passDB);
            $conDB->exec("set names utf8");
            return $conDB;
        }catch (PDOException $erro){
            echo $erro->getMessage();
        }
    }
}


?>