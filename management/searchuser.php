<?php
session_start();


if(!isset($_SESSION['useradm']) || !isset($_SESSION['usermoderator'])){
  header('location: ../index.php');
}
require_once '../classes/autoload.php';
include_once '../includes/header.include.php';
include_once '../includes/navbar.include.php';
$sanitizeString = new sanitizestr();
if(isset($_GET['search'])){
  $search = $_GET['search'];
  $search = $sanitizeString->sanitizeString($search);
}else{
  $search = " ";
  $search = $sanitizeString->sanitizeString($search);
}

if(isset($_GET['filter'])){
  $filter = $_GET['filter'];
}else{
  $filter = "CONCAT(fname, ' ', lname,' ') like '%$search%' or fname like '%$search%' or lname ";
}

if(isset($_GET['limit'])){
  $limit = $_GET['limit'];
}else{
  $limit = "";
}

$users = new users();
$fetchUsers = $users->fetchUsers($filter, $search, $limit);
?>

<!-- BODY CONTENT -->
<div style="padding:5%;" class="container blue lighten-2">
<form action="searchuser.php" method="get">
<div class="input-group">
  <div class="form-outline  col-lg-11">
    <input style="height:80px;" id="search" name="search"  type="search" required placeholder="Buscar Usuários:" class="form-control"/>
  </div>
  <button type="submit" class="btn-lg col-lg-1 btn-primary ">
    <i class="bi bi-search"></i>
  </button>
  
</div>
</form>
</div>
<div style="margin:auto;padding:2%;">
  <?php echo "<p style='text-transform:uppercase' class='red-text center'>"."Todos os resultados com a busca: "."<strong style='text-decoration:underline;' class='green-text'>\"$search\"</strong>"."</p>"?>
<table class="table table-light responsive-table">
<thead class="thead-dark">
<tr>
<th title="ID de Usuário">ID</th>
<th title="Nome do Usuário">Nome</th>
<th title="Nome de Usuário @">Username</th>
<th title="Email do Usuário">E-mail</th>
<th title="Contato do Usuário">Contato</th>
<th title="Endereço do Usuário">Endereço</th>
<th title="Data de Cadastro do Usuário">Data de Cad.</th>
<th title="Informações do Usuário"><i class="material-icons">info</i></th>
<th title="Status do Usuário">Status</th>
<th title="Editar Usuário">Editar</th>
<th title="Deletar Usuário">Deletar</th>
</tr>
</thead>
<tbody>
<?php
foreach($fetchUsers as $value){
  print "<tr>";
  print "<td>${value['id']}</td>";
  print "<td>${value['fname']} ${value['lname']}</td>";
  print "<td>${value['username']}</td>";
  print "<td>${value['email']}</td>";
  print "<td>${value['contact']}</td>";
  print "<td>${value['address']}</td>";
  if($value['permissions'] === 'all'){
    $userStatus = "<span><a class='nav-link disabled' href='#!'><i class='material-icons '>shield</i></a></span>";
  }elseif($value['status'] === '0'){
    $userStatus = "<span><a class='nav-link' href='updateuserstatus.php?id=${value['id']}&status=${value['status']}'><i class='material-icons'>dangerous</i></a></span>";
  }elseif($value['status'] === '1'){
    $userStatus = "<span><a class='nav-link'  href='updateuserstatus.php?id=${value['id']}&status=${value['status']}'><i class='material-icons'>check_circle</i></a></span>";
  }
  print "<td>${value['caddate']}</td>";
  print "<td><a class='nav-link' href='userinfo.php?id=${value['id']}'><i title='Informações do Usuário ${value['id']}' class='material-icons'>info</i></a></td>";
  print "<td><span id='statusUser${value['username']}'>$userStatus</span></td>";
  if($value['permissions'] === 'all'){
    print "<td><a  class='nav-link disabled' href='#!'><i class='material-icons red-text center'>shield</i></a></td>";
      print "<td><a class='nav-link disabled' href='#!'><i class='material-icons red-text center'>shield</i></a></td>";
  }else{
    print "<td><a class='nav-link' href='managementuser.php?id=${value['id']}'><i class='material-icons red-text center'>edit</i></a></td>";
    print "<td><a class='nav-link ' href='#confirmation${value['id']}'><i class='material-icons red-text center'>delete</i></a></td>";
      
  }
  print "</tr>";
}
?>
</tbody>
</table>
</div>


<!-- BODY CONTENT -->

<?php include_once '../includes/footer.include.php'?>
<!-- SCRIPTS CONTENT -->
<!-- SCRIPTS CONTENT -->
