<?php

class users extends conDB {
  public function fetchUsers($a, $b, $c){
      $conDB = $this->condb();
      $sql = "select * from impress_users where $a like '%$b%' $c";
      $query = $conDB->prepare($sql);
      try {
        $query->execute();
      }
      catch(Exception $e){
        $_SESSION['errorDB'] = "<p class='red-text'>"."Ocorreu um erro no banco de dados, por favor confira as informações enviadas e tente novamente"."<p>";
        return; 
      }
      $return = $query->fetchAll();
      return $return;
  }
  public function fetchAllUsers(){
      $conDB = $this->condb();
      $sql = "select * from impress_users";
      $query = $conDB->prepare($sql);
      try {
        $query->execute();
      }
      catch(Exception $e){
        $_SESSION['errorDB'] = "<p class='red-text'>"."Ocorreu um erro no banco de dados, por favor confira as informações enviadas e tente novamente"."<p>";
        return; 
      }
      $return = $query->fetchAll();
      return $return;
  }
  public function fetchUserById($a){
      $conDB = $this->condb();
      $sql = "select * from impress_users where id=$a";
      $query = $conDB->prepare($sql);
      try {
        $query->execute();
      }
      catch(Exception $e){
        $_SESSION['errorDB'] = "<p class='red-text'>"."Ocorreu um erro no banco de dados, por favor confira as informações enviadas e tente novamente"."<p>";
        return;
      }
      $return = $query->fetch();
      return $return;
  }
  public function changePasswd($a,$b){
      $conDB = $this->condb();
      $sql = "update impress_users set password='$b' where id='$a'";
      $query = $conDB->prepare($sql);
      try {
        $query->execute();
      }
      catch(Exception $e){
        $_SESSION['errorDB'] = "<p class='red-text'>"."Ocorreu um erro no banco de dados, por favor confira as informações enviadas e tente novamente"."<p>";
        return;
      }
      $return = $query->fetch();
      return $return;
  }
  public function fetchUserByName($a){
      $conDB = $this->condb();
      $sql = "select * from impress_users $a";
      $query = $conDB->prepare($sql);
      try {
        $query->execute();
      }
      catch(Exception $e){
        $_SESSION['errorDB'] = "<p class='red-text'>"."Ocorreu um erro no banco de dados, por favor confira as informações enviadas e tente novamente"."<p>";
        return;
      }
      $return = $query->fetch();
      return $return;
  }
  public function userLogin($a,$b){
      $conDB = $this->condb();
      $sql = "select * from impress_users where ( username = '$a' OR email = '$a' ) and password='$b'";
      $query = $conDB->prepare($sql);
      try {
        $query->execute();
      }
      catch(Exception $e){
        $_SESSION['errorDB'] = "<p class='red-text'>"."Ocorreu um erro no banco de dados, por favor confira as informações enviadas e tente novamente"."<p>";
        echo $e;
        }
      $return = $query->rowCount();
      $userInfo = $query->fetch();
      if($userInfo['status'] === '0'){
        $_SESSION['warnlogin'] = "<p class='red-text'>"."Conta desativada!"."</p>";
        return;
      }
      if($userInfo['banned'] === '1'){
        $_SESSION['warnlogin'] = "<p class='red-text'>"."Usuário BANIDO!"."</p>";
        return;
      }
      if($return > 0){
        $_SESSION['userLogged'] ='';
        $_SESSION['userLoggedId'] = $userInfo['id'];
        $_SESSION['userLoggedName'] = $userInfo['fname']." ".$userInfo['lname'];
        $_SESSION['userPermissions'] = $userInfo['permissions'];
        
      if($userInfo['permissions'] === 'all'){
        $_SESSION['useradm'] = "";
        
        $_SESSION['userLoggedName'] = $userInfo['fname']." ".$userInfo['lname'];
        $_SESSION['usermoderator'] = "";
      }elseif($userInfo['permissions'] === 'moderator'){
        $_SESSION['usermoderator'] = "";
        $_SESSION['userLoggedName'] = $userInfo['fname']." ".$userInfo['lname'];
        return;
      }
        
      }else{
        return $_SESSION['warnlogin'] = "<p class='red-text'>"."Nenhum usuário encontrado com os dados fornecidos!"."</p>";
      }
  }
    public function deleteUser($a){
      $conDB = $this->condb();
      $sql = "delete from impress_users where id=$a";
      $query = $conDB->prepare($sql);
      try {
        $query->execute();
      }
      catch(Exception $e){
        $_SESSION['errorDB'] = "<p class='red-text'>"."Ocorreu um erro no banco de dados, por favor confira as informações enviadas e tente novamente"."<p>";
        return;
      }
      $return = $query->rowCount();
      if($return > 0){
        return true;
      }else{
        return false;
      }
  }
    public function cadNewUser($fname,$lname,$username,$email,$contact,$document,$address,$password,$birthdate,$ie,$doctype,$company){
      $conDB = $this->condb();
      $sql = "insert into impress_users (fname,lname,username,email,contact,document,address,password,birthdate,caddate,ie,doctype,company) values ('$fname','$lname','$username','$email','$contact','$document','$address','$password','$birthdate',NOW(),'$ie','$doctype','$company')";
      $query = $conDB->prepare($sql);
      try {
        $query->execute();
      }
      catch(Exception $e){
        $_SESSION['errorDB'] = "<p class='red-text'>"."Ocorreu um erro no banco de dados, por favor confira as informações enviadas e tente novamente"."<p>";
        return;
      }
      $return = $query->rowCount();
      if($return['email'] === $email){
        return $_SESSION['warndup'] = "<p class='red-text'>".'Email já existente no banco de dados!'."</p>";
      }
      if($return['cpf'] === $document){
        return $_SESSION['warndup'] = "<p class='red-text'>".'CPF/CNPJ já existente no banco de dados!'."</p>";
      }
      if($return['username'] === $username){
        return $_SESSION['warndup'] = "<p class='red-text'>".'Nome de usuário já existente no banco de dados!'."</p>";
      }
      if($return > 0){
        return $_SESSION['cadwarn'] = "<p class='green-text'>".'Cadastro efetuado!'."</p>";
      }else{
        return $_SESSION['cadwarn'] = "<p class='red-text'>".'Erro ao cadastrar seu usuário, por favor, confira os dados informados e tente novamente, se o erro persistir, contate a equipe de administração da IMPRESS - Comunicação Visual!'."</p>";
      }
  }
  
  public function updateStatus($a,$b,$c){
    $conDB = $this->condb();
    $sql = "update $a set status=$b where id='$c'";
    $query = $conDB->prepare($sql);
    try {
      $query->execute();
    }
    catch(Exception $e){
      $_SESSION['errorDB'] = "<p class='red-text'>"."Ocorreu um erro no banco de dados, por favor confira as informações enviadas e tente novamente"."<p>";
      return;
    }
}
public function updateLimit($a,$b){
  $conDB = $this->condb();
  $sql = "update impress_users set debt='$a' where id='$b'";
  $query = $conDB->prepare($sql);
  try {
    $query->execute();
  }
  catch(Exception $e){
    $_SESSION['errorDB'] = "<p class='red-text'>"."Ocorreu um erro no banco de dados, por favor confira as informações enviadas e tente novamente"."<p>";
    return;
  }
}

}