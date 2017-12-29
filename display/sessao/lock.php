<?php
session_start();

require_once ('../Connections/connection.php'); //Connection

$_SESSION['activoFluxo'] = 0;
$idUser = $_SESSION['idUserFluxo'];
$sql = "SElECT usuarioNome, `nome`,`UsuarioApelido`,`usuarioAvatar`,`UsuarioEmail` FROM `tblusuario` WHERE usuarioId = '$idUser'";

$mensagem = '';
$resultUsr = mysqli_query($con, $sql);
$conta = mysqli_num_rows($resultUsr);
$rowUser = mysqli_fetch_assoc($resultUsr);
$usuarioNome = $rowUser['usuarioNome'];
$nome = $rowUser['nome'];
$apelido = $rowUser['UsuarioApelido'];
$avatar = $rowUser['usuarioAvatar'];
$email = $rowUser['UsuarioEmail'];


if(isset($_POST['submit']))
{
	$usuario = $usuarioNome;
	$senha = stripcslashes($_POST['senha']);
	//$activo = $_POST['activo'];
	
	
	$sql="SELECT usuarioId FROM tblusuario WHERE usuarioNome = '$usuario' AND usuarioSenha = md5('$senha')";
	$resultUser = mysqli_query($con, $sql);
	$resultNumber = mysqli_num_rows($resultUser);
	
	if($resultNumber == 0)
	{
		$mensagem =  '<div class="alert alert-danger alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
		Senha errada.
		</div>';
	}
	else
	{
		$_SESSION['activoFluxo'] = 1;
		
		header("location: ../display/index.php");
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>ACSUN</title>
  <meta name="description" content="Admin, Dashboard, Bootstrap, Bootstrap 4, Angular, AngularJS" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimal-ui" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <!-- for ios 7 style, multi-resolution icon of 152x152 -->
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-barstyle" content="black-translucent">
  <link rel="apple-touch-icon" href="../assets/images/logo.png">
  <meta name="apple-mobile-web-app-title" content="Flatkit">
  <!-- for Chrome on Android, multi-resolution icon of 196x196 -->
  <meta name="mobile-web-app-capable" content="yes">
  <link rel="shortcut icon" sizes="196x196" href="../assets/images/logo.png">
  
  <!-- style -->
  <link rel="stylesheet" href="../assets/animate.css/animate.min.css" type="text/css" />
  <link rel="stylesheet" href="../assets/glyphicons/glyphicons.css" type="text/css" />
  <link rel="stylesheet" href="../assets/font-awesome/css/font-awesome.min.css" type="text/css" />
  <link rel="stylesheet" href="../assets/material-design-icons/material-design-icons.css" type="text/css" />

  <link rel="stylesheet" href="../assets/bootstrap/dist/css/bootstrap.min.css" type="text/css" />
  <!-- build:css ../assets/styles/app.min.css -->
  <link rel="stylesheet" href="../assets/styles/app.css" type="text/css" />
  <!-- endbuild -->
  <link rel="stylesheet" href="../assets/styles/font.css" type="text/css" />
  
  <style type="text/css">
	.md-input, .md-input:focus{
		border-color: #b71c1c;
	}
  </style>
</head>
<body>
  <div class="app" id="app">

<!-- ############ LAYOUT START-->
<div class="red-50 h-v row-col">
  <div class="row-cell v-m text-center animated fadeIn">
   <div class="col-md-12 col-xs-12 col-sm-12" style="position: absolute; top:2%;">
	<?=$mensagem?>
 </div>
    <div class="m-b">
      <img src="../assets/images/usuarios/<?=$avatar?>" class="w-64 circle">
      <div class="m-t-md font-bold"><?=$nome ." ". $apelido?></div>
    </div>
    <div class="md-form-group w-xl w-auto-xs center-block">
	<form action="lock.php" method="post" id="abrir" >
    	<input type="password" class="md-input text-center" name="senha" autofocus />
    	<label class="block w-full text-blue">Escreva tua Senha</label>
	</form>
    </div>
    <div class="m-t">
    	<button form="abrir" name="submit" type="submit" class="btn btn-danger p-x-md">Entrar</button>
	</div>
  </div>
</div>

<!-- ############ LAYOUT END-->

  </div>
<!-- build:js scripts/app.html.js -->
<!-- jQuery -->
  <script src="../libs/jquery/jquery/dist/jquery.js"></script>
<!-- Bootstrap -->
  <script src="../libs/jquery/tether/dist/js/tether.min.js"></script>
  <script src="../libs/jquery/bootstrap/dist/js/bootstrap.js"></script>
<!-- core -->
  <script src="../libs/jquery/underscore/underscore-min.js"></script>
  <script src="../libs/jquery/jQuery-Storage-API/jquery.storageapi.min.js"></script>
  <script src="../libs/jquery/PACE/pace.min.js"></script>

  <script src="scripts/config.lazyload.js"></script>

  <script src="scripts/palette.js"></script>
  <script src="scripts/ui-load.js"></script>
  <script src="scripts/ui-jp.js"></script>
  <script src="scripts/ui-include.js"></script>
  <script src="scripts/ui-device.js"></script>
  <script src="scripts/ui-form.js"></script>
  <script src="scripts/ui-nav.js"></script>
  <script src="scripts/ui-screenfull.js"></script>
  <script src="scripts/ui-scroll-to.js"></script>
  <script src="scripts/ui-toggle-class.js"></script>

  <script src="scripts/app.js"></script>

  <!-- ajax -->
  <script src="../libs/jquery/jquery-pjax/jquery.pjax.js"></script>
  <script src="scripts/ajax.js"></script>
<!-- endbuild -->
</body>
</html>
