<?php
require_once '../classes/autoload.php';
if(isset($_GET['id'])){
    $id = $_GET['id'];
}else{
    header('location: searchuser.php');
}
include_once '../includes/header.include.php';
include_once '../includes/navbar.include.php';
if(!isset($_SESSION['useradm'])){
    header("location: ../");
}
$users = new users();
$values = $users->fetchUserById($id);
?>

<!-- BODY CONTENT -->

<?php
print $values['id'];
?>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content text-center">
        <div class="text-center modal-header">
          <h1>Alterar Senha de Usuário:</h1>
        </div>
        <div class="modal-body">
        <form class='login-section-form' action="changepasswd.php" method="post">
    <?php if(isset($_SESSION['errorDB'])){echo $_SESSION['errorDB'];unset($_SESSION['errorDB']);} ?>
    <?php if(isset($_SESSION['userLoggedName'])){echo "<p class='green-text'>Bem vindo ".$_SESSION['userLoggedName']."</p>";} ?>
    <?php if(isset($_SESSION['warnlogin'])){echo $_SESSION['warnlogin'];unset($_SESSION['warnlogin']);} ?>
  <div class="form-group mgb-5">
    <label for="userid">ID de Usuário:</label>
    <input type="number" class="form-control" readonly name="userid" maxlength="255" id="userid" aria-describedby="userid" placeholder="" required>
</div>
  <div class="form-group mgt-5">
    <label for="usernewpass">Nova senha:</label>
    <input type="password" class="form-control" name="usernewpass" minlength="8" maxlength="40" id="usernewpass" aria-describedby="passwordHelp" placeholder="Min. 8 caracteres" required>
</div>
  <div class="form-group mgt-5">
    <button type="submit" class="btn white-text indigo">Alterar</button>
</div>

</form>
        </div>
        <div class="modal-footer">
          <a href='../' class="btn btn-default" data-dismiss="modal">Voltar</a>


</div>
      </div>
      
    </div>
<script type="text/javascript">
$(document).ready(function(){
    $("#userid").val(<?php echo json_encode($id)?>);
});
    $(document).ready( function() {
        $('.modal').modal('show').show();
    });
    $(document).mousemove(function(){
      $('.modal').modal('show').show();

    });
</script>
<!-- BODY CONTENT -->

<?php include_once '../includes/footer.include.php'?>
<!-- SCRIPTS CONTENT -->
<!-- SCRIPTS CONTENT -->
