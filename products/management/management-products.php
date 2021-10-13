<?php
session_start();
require_once '../../classes/autoload.php';
$users = new users();
$products = new products();

if(!isset($_SESSION['usermoderator'])){
    header('location:https://industriaimpress.com.br/');}
    if(!isset($_SESSION['useradm'])){
        header('location:https://industriaimpress.com.br/');}
if(isset($_GET['filter'])){
    $filter = "where category ='".$_GET['filter']."'";
}else {
    $filter = '';
}
if(isset($_GET['search'])){
    $filter = "where name like '%".$_GET['search']."%'";
}else {
    $filter = '';
}
$pvalue = $products->fetchProducts($filter);
$sanitizestr = new sanitizestr();
include_once '../../includes/header.include.php';
include_once '../../includes/navbar.include.php';
?>

<!-- BODY CONTENT -->

    <a href="addnewproduct.php"><div class="col-12 w-100 pd-2 text-center grey lighten-2 mgb-2 container  shadow-lg">
        <span style="font-size:30px;"><i style="font-size:50px;" class="material-icons text-center green-text">note_add</i></span>
    </div></a>

<div class="container">

<div class="row">
<?php
if(isset($_SESSION['errorDB'])){
    echo $_SESSION['errorDB'];
    unset($_SESSION['errorDB']);
}

if(!$pvalue){
    echo     "<div style='border-radius:5px' class='red lighten-4 product-section col-2'>";
    echo     "<a href='#!'>";
    echo     "<img src='https://sitechecker.pro/wp-content/uploads/2017/12/404.png' alt='IMAGEM' class='rounded img-fluid img-product'>";
    echo     "</a>";
    echo     "<h5 class='blue-text'>"."Nenhum produto encontrado!"."</h5>";
    echo     "<p class='grey-text'>"."Tente outra busca..."."</p>";
    echo     "<a href='#!'  class='btn red darken-4 white-text '>"."NENHUM PRODUTO ENCONTRADO"."</a>";
    echo     "</div>";
}
    foreach($pvalue as $value){
    $sanitizedName = $sanitizestr->sanitizeString($value['name']);
    $sanitizedFileName = $value['file'];
    if($value['status'] === '0'){
        $statusMessage = 'ativar';
    }else{
        $statusMessage = 'desativar';
    }
    echo     "<div style='border-radius:5px' class='product-section col-2'>";
    echo     "<a href='buy.php?product_id=${value['id']}'>";
    echo     "<img src='../../products/products-img/$sanitizedFileName' alt='IMAGEM' class='rounded img-fluid img-product'>";
    echo     "</a>";
    echo     "<h5 class=' text-center blue-text'>"."${value['name']}"."</h5>";
    echo     "<p class=' text-center grey-text'>"."${value['description']}"."</p>";
    echo     "<p class=' text-center green-text'> ID="."${value['id']}"."</p>";
    echo "<table class='responsive-table'>
    <thead class='thead-dark'>
    <tr>
    </tr>
    </thead>
    <tbody>";
    echo     "<td><a href='editproduct.php?product_id=${value['id']}'><i  class='material-icons'>"."edit"."</i></a></td>";
    if($value['status'] === '0'){
    echo     "<td><a id='alterstatusproductid${value['id']}'  href='#!''><i  class='material-icons'>"."check_circle"."</i></a></td>";

    }else{
        echo     "<td><a id='alterstatusproductid${value['id']}' href='#!'><i  class='material-icons'>"."cancel"."</i></a></td>";

    }    
    echo     "<td><a  href='#!'id='deleteproduct${value['id']}' ><i  class='material-icons'>"."delete"."</i></a></td>";

echo "
</tbody>
</table>";
    echo     "</div>";
    echo "
    <script type='text/javascript'>
    $('#deleteproduct${value['id']}').click(function(){
        var id = ${value['id']};
        if(confirm('Você realmente deseja deletar este produto ?')) {
            $.ajax({
                url: 'deleteproduct.php',
                type: 'POST',
                data: {id: id},
                error: function() {
                  alert('Não foi possível deletar o produto!');
                  location.reload();  
                },
                success: function(data) {
                    alert('Produto deletado com sucesso!');  
                    location.reload();  
                }
            });
        }
    });
    $('#alterstatusproductid${value['id']}').click(function(){
        var id = ${value['id']};
        if(confirm('Você realmente deseja ".$statusMessage." este produto ?')) {
            $.ajax({
                url: 'alterstatus.php',
                type: 'POST',
                data: {id: id},
                error: function(da) {
                  alert('Não foi possível alterar o status do produto!');
                  location.reload();  
                },
                success: function(data) {
                    alert('Status do produto alterado!');
                    location.reload();  
                }
            });
        }
    });
    </script>";
}
?>
</div>
</div>

<!-- BODY CONTENT -->

<script type="text/javascript" src="../../js/jquery/jquery.min.js"></script>
<script type="text/javascript" >
var dropCv = $('.dropdown-menu-category');
var iconDropCv = $(".icon-drop-category");
var toggleCv = $('.dropdown-category-toggle');
toggleCv.click(function(){
    if(dropCv.is(":visible")){
    dropCv.hide();
    iconDropCv.removeClass('bi bi-arrow-up')
    iconDropCv.removeClass('bi bi-arrow-down')
    iconDropCv.addClass('bi bi-arrow-down')

    }else{
    dropCv.show();
    iconDropCv.removeClass('bi bi-arrow-up')
    iconDropCv.removeClass('bi bi-arrow-down')
    iconDropCv.addClass('bi bi-arrow-up')
    }
    });

</script>

<script type="text/javascript">
  $(document).ready(function(){
    $('.modal').modal();
  });
  </script>

<?php include_once '../../includes/footer.include.php'?>
<!-- SCRIPTS CONTENT -->
<!-- SCRIPTS CONTENT -->
