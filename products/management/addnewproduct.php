<?php
session_start();
if(!isset($_SESSION['useradm'])){
    header('location: ../../index.php');

}
require_once '../../classes/autoload.php';
include_once '../../includes/header.include.php';
include_once '../../includes/navbar.include.php';

?>

<!-- BODY CONTENT  -->


<div style='border-radius:10px; margin:2% auto 2% auto;'class="container indigo black-text lighten-3">
<form action="processing.php" method="post" enctype="multipart/form-data">
    <div style="border-radius:10px;" class="pd-2 grey text-center indigo-text lighten-3 ">
    <h2>CADASTRO DE PRODUTOS - INDUSTRIA IMPRESS</h2>
    <p>Cadastre novos produtos!</p>
    <p class="green-text"><?php if(isset($_SESSION['cadproductsucess'])){ echo 'Produto cadastrado';} unset($_SESSION['cadproductsucess']); ?></p>
    <p class="red-text"> <?php if(isset($_SESSION['cadproducterror'])){echo 'Erro no cadastro';} unset($_SESSION['cadproducterror']); ?></p>
    <p class="red-text"><?php if(isset($_SESSION['wrongextension'])){echo 'Extensão de arquivo não suportada!';} ?></p>
    <p class="red-text"><?php if(isset($_SESSION['errorDB'])){echo $_SESSION['errorDB'];};unset($_SESSION['errorDB']) ?></p>
    </div>
    <div class="row pd-2 ">
  <div class="form-group col">
    <label for="name">Nome</label>
    <input type="text" class="form-control" name="name" maxlength="255" id="name" aria-describedby="nameHelp" placeholder="EX: Lona 440g/m²" required>
</div>
  <div class="form-group col-5">
    <label for="description">Descrição</label>
    <input type="text" name="description" class="form-control" maxlength="255" id="description" placeholder="EX: Acabamento com ilhós">
  </div>
  <div class="form-group col-2">
    <label for="vm">Valor M²</label>
    <input type="number" class="form-control" name="vm" maxlength="255" id="vm" placeholder="Valor do m²" required>
</div>
  <div class="form-group col-2">
    <label for="vp">Valor FIXO</label>
    <input type="number" class="form-control" name="vp" maxlength="255" id="vp" placeholder="Valor FIX" required>
</div>
</div>
<div class="row pd-2">
  <div class="form-group col-3">
    <label for="category">Categoria</label>
    <select class="form-control" name="category" id="category"> 
        <option value="lona" selected>Lona</option>
        <option value="adesivo">Adesivo</option>
        <option value="banner">Banner</option>
        <option value="cartao">Cartao</option>
        <option value="faixa">Faixa</option>
        <option value="tecido">Tecido</option>
        <option value="recorte">Recorte Eletrônico</option>
        <option value="trofeu">Trofeu</option>
    </select>
  </div>
  <div class="form-group col-3">
    <label for="fv">Frente e Verso</label>
    <select class="form-control" name="fv" id="fv"> 
        <option value="1">Sim</option>
        <option value="0"selected>Não</option>
    </select>
  </div>
  <div class="form-group col-3">
    <label for="timep">Tempo para produção (dias)</label>
    <select class="form-control" name="timep" id="timep"> 
        <option value="1 dia"selected>1</option>
        <option value="2 dias">2</option>
        <option value="3 dias">3</option>
        <option value="4 dias">4</option>
        <option value="5 dias">5</option>
        <option value="6 dias">6</option>
        <option value="7+ dias">7+</option>
    </select>
  </div>
  <div class="form-group col-3">
    <label for="status">Situação</label>
    <select class="form-control" name="status" id="status"> 
        <option value="1">Ativo</option>
        <option value="0" selected>Inativo</option>
    </select>
  </div>
<div class="custom-file pd-2">
<label class="form-label" for="file">Clique ou arraste um arquivo | Somente JPG(600x400) Max 1mb </label>
<input name="file" type="file" class="form-control" id="file" required/>
  <div class="progress mgt-2">
  <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
  
</div>
</div>
  </div>

<div class="form-group pd-2 col">
    <button type="submit" class="btn white-text green">Cadastrar</button>
    <button type="reset" class="btn blue white-text darken-4">Limpar</button>
</div>
  
</form>
</div>


<script type="text/javascript">
$(document).on('submit','form', function (e) {
e.preventDefault();
$form = $(this);
var formData = new FormData($form[0]);
var request = new XMLHttpRequest();

request.upload.addEventListener('progress', function (e) {
  var percent = Math.round(e.loaded / e.total * 100);
  $form.find('.progress-bar').width(percent + '%').html(percent + '%')
});
request.addEventListener('load', function(e){
  $form.find('.progress-bar').addClass('green').html('Upload Completo!...');
  setTimeout("window.open(self.location, '_self');", 1000);
});


request.open('post', 'processing.php');
request.send(formData)
});

</script>

<!-- BODY CONTENT  -->

<?php include_once '../../includes/footer.include.php';?>