<?php
session_start();
if(!isset($_SESSION['useradm'])){
    header('location: ../../index.php');

}
require_once '../../classes/autoload.php';
include_once '../../includes/header.include.php';
$product_id = $_GET['product_id'];
$products = new products();
$pd = $products->filterProductById($product_id);

echo '
<!-- BODY CONTENT  -->


<div style="border-radius:10px; margin:2% auto 2% auto;" class="container indigo black-text lighten-3">
<form action="applyedit.php?product_id='.$product_id.'" method="post" enctype="multipart/form-data">
    <div style="border-radius:10px;" class="pd-2 grey text-center indigo-text lighten-3 ">
    </div>
    <div class="row pd-2 ">
  <div class="form-group col">
    <label for="name">Nome</label>
    <input type="text" class="form-control" name="name" maxlength="255" value="'.$pd["name"].'" id="name" value="" aria-describedby="nameHelp"  required>
</div>
  <div class="form-group col-5">
    <label for="description">Descrição</label>
    <input type="text" name="description" class="form-control" value="'.$pd["description"].'" maxlength="255" id="description">
  </div>
  <div class="form-group col-2">
    <label for="vm">Valor M²</label>
    <input type="number" class="form-control" name="vm" value="'.$pd["vm"].'" maxlength="255" id="vm" required>
</div>
  <div class="form-group col-2">
    <label for="vp">Valor FIXO</label>
    <input type="number" class="form-control" name="vp" value="'.$pd["vp"].'" maxlength="255" id="vp" required>
</div>
</div>
<div class="row pd-2">
  <div class="form-group col-3">
    <label for="category">Categoria</label>
    <select class="form-control" name="category" id="category"> 
        <option value="lona" '.(($pd["category"] === "lona") ? "selected": "").'>Lona</option>
        <option value="adesivo" '.(($pd["category"] === "adesivo") ? "selected": "").'>Adesivo</option>
        <option value="banner" '.(($pd["category"] === "banner") ? "selected": "").'>Banner</option>
        <option value="cartao" '.(($pd["category"] === "cartao") ? "selected": "").'>Cartao</option>
        <option value="faixa" '.(($pd["category"] === "faixa") ? "selected": "").'>Faixa</option>
        <option value="tecido" '.(($pd["category"] === "tecido") ? "selected": "").'>Tecido</option>
        <option value="trofeu" '.(($pd["category"] === "trofeu") ? "selected": "").'>Trofeu</option>
    </select>
  </div>
  <div class="form-group col-3">
    <label for="fv">Frente e Verso</label>
    <select class="form-control" name="fv" id="fv"> 
        <option value="1" '.(($pd["fv"] === "1") ? "selected": "").'>Sim</option>
        <option value="0" '.(($pd["fv"] === "0") ? "selected": "").'>Não</option>
    </select>
  </div>
  <div class="form-group col-3">
    <label for="timep">Tempo para produção (dias)</label>
    <select class="form-control" name="timep" id="timep"> 
        <option value="1 dia" '.(($pd["timep"] === "1 dia") ? "selected": "").'>1</option>
        <option value="2 dias" '.(($pd["timep"] === "2 dias") ? "selected": "").'>2</option>
        <option value="3 dias" '.(($pd["timep"] === "3 dias") ? "selected": "").'>3</option>
        <option value="4 dias" '.(($pd["timep"] === "4 dias") ? "selected": "").'>4</option>
        <option value="5 dias" '.(($pd["timep"] === "5 dias") ? "selected": "").'>5</option>
        <option value="6 dias" '.(($pd["timep"] === "6 dias") ? "selected": "").'>6</option>
        <option value="7+ dias" '.(($pd["timep"] === "7+ dias") ? "selected": "").'>7+</option>
    </select>
  </div>
  <div class="form-group col-3">
    <label for="status">Situação</label>
    <select class="form-control" name="status" id="status"> 
        <option value="1" '.(($pd["status"] === "1") ? "selected": "").'>Ativo</option>
        <option value="0" '.(($pd["timep"] === "0") ? "selected": "").'>Inativo</option>
    </select>
  </div>
<div class="custom-file pd-2">
<label class="form-label" for="file"><a download href="../products-img/'.$pd["file"].'"><i class="bi bi-download"></i>Baixar Atual</a> </label>
<input name="file" type="file" value="" class="form-control" id="file" required/>
  <div class="progress mgt-2">
  <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
  
</div>
</div>
  </div>

<div class="form-group pd-2 col">
    <button type="submit" class="btn white-text green">Alterar</button>
    <button onclick="goBack()" type="button" class="btn red white-text darken-4">Voltar</button>
</div>
  
</form>
</div>';

?>
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
  setTimeout("window.history.back();", 1000);
});


request.open('post', 'applyedit.php?product_id=<?php echo $product_id?>');
request.send(formData)
});

</script>
<script>
function goBack() {
  window.history.back();
}
</script>
<!-- BODY CONTENT  -->
