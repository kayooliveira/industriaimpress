<?php
session_start();
require '../../classes/autoload.php';

if(!isset($_SESSION['userLogged'])){
    header('location: ../../index.php');
  }
include_once '../../includes/header.include.php';
include_once '../../includes/navbar.include.php';

$userid = $_SESSION['userLoggedId'];

$sanitizestr = new sanitizestr();
$user = new users();
$orders = new orders();
$products = new products();
$ordersdata = $orders->fetchOrders('where userid ='.$userid.' order by date desc');
$userdata = $user->fetchUserById($userid);
$userLoggedName = $_SESSION['userLoggedName'];

date_default_timezone_set('America/Sao_Paulo');

?>

<?php
echo '

<div class="alert alert-success fade show" role="alert">
  <strong>DÍVIDA DE PEDIDOS ANTERIORES : = </strong> R$ '.floatval($userdata['prevdebt']).'
</div>

';?>
<!-- BODY CONTENT -->

<div style="margin:auto;padding:2%;">
<table class="table table-light responsive-table">
<thead class="thead-dark">
<tr>
<th title="Nº do Pedido">Nº Pedido</th>
<th title="Cliente">Cliente</th>
<th title="OBS">Observação</th>
<th title="Arquivos">Arquivo(s)</th>
<th title="Valor">Valor</th>
<th title="Dimensões">Dimensões</th>
<th title="Produto">Produto</th>
<th title="Adicionado em">Adicionado em</th>
<th title="Informações do Usuário"><i class="material-icons">info</i></th>
<th title="Pagamento">Pago</th>
<th title="Status">Status</th>
<th title="Motivo Canc.">Desc. Status</th>
</tr>
</thead>
<tbody>
<?php
foreach($ordersdata as $value){
  $product = $products->filterProductById($value['productid']);
  $file = explode(';',$value['file']);
$file1 = $file[0];
$file2 = end($file);
$orderUserId = $value['userid'];
$userdata = $user->fetchUserById($orderUserId);
$orderUsername = $userdata['fname']." ".$userdata['lname'];

$orderdate = date("d/m/Y \à\s H:i:s a",strtotime($value['date']));
  print "<tr>";

  print "<td>${value['id']}</td>";
  print "<td>$orderUsername</td>";
  print "<td>${value['description']}</td>";
  if($product['fv'] === '1'){
  print "<td><a download href='../orders-files/$file1'><i class='material-icons green-text'>download</i> </a>→<a download href='../orders-files/$file2'><i class='material-icons green-text'>download</i> </a></td>";
  }
  else{
  print "<td><a download href='../orders-files/$file1'><i class='material-icons green-text'>download</i> </a></td>";
  }
  print "<td>${value['value']}</td>";
  print "<td>${value['scalex']} X ${value['scaley']}</td>";
  print "<td>${product['name']}</td>";
  print "<td>$orderdate</td>";
  print "<td>
  <a title='Cancelar pedido!' class='text-center nav-link' href='orderinfo.php''><i class='material-icons align-middle align-center'>info</i></a>

  </td>";

  if($value['pg'] === '1'){
    print "<td class='green lighten-3 '>
  
    <a data-bs-toggle='modal' title='Pagamento!' class='text-center nav-link disabled' href='#!''><i class='material-icons align-middle align-center'>attach_money</i> SIM</a>
    </td>";

  }else{
    print "<td class='red lighten-3 '>
  
    <a data-bs-toggle='modal' data-bs-target='#markpg".$value['id']."'title='Pagamento!' class='text-center disabled nav-link' href='#!''><i class='material-icons align-middle align-center'>money_off</i>NÃO</a>
    </td>"; 
  }

  if($value['status'] === '-1'){
    print "<td class='red '>
    
    <a data-bs-toggle='modal' data-bs-target='#!".$value['id']."'title='Pedido cancelado!' class='text-center disabled nav-link' href='#!''><i class='material-icons align-middle align-center'>block</i></a>
    </td>";
      
  }elseif($value['status'] === '0'){
  print "<td class='yellow '>
  
  <a data-bs-toggle='modal' data-bs-target='#cancelorder".$value['id']."'title='Cancelar pedido!' class='text-center nav-link' href='#!''><i class='material-icons align-middle align-center'>close</i></a>
  </td>";
  echo '<div class="modal fade" id="cancelorder'.$value['id'].'" tabindex="-1" aria-labelledby="cancelorder'.$value['id'].'" aria-hidden="true">
  <form action="cancelorder.php?order_id='.$value['id'].'" method="POST">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
  <h5 class="modal-title" id="labelcancelorder'.$value['id'].'">Cancelar pedido?</h5>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    
    Deseja mesmo cancelar este pedido? Esta ação não pode ser desfeita!<br> ID do pedido: '.$value['id'].'
  </div>
<div class="modal-footer">
  <button type="button" class="btn green btn-secondary" data-bs-dismiss="modal">Fechar</button>
  <button type="submit" class="btn red btn-primary">Sim</button>
</div>
</div>
</div>
  </form>
</div>';

  
  }elseif($value['status'] === '1'){
  print "<td class='orange'>
  
  </td>";
  }elseif($value['status'] === '2'){
    print "<td class='green'>
    
    </td>";
  }elseif($value['status'] === '3'){
    print "<td class='cyan'>
    
    </td>";
  }elseif($value['status'] === '4'){
    print "<td class='grey'>
    
    </td>";
  }elseif($value['status'] === '5'){
    print "<td class='pink '>
    
    </td>";
  }elseif($value['status'] === '6'){
    print "<td class='purple'>
    
    </td>";
  }elseif($value['status'] === '7'){
    print "<td class='grey darken-3'>
    
    </td>";
  }elseif($value['status'] === '8'){
    print "<td class='pink darken-4'>
    
    </td>";
  }
  
  print "<td>${value['cancelmsg']}</td>";
  

$atualValue = floatval($value['value']);
$atualValue = floatval($atualValue);
$alldebt = $alldebt + floatval($atualValue);
if($value["status"] === "-1"){
$totalValue = $totalValue;
}else{
$totalValue = floatval($totalValue) + floatval($atualValue);
}

if($value["pg"] === "1"){
$totalValue = $totalValue - floatval($value['value']);
}

}
?>
</tbody>
</table>
<?php
echo '

<div class="alert alert-success fade show" role="alert">
  <strong>VALOR TOTAL DOS PEDIDOS = </strong> R$ '.floatval($alldebt).'<br>
  <strong>VALOR TOTAL DOS PEDIDOS A RECEBER = </strong> R$ '.floatval($totalValue).'<br>
</div>

';?>
</div>

<table>
<tbody>
<thead>
<tr>
<th title="Nesta fase o cliente ainda pode cancelar!">Fase de Espera</th>
<th>Em análise</th>
<th>Em produção</th>
<th>Acabamento</th>
<th>Enviado</th>
<th>Aguardando Retirada</td>
<th>Finalizado</th>
<th>Pausado</th>
<th>Entregue</th>
<th>Cancelado</th>
</tr>
</thead>
<td class="yellow">Aqui o cliente ainda pode cancelar o pedido</td>
<td class="orange">Pedido em análise</td>
<td class="green">Pedido em produção</td>
<td class="cyan">Pedido em fase de acabamento</td>
<td class="grey">Pedido Enviado</td>
<td class="pink">Pedido aguardando retirada</td>
<td class="purple">Pedido Finalizado</td>
<td class="grey darken-3">Há um pagamento pendente</td>
<td class="pink darken-4">Pedido Entregue</td>
<td class="red">Pedido cancelado</td>
<tbody>
</table>
</tbody>
</table>
<!-- BODY CONTENT -->

<?php include_once '../../includes/footer.include.php';?>

<script type="text/javascript">

</script>