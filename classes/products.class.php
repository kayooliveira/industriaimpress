<?php 

class products extends conDB {
  public function insertProducts($name,$file,$description,$vm,$vp,$fv,$timep,$category,$status){
      $conDB = $this->condb();
      $sql = "insert into impress_products (name,file,description,vm,vp,fv,timep,caddate,category,status) values ('$name','$file','$description','$vm','$vp','$fv','$timep',NOW(),'$category','$status')";
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
        return $_SESSION['cadproductsucess'] ='';
    }else{
        return $_SESSION['cadproducterror'] ='';
    }
  }
  public function alterProducts($name,$file,$description,$vm,$vp,$fv,$timep,$category,$status,$id){
      $conDB = $this->condb();
      $sql = "update impress_products set name='$name',file='$file',description='$description',vm='$vm',vp='$vp',fv='$fv',timep='$timep',caddate=NOW(),category='$category',status='$status' where id=$id";
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
        return $_SESSION['cadproductsucess'] ='';
    }else{
        return $_SESSION['cadproducterror'] ='';
    }
  }

  public function fetchProducts($a){
    $conDB = $this->condb();
    $sql = "select * from impress_products $a";
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
public function deleteProduct($a){
  $conDB = $this->condb();
  $sql = "delete from impress_products where id= $a";
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
public function alterStatusProduct($a,$b){
  $conDB = $this->condb();
  $sql = "update impress_products set status=$a where id=$b";
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

public function filterProductById($a){
  $conDB = $this->condb();
  $sql = "select * from impress_products where id='$a'";
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

}