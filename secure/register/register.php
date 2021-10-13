<?php
session_start();
require_once '../../classes/autoload.php';
include_once '../../includes/header.include.php';
include_once '../../includes/navbar.include.php';

?>

<!-- BODY CONTENT  -->


<div class="container blue lighten-3">
<form action="processing.php" method="post">
    <div style="border-radius:10px;" class="pd-2 grey lighten-3 ">
    <h5>Cadastre-se no nosso site para pode utilizar os nossos serviços!</h5>
    <p>O seu cadastro passará por uma aprovação da nossa equipe, esta aprovação pode demorar alguns minutos e só ocorrerá em dias úteis!</p>
    <?php if(isset($_SESSION['cadwarn'])){echo $_SESSION['cadwarn'];unset($_SESSION['cadwarn']);} ?>
    <?php if(isset($_SESSION['warndup'])){echo $_SESSION['warndup'];unset($_SESSION['warndup']);} ?>
    </div>
    <div class="row pd-2 ">
  <div class="form-group col">
    <label for="fname">Nome</label>
    <input type="text" class="form-control" name="fname" maxlength="255" id="fname" aria-describedby="nameHelp" placeholder="INDUSTRIA" required>
</div>
  <div class="form-group col">
    <label for="lname">Sobrenome</label>
    <input type="text" name="lname" class="form-control" maxlength="255" id="lname" placeholder="IMPRESS">
  </div>
  <div class="form-group col-5">
    <label for="company">Empresa</label>
    <input type="text" class="form-control" name="company" maxlength="255" id="company" aria-describedby="companyHelp" placeholder="INDUSTRIA IMPRESS" required>
</div>
</div>
<div class="row pd-2">
  <div class="form-group col">
    <label for="doctype">Escolha o documento</label>
    <select class="form-control" name="doctype" id="doctype"> 
        <option value="cpnj" selected>CNPJ</option>
        <option value="cpf">CPF</option>
    </select>
  </div>
  <div class="form-group col">
    <label for="document">Documento (somente números)</label>
    <input type="text" class="form-control" name="document" maxlength="14" id="document" aria-describedby="docHelp" placeholder="INSIRA SEU DOCUMENTO AQUI" required>
</div>
  <div class="form-group col">
    <label for="ie">Inscrição Estadual</label>
    <input type="text" class="form-control" name="ie" maxlength="255" id="ie" aria-describedby="ieHelp" placeholder="Inscrição Estadual" >
</div>
</div>

<div class="row pd-2">
  <div class="form-group col">
    <label for="username">Nome de Usuário</label>
    <input type="text" class="form-control" name="username" minlength="8" maxlength="20" id="username" aria-describedby="mailHelp" placeholder="industriaimpress" required>
</div>
  <div class="form-group col">
    <label for="email">E-mail</label>
    <input type="email" class="form-control" name="email" maxlength="255" id="email" aria-describedby="mailHelp" placeholder="contato@industriaimpress.com.br" required>
</div>
  <div class="form-group col">
    <label for="email">Senha</label>
    <input type="password" class="form-control" name="password" minlength="8" maxlength="40" id="password" aria-describedby="passwordHelp" placeholder="Min. 8 caracteres" required>
</div>
</div>

<div class="row pd-2">
  <div class="form-group col">
    <label for="birthdate">Data de nascimento</label>
    <input type="date" class="form-control" name="birthdate" maxlength="255" id="birthdate" aria-describedby="dateHelp" required>
</div>
  <div class="form-group col">
    <label for="contact">Telefone (somente números)</label>
    <input type="tel" class="form-control" name="contact" maxlength="11" id="contact" aria-describedby="passwordHelp" placeholder="12345678900" required>
</div>
  <div class="form-group col">
    <label for="address">Endereço</label>
    <input type="text" class="form-control" name="address" maxlength="255" id="address" aria-describedby="addressHelp" placeholder="Endereço" required>
</div>
</div>
  <div class="form-group pd-2 col">
    <button type="submit" class="btn white-text green">Cadastrar</button>
    <button type="reset" class="btn blue white-text darken-4">Limpar</button>
</div>
  </div>
  
</form>
</div>


<!-- BODY CONTENT  -->

<?php include_once '../../includes/footer.include.php';?>