<?php
session_start();
require '../classes/autoload.php';

if(!isset($_SESSION['useradm'])){
    header('location: ../index.php');
  }
include_once '../includes/header.include.php';
include_once '../includes/navbar.include.php';

$userid = $_SESSION['userLoggedId'];

$sanitizestr = new sanitizestr();
$user = new users();
$orders = new orders();
$products = new products();
$ordersdata = $orders->fetchOrders('where incart="1" order by date desc');
$userdata = $user->fetchUserById($userid);
$userLoggedName = $_SESSION['userLoggedName'];

date_default_timezone_set('America/Sao_Paulo');

?>

<!-- BODY CONTENT -->


<div style="margin:auto;padding:2%;">
<table class="table responsive-table">
<thead class="thead-dark">
<tr>
<th title="Nome do Usuário">Cliente</th>
<th title="Nome de Usuário @">Observação</th>
<th title="Email do Usuário">Arquivo(s)</th>
<th title="Endereço do Usuário">Valor</th>
<th title="Status do Usuário">Dimensões</th>
<th title="Editar Usuário">Produto</th>
<th title="Editar Usuário">Adicionado em</th>
</tr>
</thead>
<tbody>
<?php
foreach($ordersdata as $value){
  $product = $products->filterProductById($value['productid']);
  $file = explode(';',$value['file']);
$file1 = $file[0];
$file2 = end($file);
$orderdate = date("d/m/Y \à\s H:i:s a",strtotime($value['date']));
  print "<tr>";

  print "<td>${value['username']}</td>";
  print "<td>${value['description']}</td>";
  if($product['fv'] === '1'){
  print "<td><a download href='../orders-files/$file1'><i class='material-icons green-text'>download</i> </a>→<a download href='../orders-files/$file2'><i class='material-icons green-text'>download</i> </a></td>";
  }else{
  print "<td><a download href='../orders-files/$file1'><i class='material-icons green-text'>download</i> </a></td>";
  }
  print "<td>${value['value']}</td>";
  print "<td>${value['scalex']} X ${value['scaley']}</td>";
  print "<td>${product['name']}</td>";
  print "<td>$orderdate</td>";

  
}



?>
</tbody>
</table>
<div class="total"></div>
</div>
<!-- BODY CONTENT -->

<?php include_once '../includes/footer.include.php';?>

<script type="text/javascript">

</script>