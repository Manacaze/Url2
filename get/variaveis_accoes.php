<?php
//Inicio de Sessao
	session_start();
	
//Adicionado Todos Metodos
	
	
	$idUser = $_SESSION['frl_idUser'];
	//$activo = $_SESSION['activoFluxo'];
	$sql = "SElECT usuarioNome, usuNivelAcesso, `nome`,`UsuarioApelido`,`usuarioAvatar`,`UsuarioEmail`,`UsuarioSexo`, `provincia`, `distrito`, 'zona', `circulo` FROM `frl_usuario` WHERE usuarioId = '$idUser'";
	$resultUsr = mysqli_query($con, $sql);

	$sqlUsuario = '';
	$conta = mysqli_num_rows($resultUsr);
	$rowUser = mysqli_fetch_assoc($resultUsr);
	$usuarioNome = $rowUser['usuarioNome'];
    $_SESSION['us'] = $usuarioNome;
	$nivelAcesso = $rowUser['usuNivelAcesso'];
	$nome = $rowUser['nome'];
	$apelido = $rowUser['UsuarioApelido'];
	$avatar = $rowUser['usuarioAvatar'];
	$email = $rowUser['UsuarioEmail'];
	$usuSexo = $rowUser['UsuarioSexo'];
	$usu_provincia = $rowUser['provincia'];
    $usu_distrito = $rowUser['distrito'];
    $usu_zona = $rowUser['zona'];
    $usu_circulo = $rowUser['circulo'];
    $sqlplus = "";
	
	//Variavel que ira desabilitar Botoes caso seja o usuario normal
	$disableButons = '';
	//Atibuindo a Variavel Sexo
	if($usuSexo == "M")
		$sexoU = "Masculino";
	else if($usuSexo == "F")
		$sexoU = "Femenino";
	
	//Variavel com o Tipo de Funcionario
	if($nivelAcesso == 0)
		 $nivelU = "Administrador";
	 else if($nivelAcesso == 1)
	 {
		 $nivelU = "Operador";
		 $sqlUsuario = "WHERE `usuNivelAcesso` != 0";
	 }
	 else if($nivelAcesso == 2)
	 {
		 $disableButons = "disabled"; //Desabilitando Butoes
		 $nivelU = "Usuario Normal";
	 }
?>