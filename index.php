<?php
session_start();
require_once 'classes/autoload.php';
$userip = $_SERVER['REMOTE_ADDR'];
$users = new users();
include_once 'includes/header.include.php';
include_once 'includes/navbar.include.php';
$products = new products();

$filter="order by caddate desc LIMIT 4";
if(isset($_GET['filter'])){
    $filter = "where category ='".$_GET['filter']."' order by name asc";
}
if(isset($_GET['search'])){
    $filter = "where name like '%".$_GET['search']."%' order by name asc";
}

$pvalue = $products->fetchProducts($filter);
$sanitizestr = new sanitizestr();
?>

<!-- BODY CONTENT -->


    <?php if(isset($_SESSION['errorDB'])){echo $_SESSION['errorDB'];unset($_SESSION['errorDB']);} ?>
    <?php if(isset($_SESSION['userLoggedName'])){echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Bem vindo!</strong> '.$_SESSION['userLoggedName'].'<br>
  <p>Seu ip: '.$userip.'</p>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';} ?>
    <?php if(isset($_SESSION['warnlogin'])){echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>ERRO!</strong> Nenhum usuário encontrado com os dados fornecidos, clique <a href="https://industriaimpress.com.br/secure/login/login">aqui</a> para tentar novamente.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';unset($_SESSION['warnlogin']);} ?>





<div class="container aioproducts">
        <div style="border: 1px solid #0D47A1;border-radius:5px;" class="list-group category-section blue darken-4 ">
  <a href="#"  class="list-group-item list-group-item-action active">
    CATEGORIAS
  </a>
  <a href="#!" class="dropdown-category-toggle list-group-item list-group-item-action">COMUNICAÇÃO VISUAL <i class='icon-drop-category bi bi-caret-down-fill'></i></a>
  <div style="display: none;" class="dropdown-menu-category">
  <a href="index.php?filter=lona" class="list-group-item grey lighten-1 list-group-item-action">LONA <i class="bi bi-caret-right-fill"></i></a>
  <a href="index.php?filter=banner" class="list-group-item grey lighten-1 list-group-item-action">BANNER <i class="bi bi-caret-right-fill"></i></a>
  <a href="index.php?filter=adesivo" class="list-group-item grey lighten-1 list-group-item-action ">ADESIVO <i class="bi bi-caret-right-fill"></i></a>
  <a href="index.php?filter=faixa" class="list-group-item grey lighten-1 list-group-item-action ">FAIXA <i class="bi bi-caret-right-fill"></i></a>
  <a href="index.php?filter=tecido" class="list-group-item grey lighten-1 list-group-item-action ">TECIDO FLAG <i class="bi bi-caret-right-fill"></i></a>
  <a href="index.php?filter=recorte" class="list-group-item grey lighten-1 list-group-item-action ">RECORTE ELETRÔNICO<i class="bi bi-caret-right-fill"></i></a>
  <a href="index.php?filter=cartao" class="list-group-item list-group-item-action ">→ CARTÃO</a>
</div>
<a href="index.php?filter=trofeu" class="list-group-item list-group-item-action">TROFÉUS <i class="bi bi-caret-right-fill"></i></a>
</div>
<div class="section-all">
<?php 

if($filter === "order by caddate desc LIMIT 4"){
echo '<h1 class="text-center align-center bold pd-2">ÚLTIMOS PRODUTOS ADICIONADOS</h1>';
}
?>
<?php
if(!$pvalue){
    echo     "<div class='red lighten-4 product-section'>";
    echo     "<a href='#!'>";
    echo     "<img src='https://sitechecker.pro/wp-content/uploads/2017/12/404.png' alt='IMAGEM' class=' img-fluid img-product'>";
    echo     "</a>";
    echo     "<h5 class='blue-text pd-2>"."Nenhum produto encontrado!"."</h5>";
    echo     "<p class='grey-text pd-2'>"."Tente outra busca..."."</p>";
    echo     "<a href='#!' class='btn btn-buy red darken-4 white-text'>"."NENHUM PRODUTO ENCONTRADO"."</a>";
    echo     "</div>";
}
    foreach($pvalue as $value){
    $sanitizedName = $sanitizestr->sanitizeString($value['name']);
    $sanitizedFileName = $value['file'];
        
    echo     "<div class='product-section pd-1'>";
    echo     "<a href='products/buy.php?product_id=${value['id']}'>";
    echo     "<img  src='products/products-img/$sanitizedFileName' alt='IMAGEM' class=' img-fluid img-product'>";
    echo     "</a>";
    echo     "<h5 class='blue-text  pd-2'>"."${value['name']}"."</h5>";
    echo     "<p class='grey-text clb pd-2'>"."${value['description']}"."</p>";
    if($value['status'] === '0'){
        echo     "<a href='#!' class='btn btn-buy red darken-4 white-text'>"."SEM ESTOQUE"."</a>";

    }else{
    echo     "<a href='products/buy.php?product_id=${value['id']}' class='btn btn-buy blue darken-4 white-text'>"."COMPRAR"."</a>";
}
echo     "</div>";
}
?>
</div>
</div>  



<!-- BODY CONTENT -->

<script type="text/javascript" src="js/jquery/jquery.min.js"></script>
<script type="text/javascript" >
var dropCv = $('.dropdown-menu-category');
var iconDropCv = $(".icon-drop-category");
var toggleCv = $('.dropdown-category-toggle');
toggleCv.click(function(){
    if(dropCv.is(":visible")){
    dropCv.hide();
    iconDropCv.removeClass('bi bi-caret-down-fill')
    iconDropCv.removeClass('bi bi-caret-up-fill')
    iconDropCv.addClass('bi bi-caret-down-fill')

    }else{
    dropCv.show();
    iconDropCv.removeClass('bi bi-caret-up-fill')
    iconDropCv.removeClass('bi bi-caret-down-fill')
    iconDropCv.addClass('bi bi-caret-up-fill')
    }
    });
</script>

<?php include_once 'includes/footer.include.php'?>
<!-- SCRIPTS CONTENT -->
<!-- SCRIPTS CONTENT -->
