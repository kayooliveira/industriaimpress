<?php 
class orders extends conDB{
  public function fetchOrders($a){
      $conDB = $this->condb();
      $sql = "select * from impress_orders $a";
      $query = $conDB->prepare($sql);
      try {
        $query->execute();
      }
      catch(Exception $e){
        $_SESSION['errorDB'] = "<p class='red-text'>"."Ocorreu um erro no banco de dados, por favor confira as informações enviadas e tente novamente... ERRO: $e"."<p>";
        return; 
      }
      $return = $query->fetchAll();
      return $return;
  } 
  public function fetchAllOrders(){
      $conDB = $this->condb();
      $sql = "select * from impress_orders";
      $query = $conDB->prepare($sql);
      try {
        $query->execute();
      }
      catch(Exception $e){
        $_SESSION['errorDB'] = "<p class='red-text'>"."Ocorreu um erro no banco de dados, por favor confira as informações enviadas e tente novamente... ERRO: $e"."<p>";
        return; 
      }
      $return = $query->rowCount();
      return $return;
  } 
  public function fetchOrderbyId($a){
      $conDB = $this->condb();
      $sql = "select * from impress_orders where id=$a";
      $query = $conDB->prepare($sql);
      try {
        $query->execute();
      }
      catch(Exception $e){
        $_SESSION['errorDB'] = "<p class='red-text'>"."Ocorreu um erro no banco de dados, por favor confira as informações enviadas e tente novamente... ERRO: $e"."<p>";
        return; 
      }
      $return = $query->fetch();
      return $return;
  } 
  public function cancelOrder($a){
      $conDB = $this->condb();
      $sql = "update impress_orders set status='-1' where id=$a";
      $query = $conDB->prepare($sql);
      try {
        $query->execute();
      }
      catch(Exception $e){
        $_SESSION['errorDB'] = "<p class='red-text'>"."Ocorreu um erro no banco de dados, por favor confira as informações enviadas e tente novamente... ERRO: $e"."<p>";
        return; 
      }
      $return = $query->rowCount();
      return $return;
  } 

  public function updatePaymentStatus($a){
    $conDB = $this->condb();
    $sql = "update impress_orders set pg='1' where id=$a";
    $query = $conDB->prepare($sql);
    try {
      $query->execute();
    }
    catch(Exception $e){
      $_SESSION['errorDB'] = "<p class='red-text'>"."Ocorreu um erro no banco de dados, por favor confira as informações enviadas e tente novamente... ERRO: $e"."<p>";
      return; 
    }
    $return = $query->rowCount();
    return $return;
} 
public function updateStatus($a,$b){
  $conDB = $this->condb();
  $sql = "update impress_orders set status=$a where id=$b";
  $query = $conDB->prepare($sql);
  try {
    $query->execute();
  }
  catch(Exception $e){
    $_SESSION['errorDB'] = "<p class='red-text'>"."Ocorreu um erro no banco de dados, por favor confira as informações enviadas e tente novamente... ERRO: $e"."<p>";
    return; 
  }
  $return = $query->rowCount();
  return $return;
}  
public function updateCancelMessage($a,$b){
  $conDB = $this->condb();
  $sql = "update impress_orders set cancelmsg='$a' where id='$b'";
  $query = $conDB->prepare($sql);
  try {
    $query->execute();
  }
  catch(Exception $e){
    $_SESSION['errorDB'] = "<p class='red-text'>"."Ocorreu um erro no banco de dados, por favor confira as informações enviadas e tente novamente... ERRO: $e"."<p>";
    return; 
  }
  $return = $query->rowCount();
  return $return;
} 

    public function addNewOrder($userid,$file,$description,$value,$scalex,$scaley,$scalexy,$productid,$fv,$username,$qnt,$pdescription){
      $conDB = $this->condb();
        $sql = "insert into impress_orders (userid,file,description,value,scalex,scaley,scalexy,productid,fv,username,qnt,pdescription) values ('$userid','$file','$description','$value','$scalex','$scaley','$scalexy','$productid','$fv','$username','$qnt','$pdescription')";
        $query = $conDB->prepare($sql);
        try {
          $query->execute();
        }
        catch(Exception $e){
          $_SESSION['errorDB'] = "<p class='red-text'>"."Ocorreu um erro no banco de dados, por favor confira as informações enviadas e tente novamente... ERRO: $e"."<p>";
          return; 
        }
        $return = $query->rowCount();       
      if($return > 0){
        return $_SESSION['regordersuccess'] ='';
    }else{
        return $_SESSION['regorderfailed'] ='';
    }
        
    }
}