<?php 
$dashboard_link = "<a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-bs-toggle='dropdown' aria-expanded='false'><i class='bi bi-shield-exclamation'></i> DASHBOARD</a>";

if(isset($_SESSION['useradm']) or isset($_SESSION['usermoderator'])){
  $dashboard = true;
}else{
  $dashboard = false;
};

$username = explode(' ',$_SESSION['userLoggedName']);

function getBrowser()
{
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }

    // Next get the name of the useragent yes seperately and for good reason
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    }
    elseif(preg_match('/Firefox/i',$u_agent))
    {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    }
    elseif(preg_match('/Chrome/i',$u_agent))
    {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    }
    elseif(preg_match('/Safari/i',$u_agent))
    {
        $bname = 'Apple Safari';
        $ub = "Safari";
    }
    elseif(preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Opera';
        $ub = "Opera";
    }
    elseif(preg_match('/Netscape/i',$u_agent))
    {
        $bname = 'Netscape';
        $ub = "Netscape";
    }

    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }

    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else {
            $version= $matches['version'][1];
        }
    }
    else {
        $version= $matches['version'][0];
    }

    // check if we have a number
    if ($version==null || $version=="") {$version="?";}

    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
    );
}

// now try it
$ua=getBrowser();

?>
<nav class="navbar blue darken-4 navbar-expand-lg navbar-dark">
  <div class="container-fluid">
<img class="navbar-brand" width="20%" src="https://industriaimpress.com.br/img/logo/logo_horizontal_sm.png" alt="LOGO_IMPRESS">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="https://industriaimpress.com.br"><i class="bi bi-house-fill"></i> INÍCIO</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="https://industriaimpress.com.br/orders/user/my-orders.php"><i class="bi bi-bag-fill"></i> MEUS PEDIDOS</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="https://industriaimpress.com.br/secure/register/register.php"><i class="bi bi-check-circle-fill"></i> SEJA REVENDEDOR</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-file-person-fill"></i> MINHA CONTA <?php if(isset($_SESSION['userLoggedName'])){echo "(".$username[0].")";}?>
          </a>
          <ul class="dropdown-menu blue lighten-5" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#">Meus Dados</a></li>
            <li><a class="dropdown-item" href="https://industriaimpress.com.br/orders/user/my-orders.php">Meus Pedidos</a></li>
            <li><a class="dropdown-item" href="https://industriaimpress.com.br/about/about-files.php">Fechamento de Arquivo</a></li>
            <li><a class="dropdown-item" href="https://industriaimpress.com.br/about/terms-and-conditions.php">Termos e Condições</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="https://industriaimpress.com.br/secure/login/login.php">Login</a>
            <li><a class="dropdown-item" href="https://industriaimpress.com.br/secure/register/register.php">Cadastre-se</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="https://industriaimpress.com.br/secure/logout.php">Sair</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
        <?php 
        $dashboard_link = "<a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-bs-toggle='dropdown' aria-expanded='false'><i class='bi bi-shield-fill'></i> DASHBOARD</a>";
        if($dashboard === true){
          echo $dashboard_link;
        }
        ?>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="https://industriaimpress.com.br/orders/management/all-orders.php">Gerencia: Pedidos</a></li>
            <li><a class="dropdown-item" href="https://industriaimpress.com.br/products/management/management-products.php">Gerencia: Produtos</a></li>
            <li><a class="dropdown-item" href="https://industriaimpress.com.br/management/searchuser.php">Gerencia: Usuários</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="https://industriaimpress.com.br/management/permissions.php">Gerencia: Administradores</a></li>
          </ul>
        </li>
        <!-- <li class="nav-item">
          <a class="nav-link" aria-current="page" href="https://industriaimpress.com.br/cart/my-cart.php"><i class="bi bi-cart-fill"></i> CARRINHO</a>
        </li> -->
      </ul>
      <form action='https://industriaimpress.com.br/index.php' method="get" class="d-flex">
        <input class="form-control me-2" name="search" id="search" type="search" placeholder="Busca" aria-label="Busca">
        <button class="btn btn-outline-success" placeholder="BUSCAR" value="Buscar" type="submit">Busca</button>
      </form>
    </div>
  </div>
</nav>