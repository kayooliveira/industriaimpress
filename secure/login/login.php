<?php
session_start();
require_once  '../../classes/autoload.php';
include_once  '../../includes/header.include.php';
if(isset($_SESSION['userLogged'])){
  header('location: ../../index.php');
}
?>

<!-- BODY CONTENT  -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content text-center">
        <div class="text-center modal-header">
          <h1>LOGIN - IMPRESS</h1>
        </div>
        <div class="modal-body">
        <form class='login-section-form' action="processing.php" method="post">
    <?php if(isset($_SESSION['errorDB'])){echo $_SESSION['errorDB'];unset($_SESSION['errorDB']);} ?>
    <?php if(isset($_SESSION['userLoggedName'])){echo "<p class='green-text'>Bem vindo ".$_SESSION['userLoggedName']."</p>";} ?>
    <?php if(isset($_SESSION['warnlogin'])){echo $_SESSION['warnlogin'];unset($_SESSION['warnlogin']);} ?>
  <div class="form-group mgb-5">
    <label for="username">Usuário/E-mail</label>
    <input type="text" class="form-control" name="username" maxlength="255" id="username" aria-describedby="mailHelp" placeholder="contato@industriaimpress.com.br" required>
</div>
  <div class="form-group mgt-5">
    <label for="email">Senha</label>
    <input type="password" class="form-control" name="password" minlength="8" maxlength="40" id="password" aria-describedby="passwordHelp" placeholder="Min. 8 caracteres" required>
</div>
  <div class="form-group mgt-5">
    <button type="submit" class="btn white-text indigo">Login</button>
</div>

</form>
        </div>
        <div class="modal-footer">
          <a href='../../index.php' class="btn btn-default" data-dismiss="modal">Voltar</a>


</div>
      </div>
      
    </div>
<script type="text/javascript">
    $(document).ready( function() {
        $('.modal').modal('show').show();
    });
    $(document).mousemove(function(){
      $('.modal').modal('show').show();

    });
</script>

<!-- BODY CONTENT  -->