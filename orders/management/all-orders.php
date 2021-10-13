<?php
session_start();
require '../../classes/autoload.php';

$sanitizestr = new sanitizestr();
$user = new users();
$orders = new orders();
$products = new products();
if(!isset($_SESSION['useradm'])){
    header('location: ../../index.php');
}

$total_reg = 20; 


$pagina = ""; 
$filteruser = "";
$filteruserName = "";


if(isset($_GET['pagina'])){
  $pagina = $_GET['pagina'];
}
if(isset($_GET['last'])){
  $total_reg = $_GET['last'];
}
if(isset($_GET['filteruser'])){
  $filteruserName = $_GET['filteruser'];
  $arrayfiltereduser = explode('_',$filteruserName);
  $filteruserfname = $arrayfiltereduser[0];
  $filteruserlname = end($arrayfiltereduser);
  $fetchfiltereduser = $user->fetchUserByName("where fname='$filteruserfname' and lname='$filteruserlname' ");
  $filteruserdebt = $fetchfiltereduser['debt'];
  $filteruserprevdebt = $fetchfiltereduser['prevdebt'];
  if($filteruserName === "all"){
    $filteruser = "";
    $filteruserall = "all";
  }else{
    $filteruserid = $fetchfiltereduser['id'];
    $filteruser = "and userid = $filteruserid";
    
  }
}else{
    $filteruserName= "all";
}

if (!$pagina) {
$pc = 1;
} else {
$pc = $pagina;
}

$inicio = $pc - 1;
$inicio = $inicio * $total_reg;



$totalValue = 0;
$alldebt = 0;
$userid = $_SESSION['userLoggedId'];
$ordersdata = $orders->fetchOrders("where incart='0' $filteruser order by date desc LIMIT $inicio,$total_reg");
$allorders = $orders->fetchAllOrders();
$userdata = $user->fetchUserById($userid);
$userLoggedName = $_SESSION['userLoggedName'];
$allUsers = $user->fetchAllUsers();



$tp = $allorders / $total_reg; 

date_default_timezone_set('America/Sao_Paulo');
include_once '../../includes/header.include.php';
include_once '../../includes/navbar.include.php';

?>

<!-- BODY CONTENT -->


<?php if(isset($_SESSION['nopermissions'])){
  echo $_SESSION['nopermissions']; 
  unset($_SESSION['nopermissions']);
}

echo '

<div class="alert alert-success fade show" role="alert">
  <strong>Exibindo os últimos ['.$total_reg.'] pedidos de ['.$filteruserName.'] na página '.$pagina.'</strong> 
</div>

';
?>
<form action="all-orders.php" method="GET">
    <div class="row pd-2">
  <div class="form-group col-2">
      <input type="text" readonly class=" form-control-plaintext" id="staticEmail" value="Filtar por usuário:">
    </div>
  <div class="form-group col-3">
  <select class="blue lighten-3 form-control" name="filteruser" id="filteruser"> 
<?php

print "<option value='all' class='blue lighten-3'>TODOS</option>";
foreach($allUsers as $allusersvalue){
  $userName  = $allusersvalue['fname']." ".$allusersvalue['lname'];
  $userName2  = $allusersvalue['fname']."_".$allusersvalue['lname'];
if($filteruserName === $userName2){
  print "<option value='$userName2' class='blue lighten-3' selected>$userName</option>";

}else{
  print "<option value='$userName2' class='blue lighten-3' >$userName</option>";
}



}

?>
  </select> 
</div>

<div class="form-group col-2">
      <input type="text" readonly class=" form-control-plaintext" id="staticEmail" value="Número de Registros:">
    </div>
<div class="form-group col-3">
  <select class="blue lighten-3 form-control" name="last" id="last"> 
  <option value="5" >5 registros</option>
  <option value="10" >10 registros</option>
  <option value="20" selected>20 registros</option>
  <option value="30" >30 registros</option>
  <option value="40" >40 registros</option>
  <option value="50" >50 registros</option>
  </select> 
</div>



    
<div class="form-group col">
    <button type="submit" value="filtrar" class="btn btn-success">Filtrar</button>
</div>
</div>
  </form>
<div class="form-group">
      <a class='btn red lighten-3'  href="#!" id="canceled-orders">▬▬ER▬O</a>
      <a class='btn red lighten-3'  href="#!" id="canceled-orders">▬▬ER▬O</a>
    </div>

<table class="table indigo lighten-4 responsive-table">
<thead>
<tr>
<th title="Nº do pedido">Nº Pedido</th>
<th title="Nome do cliente">Cliente</th>
<th title="Descição do pedido">Desc. Pedido</th>
<th title="Observação de produção">OBS Prod.</th>
<th title="Quantidade">Qnt. Prod.</th>
<th title="Arquivos">Arquivo(s)</th>
<th title="Valor">Valor</th>
<th title="Dimensoes">Dimensões</th>
<th title="Produto">Produto</th>
<th title="Adicionado em">Adicionado em</th>
<th title="Pago">PG</th>
<th title="Informações"><i class="material-icons">info</i></th>
<th title="Status">Status</th>
</tr>
</thead>
<tbody>
<?php
foreach($ordersdata as $value){
    if($value['status'] === '-1'){continue 1;};
  $product = $products->filterProductById($value['productid']);
  $file = explode(';',$value['file']);
$file1 = $file[0];
$file2 = end($file);
$orderdate = date("d/m/Y \à\s H:i:s a",strtotime($value['date']));
$orderUserId = $value['userid'];
$userdata = $user->fetchUserById($orderUserId);
$orderUsername = $userdata['fname']." ".$userdata['lname'];
$orderdate = date("d/m/Y \à\s H:i:s a",strtotime($value['date']));
  print "<tr style='border-left: 20px solid blue;'>";

  print "<td>${value['id']}</td>";
  print "<td>$orderUsername</td>";
  print "<td>${value['description']}</td>";
  print "<td>▬E▬▬▬▬▬o▬</td>";
  print "<td>${value['qnt']}</td>";
  if($product['fv'] === '1'){
  print "<td><a onclick='manutencao()' href='#!'><i class='material-icons green-text'>download</i> </a>→<a download href='../orders-files/$file2'><i class='material-icons green-text'>download</i> </a></td>";
  }else{
  print "<td><a onclick='manutencao()' href='#!'><i class='material-icons green-text'>download</i> </a></td>";
  }
  print "<td>${value['value']}</td>";
  print "<td>${value['scalex']} X ${value['scaley']}</td>";
  print "<td>${product['name']}</td>";
  print "<td>ERRO▬▬▬</td>";
  if($value['pg'] === '1'){
    print "<td class='green lighten-3 '>
  
    <a data-bs-toggle='modal' title='Pagamento!' class='text-center nav-link disabled' href='#!''><i class='material-icons align-middle align-center'>attach_money</i> SIM</a>
    </td>";

  }else{
    print "<td class='red lighten-3 '>
  
    <a data-bs-toggle='modal' data-bs-target='#markpg".$value['id']."'title='Pagamento!' class='text-center nav-link' href='#!''><i class='material-icons align-middle align-center'>money_off</i>NÃO</a>
    </td>";
    echo '<div class="modal fade" id="markpg'.$value['id'].'" tabindex="-1" aria-labelledby="markpg'.$value['id'].'" aria-hidden="true">
    <form action="alterpaymentstatus.php?order_id='.$value['id'].'" method="POST">
  <div class="modal-dialog">
  <div class="modal-content">
  <div class="modal-header">
    <h5 class="modal-title" id="labelcancelorder'.$value['id'].'">Alterar Status do pedido?</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  </div>
  <div class="modal-body">
      Deseja mesmo marcar como pago este pedido? Você não poderá alterar isto novamente<br> ID do pedido: '.$value['id'].'
    </div>
  <div class="modal-footer">
         <button type="button" class="btn red btn-secondary" data-bs-dismiss="modal">Fechar</button>
     <button type="submit" class="btn green btn-primary">Sim</button>
  </div>
  </div>
  </div>
    </form>
  </div>'; 
  }

  print "<td>

  <a title='Informacoes do pedido!' class='nav-link' href='orderinfo.php''><i class='material-icons'>info</i></a>
  </td>"; 

  if($value['status'] === '-1'){
    print "<td class='red '>
    
    <a data-bs-toggle='modal' data-bs-target='#!".$value['id']."'title='Motivo: ".$value['cancelmsg']."' class='text-center  nav-link' href='#!''><i class='material-icons align-middle align-center'>block</i></a>
    </td>";
      
  }elseif($value['status'] === '0'){
  print "<td class='yellow '>
  
  <a data-bs-toggle='modal' data-bs-target='#alterstatus".$value['id']."'title='Cancelar pedido!' class='text-center nav-link' href='#!''><i class='material-icons align-middle align-center'>edit</i></a>
  </td>";
  echo '<div class="modal fade" id="alterstatus'.$value['id'].'" tabindex="-1" aria-labelledby="alterstatus'.$value['id'].'" aria-hidden="true">
  <form action="alterstatus.php?order_id='.$value['id'].'" method="POST">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
  <h5 class="modal-title" id="labelcancelorder'.$value['id'].'">Alterar Status do pedido?</h5>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    
  <div class="form-group col-3">
  <label for="category">Status Pedido Nº: '.$value["id"].'</label>
  <select class="form-control" name="status" id="status"> 
      <option value="-1" >Cancelado</option>
      <option value="0" selected>Espera</option>
      <option value="1">Em análise</option>
      <option value="2">Em produção</option>
      <option value="3">Acabamento</option>
      <option value="4">Enviado</option>
      <option value="5">Aguardando Retirada</option>
      <option value="6">Finalizado</option>
      <option value="7">Pausado (Pagamentos Pendentes)</option>
      <option value="8">Entregue</option>
  </select> 
</div>
      <div class="md-form">
  <textarea id="cancelmessage" name="cancelmessage" class="md-textarea form-control" rows="3"></textarea>
  <label for="cancelmessage">MENSAGEM DE CANCELAMENTO</label>
</div>
  </div>
<div class="modal-footer">
       <button type="button" class="btn red btn-secondary" data-bs-dismiss="modal">Fechar</button>
  <button type="submit" class="btn green btn-primary">Sim</button>
</div>
</div>
</div>
  </form>
</div>';
  }elseif($value['status'] === '1'){
  print "<td class='orange'>
  
  <a data-bs-toggle='modal' data-bs-target='#alterstatus".$value['id']."'title='Cancelar pedido!' class='text-center nav-link' href='#!''><i class='material-icons align-middle align-center'>edit</i></a>
  </td>";
  echo '<div class="modal fade" id="alterstatus'.$value['id'].'" tabindex="-1" aria-labelledby="alterstatus'.$value['id'].'" aria-hidden="true">
  <form action="alterstatus.php?order_id='.$value['id'].'" method="POST">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
  <h5 class="modal-title" id="labelcancelorder'.$value['id'].'">Alterar Status do pedido?</h5>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    
  <div class="form-group col-3">
  <label for="category">Status Pedido Nº: '.$value["id"].'</label>
  <select class="form-control" name="status" id="status"> 
      <option value="-1" >Cancelado</option>
      <option value="0" selected>Espera</option>
      <option value="1">Em análise</option>
      <option value="2">Em produção</option>
      <option value="3">Acabamento</option>
      <option value="4">Enviado</option>
      <option value="5">Aguardando Retirada</option>
      <option value="6">Finalizado</option>
      <option value="7">Pausado (Pagamentos Pendentes)</option>
      <option value="8">Entregue</option>
  </select> 
</div>
      <div class="md-form">
  <textarea id="cancelmessage" class="md-textarea form-control" rows="3"></textarea>
  <label for="cancelmessage">MENSAGEM DE CANCELAMENTO</label>
</div>
  </div>
<div class="modal-footer">
       <button type="button" class="btn red btn-secondary" data-bs-dismiss="modal">Fechar</button>
  <button type="submit" class="btn green btn-primary">Sim</button>
</div>
</div>
</div>
  </form>
</div>';
  }elseif($value['status'] === '2'){
    print "<td class='green'>
  
    <a data-bs-toggle='modal' data-bs-target='#alterstatus".$value['id']."'title='Cancelar pedido!' class='text-center nav-link' href='#!''><i class='material-icons align-middle align-center'>edit</i></a>
    </td>";
    echo '<div class="modal fade" id="alterstatus'.$value['id'].'" tabindex="-1" aria-labelledby="alterstatus'.$value['id'].'" aria-hidden="true">
    <form action="alterstatus.php?order_id='.$value['id'].'" method="POST">
  <div class="modal-dialog">
  <div class="modal-content">
  <div class="modal-header">
    <h5 class="modal-title" id="labelcancelorder'.$value['id'].'">Alterar Status do pedido?</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  </div>
  <div class="modal-body">
      
    <div class="form-group col-3">
    <label for="category">Status Pedido Nº: '.$value["id"].'</label>
    <select class="form-control" name="status" id="status"> 
        <option value="-1" >Cancelado</option>
        <option value="0" selected>Espera</option>
        <option value="1">Em análise</option>
        <option value="2">Em produção</option>
        <option value="3">Acabamento</option>
        <option value="4">Enviado</option>
        <option value="5">Aguardando Retirada</option>
        <option value="6">Finalizado</option>
        <option value="7">Pausado (Pagamentos Pendentes)</option>
        <option value="8">Entregue</option>
    </select>
    

  </div>
       <div class="md-form">
  <textarea id="cancelmessage" class="md-textarea form-control" rows="3"></textarea>
  <label for="cancelmessage">MENSAGEM DE CANCELAMENTO</label>
</div> 
    </div>
  <div class="modal-footer">
         <button type="button" class="btn red btn-secondary" data-bs-dismiss="modal">Fechar</button>
     <button type="submit" class="btn green btn-primary">Sim</button>
  </div>
  </div>
  </div>
    </form>
  </div>';
  }elseif($value['status'] === '3'){
    print "<td class='cyan'>
  
    <a data-bs-toggle='modal' data-bs-target='#alterstatus".$value['id']."'title='Cancelar pedido!' class='text-center nav-link' href='#!''><i class='material-icons align-middle align-center'>edit</i></a>
    </td>";
    echo '<div class="modal fade" id="alterstatus'.$value['id'].'" tabindex="-1" aria-labelledby="alterstatus'.$value['id'].'" aria-hidden="true">
    <form action="alterstatus.php?order_id='.$value['id'].'" method="POST">
  <div class="modal-dialog">
  <div class="modal-content">
  <div class="modal-header">
    <h5 class="modal-title" id="labelcancelorder'.$value['id'].'">Alterar Status do pedido?</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  </div>
  <div class="modal-body">
      
    <div class="form-group col-3">
    <label for="category">Status Pedido Nº: '.$value["id"].'</label>
    <select class="form-control" name="status" id="status"> 
        <option value="-1" >Cancelado</option>
        <option value="0" selected>Espera</option>
        <option value="1">Em análise</option>
        <option value="2">Em produção</option>
        <option value="3">Acabamento</option>
        <option value="4">Enviado</option>
        <option value="5">Aguardando Retirada</option>
        <option value="6">Finalizado</option>
        <option value="7">Pausado (Pagamentos Pendentes)</option>
        <option value="8">Entregue</option>
    </select>

  </div>
        <div class="md-form">
  <textarea id="cancelmessage" class="md-textarea form-control" rows="3"></textarea>
  <label for="cancelmessage">MENSAGEM DE CANCELAMENTO</label>
</div>
    </div>
  <div class="modal-footer">
         <button type="button" class="btn red btn-secondary" data-bs-dismiss="modal">Fechar</button>
     <button type="submit" class="btn green btn-primary">Sim</button>
  </div>
  </div>
  </div>
    </form>
  </div>';
  }elseif($value['status'] === '4'){
    print "<td class='grey'>
  
    <a data-bs-toggle='modal' data-bs-target='#alterstatus".$value['id']."'title='Cancelar pedido!' class='text-center nav-link' href='#!''><i class='material-icons align-middle align-center'>edit</i></a>
    </td>";
    echo '<div class="modal fade" id="alterstatus'.$value['id'].'" tabindex="-1" aria-labelledby="alterstatus'.$value['id'].'" aria-hidden="true">
    <form action="alterstatus.php?order_id='.$value['id'].'" method="POST">
  <div class="modal-dialog">
  <div class="modal-content">
  <div class="modal-header">
    <h5 class="modal-title" id="labelcancelorder'.$value['id'].'">Alterar Status do pedido?</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  </div>
  <div class="modal-body">
      
    <div class="form-group col-3">
    <label for="category">Status Pedido Nº: '.$value["id"].'</label>
    <select class="form-control" name="status" id="status"> 
        <option value="-1" >Cancelado</option>
        <option value="0" selected>Espera</option>
        <option value="1">Em análise</option>
        <option value="2">Em produção</option>
        <option value="3">Acabamento</option>
        <option value="4">Enviado</option>
        <option value="5">Aguardando Retirada</option>
        <option value="6">Finalizado</option>
        <option value="7">Pausado (Pagamentos Pendentes)</option>
        <option value="8">Entregue</option>
    </select>
  </div>
  
  <div class="md-form">
  <textarea id="cancelmessage" class="md-textarea form-control" rows="3"></textarea>
  <label for="cancelmessage">MENSAGEM DE CANCELAMENTO</label>
</div>
      
    </div>
  <div class="modal-footer">
         <button type="button" class="btn red btn-secondary" data-bs-dismiss="modal">Fechar</button>
     <button type="submit" class="btn green btn-primary">Sim</button>
  </div>
  </div>
  </div>
    </form>
  </div>';
  }elseif($value['status'] === '5'){
    print "<td class='pink'>
  
    <a data-bs-toggle='modal' data-bs-target='#alterstatus".$value['id']."'title='Cancelar pedido!' class='text-center nav-link' href='#!''><i class='material-icons align-middle align-center'>edit</i></a>
    </td>";
    echo '<div class="modal fade" id="alterstatus'.$value['id'].'" tabindex="-1" aria-labelledby="alterstatus'.$value['id'].'" aria-hidden="true">
    <form action="alterstatus.php?order_id='.$value['id'].'" method="POST">
  <div class="modal-dialog">
  <div class="modal-content">
  <div class="modal-header">
    <h5 class="modal-title" id="labelcancelorder'.$value['id'].'">Alterar Status do pedido?</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  </div>
  <div class="modal-body">
      
    <div class="form-group col-3">
    <label for="category">Status Pedido Nº: '.$value["id"].'</label>
    <select class="form-control" name="status" id="status"> 
        <option value="-1" >Cancelado</option>
        <option value="0" selected>Espera</option>
        <option value="1">Em análise</option>
        <option value="2">Em produção</option>
        <option value="3">Acabamento</option>
        <option value="4">Enviado</option>
        <option value="5">Aguardando Retirada</option>
        <option value="6">Finalizado</option>
        <option value="7">Pausado (Pagamentos Pendentes)</option>
        <option value="8">Entregue</option>
    </select> 
  </div>
        <div class="md-form">
  <textarea id="cancelmessage" class="md-textarea form-control" rows="3"></textarea>
  <label for="cancelmessage">MENSAGEM DE CANCELAMENTO</label>
</div>
    </div>
  <div class="modal-footer">
         <button type="button" class="btn red btn-secondary" data-bs-dismiss="modal">Fechar</button>
     <button type="submit" class="btn green btn-primary">Sim</button>
  </div>
  </div>
  </div>
    </form>
  </div>';
  }elseif($value['status'] === '6'){
    print "<td class='purple'>
  
    <a data-bs-toggle='modal' data-bs-target='#alterstatus".$value['id']."'title='Cancelar pedido!' class='text-center nav-link' href='#!''><i class='material-icons align-middle align-center'>edit</i></a>
    </td>";
    echo '<div class="modal fade" id="alterstatus'.$value['id'].'" tabindex="-1" aria-labelledby="alterstatus'.$value['id'].'" aria-hidden="true">
    <form action="alterstatus.php?order_id='.$value['id'].'" method="POST">
  <div class="modal-dialog">
  <div class="modal-content">
  <div class="modal-header">
    <h5 class="modal-title" id="labelcancelorder'.$value['id'].'">Alterar Status do pedido?</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  </div>
  <div class="modal-body">
      
    <div class="form-group col-3">
    <label for="category">Status Pedido Nº: '.$value["id"].'</label>
    <select class="form-control" name="status" id="status"> 
        <option value="-1" >Cancelado</option>
        <option value="0" selected>Espera</option>
        <option value="1">Em análise</option>
        <option value="2">Em produção</option>
        <option value="3">Acabamento</option>
        <option value="4">Enviado</option>
        <option value="5">Aguardando Retirada</option>
        <option value="6">Finalizado</option>
        <option value="7">Pausado (Pagamentos Pendentes)</option>
        <option value="8">Entregue</option>
    </select> 
  </div>
        <div class="md-form">
  <textarea id="cancelmessage" class="md-textarea form-control" rows="3"></textarea>
  <label for="cancelmessage">MENSAGEM DE CANCELAMENTO</label>
</div>
    </div>
  <div class="modal-footer">
         <button type="button" class="btn red btn-secondary" data-bs-dismiss="modal">Fechar</button>
     <button type="submit" class="btn green btn-primary">Sim</button>
  </div>
  </div>
  </div>
    </form>
  </div>';
}elseif($value['status'] === '7'){
  print "<td class='grey darken-3'>

  <a data-bs-toggle='modal' data-bs-target='#alterstatus".$value['id']."'title='Cancelar pedido!' class='text-center nav-link' href='#!''><i class='material-icons align-middle align-center'>edit</i></a>
  </td>";
  echo '<div class="modal fade" id="alterstatus'.$value['id'].'" tabindex="-1" aria-labelledby="alterstatus'.$value['id'].'" aria-hidden="true">
  <form action="alterstatus.php?order_id='.$value['id'].'" method="POST">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
  <h5 class="modal-title" id="labelcancelorder'.$value['id'].'">Alterar Status do pedido?</h5>
  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>




<div class="modal-body">
  <div class="form-group col-3">
  <label for="category">Status Pedido Nº: '.$value["id"].'</label>
  <select class="form-control" name="status" id="status"> 
      <option value="-1" >Cancelado</option>
      <option value="0" selected>Espera</option>
      <option value="1">Em análise</option>
      <option value="2">Em produção</option>
      <option value="3">Acabamento</option>
      <option value="4">Enviado</option>
      <option value="5">Aguardando Retirada</option>
      <option value="6">Finalizado</option>
      <option value="7">Pausado (Pagamentos Pendentes)</option>
      <option value="8">Entregue</option>
  </select> 
</div>
      <div class="md-form">
  <textarea id="cancelmessage" class="md-textarea form-control" rows="3"></textarea>
  <label for="cancelmessage">MENSAGEM DE CANCELAMENTO</label>
</div>
  </div>
<div class="modal-footer">
       <button type="button" class="btn red btn-secondary" data-bs-dismiss="modal">Fechar</button>
  <button type="submit" class="btn green btn-primary">Sim</button>
</div>
</div>
</div>
  </form>
</div>';
}elseif($value['status'] === '8'){
  print "<td class='pink darken-4'>

  <a data-bs-toggle='modal' data-bs-target='#alterstatus".$value['id']."'title='Cancelar pedido!' class='text-center nav-link disabled' href='#!''><i class='material-icons align-middle align-center'>edit</i></a>
  </td>";
}

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
if(isset($_GET['filteruser'])){
    echo '
    
<div class="alert alert-danger fade show" role="alert">
  <strong>DÉBITO ATUAL DO USUÁRIO ['.$fetchfiltereduser['fname'].'] (pedidos entregues) = </strong> R$ '.floatval($filteruserdebt).'<br>
  <strong>DÉBITO ANTERIOR ['.$fetchfiltereduser['fname'].'] = </strong> R$ '.floatval($filteruserprevdebt).'<br>
  
</div>';
}
echo '

<div class="alert alert-success fade show" role="alert">
  <strong>VALOR TOTAL DOS PEDIDOS = </strong> R$ '.floatval($alldebt).'<br>
  <strong>VALOR TOTAL DOS PEDIDOS A RECEBER = </strong> R$ '.floatval($totalValue).'<br>
  
</div>

';?>
<div style="align-items:center;text-align:center;align-self:center;margin-bottom:1%" class="container">

<?php


$anterior = $pc -1;
$proximo = $pc +1;
if ($pc>1) {
  if(isset($filteruserall)){
echo " <a class='btn red' href='all-orders.php?pagina=$anterior&last=$total_reg&filteruser=".$filteruserall."'><- Anterior</a> ";

  }else{
echo " <a class='btn red' href='all-orders.php?pagina=$anterior&last=$total_reg&filteruser=".$filteruserName."'><- Anterior</a> ";
  }
}else{
  echo " <a class='btn grey' href=#!'><- Anterior</a> ";
  }
if ($pc<$tp) {
  if(isset($filteruserall)){
echo " <a class='btn green darken-2' href='all-orders.php?pagina=$proximo&last=$total_reg&filteruser=".$filteruserall."'>Próxima -></a>";

  }else{
echo " <a class='btn green darken-2' href='all-orders.php?pagina=$proximo&last=$total_reg&filteruser=".$filteruserName."'>Próxima -></a>";
  }
}else {
  echo " <a class='btn grey' href='#!'>Próxima -></a>";
  }

echo '</div>';

?>
<table>adi
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
<tbody>
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
</tbody>
</table>
<!-- BODY CONTENT -->

<?php include_once '../../includes/footer.include.php';?>

<script src="../../js/jquery/jquery.min.js"></script>

<script>
$(document).ready(function(){
  
  $('div.md-form').hide(); 
	$("select").change(function(){
		var myvalue = $(this).val();
		if(myvalue === '-1'){
  $('div.md-form').show(); 

    }else{
  $('div.md-form').hide(); 

    };
	});
});

function manutencao(){
    alertify.alert('ALERTA!','MANUTENÇÃO NO BANCO DE DADOS REQUERIDA, POR FAVOR CONTATAR O ADMINISTRADOR DO SITE.');
}
</script>