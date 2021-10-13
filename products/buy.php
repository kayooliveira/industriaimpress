<?php
session_start();

if(!isset($_SESSION['userLogged'])){
    header('location: ../secure/login/login.php');
  }
require_once '../classes/autoload.php';
$users = new users();
$products = new products();

$product_id = '';
if(isset($_GET['product_id'])){
    $product_id = $_GET['product_id'];
}else {
    header('location: ../index.php');
}
$pvalue = $products->filterProductById($product_id);
if($pvalue['status'] === '0'){
  header('location: ../index.php');
}

$sanitizestr = new sanitizestr();
include_once '../includes/header.include.php';
include_once '../includes/navbar.include.php';
?>

<!-- BODY CONTENT -->
<div class="row">
<div class=" grey lighten-2  col-4">
    <div class="product-preview-section pd-2">
        <img src="products-img/<?php echo $pvalue['file'] ?>" alt="<?php echo $pvalue['file'] ?>" class="product-preview-img w-100">
        <p class="blockbutton pd-2 mg-0 blue uppercase text-center white-text"><?php echo $pvalue['description']; ?></p>
        <p class="blockbutton pd-2 mg-0 blue uppercase text-center white-text">Tempo de produção: <?php echo $pvalue['timep']; ?> úteis</p>
        <a href="#!" class="btn blockbutton white-text blue darken-4">VALOR: R$ <?php echo $pvalue['vm']; ?>,00</a>
        <img src="../img/logo/logo_horizontal_sm.svg" class="w-100 blue pd-2 rounded mgt-5">
    </div>
</div>
<div class=" grey lighten-2 mgl-2 col-7">
    <div class="product-buy-section">
    <form action="#!" method="post" enctype="multipart/form-data">
    <div style="border-radius:10px;" class="pd-2 grey text-center indigo-text lighten-3 ">
    <h2><?php echo $pvalue['name']; ?></h2>
    <p><?php echo $pvalue['description']; ?></p>
    <p class="green-text"><?php if(isset($_SESSION['cadordersuccess'])){ echo 'Pedido cadastrado!';} unset($_SESSION['cadordersuccess']); ?></p>
    <p class="red-text"> <?php if(isset($_SESSION['cadordererror'])){echo 'Erro no pedido!';} unset($_SESSION['cadordererror']); ?></p>
    <p class="red-text"><?php if(isset($_SESSION['wrongextension'])){echo 'Extensão de arquivo não suportada!';}unset($_SESSION['wrongextension']); ?></p>
    <p class="red-text"><?php if(isset($_SESSION['errorDB'])){echo "OCORREU UM ERRO NO BANCO DE DADOS". $_SESSION['errorDB'];};unset($_SESSION['errorDB']) ?></p>
    <p class="red-text"><?php if(isset($_SESSION['nolimit'])){echo $_SESSION['nolimit'];};unset($_SESSION['nolimit']) ?></p>
    </div>
    <div class="row pd-2 ">
  <div class="form-group col">
    <label for="description">Descrição</label>
    <input type="text" class="form-control" name="description" maxlength="255" id="description" placeholder="EX: Recorte na cor vermelha" required>
</div>
  <div class="form-group col">
    <label for="pdescription">OBS. de Produção</label>
    <textarea type="text" class="form-control" name="pdescription" maxlength="255" id="pdescription" placeholder="EX: Ilhós apenas nas pontas" ></textarea>
</div>
  <div class="form-group col-2">
    <label for="qnt">Qnt.</label>
    <input type="number" name="qnt" required class="form-control" maxlength="10" id="qnt" placeholder="ex: 2">
  </div>
  <div class="form-group col-2">
    <label for="scalex">Largura (cm)</label>
    <input type="text" name="scalex" required class="form-control" maxlength="255" id="scalex" placeholder="EX: 115">
  </div>
  <div class="form-group col-2">
    <label for="scaley">Altura (cm)</label>
    <input type="text" name="scaley" required  class="form-control" maxlength="255" id="scaley" placeholder="EX: 115">
  </div>
</div>
<div class="row pd-2">
  <div class="form-group col-3">
    <label for="scalexy">Área em M²</label>
    <input type="text" class="form-control" readonly  name="scalexy" maxlength="255" id="scalexy" placeholder="1,3225">
</div>

<div class="form-group col-3">
    <label for="value">Valor Total</label>
    <input type="text" class="form-control" readonly name="value" maxlength="255" id="value" placeholder="1,3225">
</div>
</div>
<div class="row pd-2">
<div class="custom-file">
<label class="form-label" for="file">Clique ou arraste um arquivo (JPG,PNG,CDR,JPEG,PLT,PDF) MAX 100mb</label>
<input name="file" type="file" class="form-control" id="file" required/>
  <div class="progress mgt-2">
  <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
</div>
<?php 
    if($pvalue['fv'] === '1'){
        echo "
            
<div class='custom-file'>
<label class='form-label' for='file2'>Clique ou arraste o verso (JPG,PNG,CDR,JPEG,PLT,PDF) MAX 100mb</label>
<input name='file2' type='file' class='form-control' id='file2' required/>
  <div class='progress mgt-2'>
  <div class='progress-bar progress-bar-striped' role='progressbar2' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100'></div>
  
</div>
</div>      
        ";
    };
?></div>
  

<div class="modal fade" id="confirmOrder" tabindex="-1" aria-labelledby="confirmOrder" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content">
  <div class="modal-header">
    <h5 class="modal-title red-text" id="labelcancelorder'.$value['id'].'">ATENÇÃO</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  </div>
  <div class="modal-body">

ANTES DE CONCLUIR SUA COMPRA, CERTIFIQUE-SE QUE:<br>
- O arquivo está em CMYK.<br>
- O arquivo está convertido em curvas.<br>
- Todos os efeitos [ lentes, power clip, texturas, gradientes, etc...] estão convertidos em bitmap 400dpis.<br><br>


---Não nos responsabilizamos por alterações de tons de cores que não estiverem em CMYK<br>
---Pedidos em que tons de pretos que não estiverem com os padrões CMYK a seguir <br> </p><img src="black_default_cmyk.png" class="rounded w-50"> <p class='red-text'>OS MESMOS SERÃO PRODUZIDOS SEM DIREITO A REEMBOLSO OU A SEREM REFEITOS!</p><br><br>


OS ARQUIVOS ENVIADOS FORA DOS NOSSOS PADRÕES  PERDEM A GARANTIA E NÃO PODERÃO SER REFEITOS PELA IMPRESS<br><br>
    </div>
    <div class='progress mgt-2'>
  <div class='progress-bar progress-bar-striped' role='progressbar2' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100'></div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn red btn-secondary" data-bs-dismiss="modal">Fechar</button>
    <button type="submit" class="btn green btn-primary">Sim</button>
  </div>
  </div>
  </div>
  </div>
<div class="form-group pd-2 col">
    <a  data-bs-toggle='modal' data-bs-target='#confirmOrder' class="btn white-text green">Confirmar</a>
    <button type="reset" class="btn blue white-text darken-4">Limpar</button>
</div>
  
</form>
    </div>
</div>
</div>





<!-- BODY CONTENT -->

<?php include_once '../includes/footer.include.php'?>
<script type='text/javascript'>

$(document).on('submit','form', function (e) {
e.preventDefault();

$form = $(this);
var formData = new FormData($form[0]);
var request = new XMLHttpRequest();
var product_id = <?php echo json_encode($product_id)?>;
request.upload.addEventListener('progress', function (e) {
  var percent = Math.round(e.loaded / e.total * 100);
  $form.find('.progress-bar').width(percent + '%').html(percent + '%');
  $('button').hide();
});
request.addEventListener('load', function(e){
  $form.find('.progress-bar').addClass('green').html('Upload Completo!...');
  $('button').show;
  alertify.alert("PEDIDO CADASTRADO!",function(){
      location.reload();
  });
});


request.open('post', 'processing.php?product_id=' + product_id);
request.send(formData)
});
</script>

<script type="text/javascript">
$(document).ready(function(){
    $("#fv").change(function(){
        $(this).find("option#sim:selected").each(function(){
            if(!$('.if-fv').is(':visible')){
            $('.if-fv').show()
        }
        });
        $(this).find("option#nao:selected").each(function(){
            if($('.if-fv').is(':visible')){
            $('.if-fv').hide()
        }
        });
    }).change();
});
</script>

<script type="text/javascript">
    $('input').change(
    function() {
        var scaley = document.getElementById('scaley').value;
        var scaley = scaley.replace(',','.');
        var scalex = document.getElementById('scalex').value;
        var qnt = document.getElementById('qnt').value;
        var scalex = scalex.replace(',','.');
        var vm = <?php echo json_encode($pvalue['vm'])?>;
        var scalexy = (scaley*scalex);
        var totalscalexy = scalexy/10000;
        var totalvalue = (totalscalexy*vm);
        var totalvalue = totalvalue * qnt;
        var halvfm = vm/2;
      if(totalvalue < halvfm){
        var totalvalue = halvfm;
      }
        document.getElementById('scalexy').value = totalscalexy.toLocaleString('pt-BR').replace(',','.') + ' m²'
        document.getElementById('value').value =  (totalvalue).toFixed(2);

      

    });

</script>
<!-- SCRIPTS CONTENT -->
