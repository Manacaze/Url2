<?php
	$nome_documento =" ";
	$nr_doc = " ";
?>
<?php
		include_once("../../Connections/connection.php");
		include_once("../../get/variaveis_accoes.php");
	if(isset($_POST["id_provincia"])){
		$estamos_na_pesquisar_militancia = 0;
		if(isset($_POST['onde_pesquisamos'])){
			if($_POST['onde_pesquisamos'] == 'militancia'){
				$estamos_na_pesquisar_militancia = 1;
			}
			
		}
		
		
		

		$id_provincia = $_POST["id_provincia"];
		$geral = "todos distritos";
?>
	<option value="0"></option>
<?php		
		if($id_provincia != 0){
			$sql = "SELECT*FROM sms_distritos WHERE cod_provincia = '$id_provincia'";
			
		}else{
			$sql = "SELECT*FROM sms_distritos";
?>
		<option value="0">Todos distritos</option>
<?php	
			
		}	
		
		$dados_distr = mysqli_query($con, $sql);

		
	
		  while($dados_distritos = mysqli_fetch_assoc($dados_distr)){
				$id_distrito = $dados_distritos['sms_dis_id'];
				$nome_distrito = $dados_distritos['distrito'];
		    					

		    		 if(($nivelAcesso == 3 && $usu_distrito == $id_distrito || $nivelAcesso == 4 && $usu_distrito == $id_distrito) && $estamos_na_pesquisar_militancia == 1) {// se for registrador so pode registrar membros da sua provincia, se for um supervisor a nivel Distrital so mostra a sua provincia	
		
?>
				<option value="<?=$id_distrito ?>"><?=$nome_distrito?>s</option>	

		    				
<?php		
					break;
					}else{
				
						
?>
					<option value="<?=$id_distrito ?>"><?=$nome_distrito?>s</option>
<?php
					
					}	
		}  		
	}	
?>


<?php
	if(isset($_POST["id_distrito"])){
		$id_distrito = $_POST["id_distrito"];
	

?>
		<option value="0"></option>
<?php

		if($id_distrito != 0){
			$sql = "SELECT*FROM sms_postos_administrativos WHERE cod_distrito = '$id_distrito'";
			$geral = '';

		}else{
			$sql = "SELECT*FROM sms_postos_administrativos";
?>
			<option value="0">Todos Distritos</option>
<?php

		}


		$dados_post= mysqli_query($con, $sql);

		  while($dados_posto = mysqli_fetch_assoc($dados_post)){
				$id_posto = $dados_posto['sms_pos_id'];
				$nome_posto = $dados_posto['posto_administrativo'];
		    					
?>
		

				<option value="<?=$id_posto?>"><?= $nome_posto ?></option>	
	
<?php		
		}  		
	}


	if(isset($_POST['id_membro'])){
		$id_membro = $_POST['id_membro'];
		$geral = "todo tipo de documento";
		if($id_membro != 0){
			$sql = "SELECT id_tipo_doc FROM frl_cadastro_de_membros WHERE frl_cad_id = '$id_membro'";
			$query = mysqli_query($con, $sql);
			while($id_doc = mysqli_fetch_assoc($query)){
				$id_documento = $id_doc['id_tipo_doc'];
			}

			$sql_doc = "SELECT tipodoc,  frl_tip_id FROM frl_tipo_de_documento_de_ident WHERE frl_tip_id = '$id_documento'";
			$query_doc = mysqli_query($con, $sql_doc);
			$geral = "";

		}else{
			$sql_doc = "SELECT tipodoc, frl_tip_id FROM frl_tipo_de_documento_de_ident";
			$query_doc = mysqli_query($con, $sql_doc);
			$geral = "todo tipo de documento";
		}
?>


		<option value="0"><?= $geral ?></option>	
<?php 
		while($nome_doc = mysqli_fetch_assoc($query_doc)){
				$id_documento = $nome_doc['frl_tip_id'];
				$nome_documento = $nome_doc['tipodoc'];
?>

		
		<option value="<?=$id_documento?>"><?= $nome_documento?></option>	
	

		
<?php
		
		}
	}	


	if(isset($_POST['id_tipo_doc'])){
		$id_tipo_doc = $_POST['id_tipo_doc'];

?>
		<option value="0"></option>
<?php		
		if(	$id_tipo_doc != 0){
			$sql_tipo_doc = "SELECT*FROM frl_cadastro_de_membros WHERE id_tipo_doc = '$id_tipo_doc'";
			$geral = "";
		}else{
			$sql_tipo_doc = "SELECT*FROM frl_cadastro_de_membros";
?>
		<option value="0">Todos</option>
<?php

		}
		
?>
		
<?php		
		$query = mysqli_query($con, $sql_tipo_doc);
		while($dados_doc = mysqli_fetch_assoc($query )){
			$nr_doc = $dados_doc['documento_numero'];
		

?>
		<option value="<?=$nr_doc?>"><?= $nr_doc ?></option>	

<?php		
		}

	}


	if(isset($_POST["id_distrito_militancia"])){
		$id_distrito_militancia = $_POST["id_distrito_militancia"];
	

?>
		<option value="0"></option>
<?php

		if($id_distrito_militancia != 0){
			$sql = "SELECT*FROM frl_zona WHERE cod_distrito = '$id_distrito_militancia '";
			$geral = '';

		}else
			if($nivelAcesso == 5){
				$sql = "SELECT*FROM frl_zona WHERE cod_provincia = '$usu_provincia'";
?>
		<option value="0">Todas zonas da provincia</option>
<?php

		}else{
			$sql = "SELECT*FROM frl_zona";
?>
			<option value="0">Todas zonas</option>
<?php

		}


		$dados_zon = mysqli_query($con, $sql);

		  while($dados_zona = mysqli_fetch_assoc($dados_zon)){
				$id_zona = $dados_zona['frl_zon_id'];
				$nome_zona = $dados_zona['zona'];
		    					
?>
		

				<option value="<?=$id_zona?>"><?= $nome_zona ?></option>	
	
<?php		
		}  		
	}



	if(isset($_POST["id_zona_militancia"])){
		$id_zona_militancia = $_POST["id_zona_militancia"];
	

?>
		<option value="0"></option>
<?php

		if($id_zona_militancia != 0){
			$sql = "SELECT*FROM frl_circulo WHERE cod_zona = '$id_zona_militancia'";
			$geral = '';
		}else{
			if($nivelAcesso == 4){// se for um supervisor distrital so ve coisas a seu nivel
				$sql = "SELECT*FROM frl_circulo WHERE cod_distrito = $usu_distrito";
?>
		<option value="0">Todos circulos do distrito</option>
<?php				
			}else
				if($nivelAcesso == 5){
					$sql = "SELECT*FROM frl_circulo WHERE cod_provincia = $usu_provincia";
?>
			<option value="0">Todos circulos da provincia</option>
<?php					
				}


			else{
				$sql = "SELECT*FROM frl_circulo";
?>
				<option value="0">Todos circulos</option>
<?php				
			}
			
?>
			
<?php

		}


		$dados_cir = mysqli_query($con, $sql);

		  while($dados_circulo = mysqli_fetch_assoc($dados_cir)){
				$id_circulo = $dados_circulo['frl_cir_id'];
				$nome_circulo = $dados_circulo['circulo'];
		    					
?>
		

				<option value="<?=$id_circulo?>"><?= $nome_circulo?></option>	
	
<?php		
		}  		
	}


	if(isset($_POST["id_circulo_militancia"])){
		$id_circulo_militancia = $_POST["id_circulo_militancia"];
	

?>
		<option value="0"></option>
<?php

		if($id_circulo_militancia != 0){
			$sql = "SELECT*FROM frl_celula WHERE cod_circulo = '$id_circulo_militancia'";
			$geral = '';

		}else{

			if($nivelAcesso == 4){// se for um supervisor distrital so ve coisas a seu nivel
				$sql = "SELECT*FROM frl_celula WHERE cod_distrito = $usu_distrito";	
?>
				<option value="0">Todas celulas do distrito</option>
<?php				
			}else
				if($nivelAcesso == 5){
					$sql = "SELECT*FROM frl_celula WHERE cod_provincia = $usu_provincia";	
?>
			<option value="0">Todas celulas da provincia</option>
<?php					
				}

			else{
				$sql = "SELECT*FROM frl_celula";
?>
			<option value="0">Todas celulas</option>
<?php				
			}
			


		}


		$dados_cel = mysqli_query($con, $sql);

		  while($dados_celula = mysqli_fetch_assoc($dados_cel)){
				$id_celula = $dados_celula['frl_cel_id'];
				$nome_celula = $dados_celula['celula'];
		    					
?>
		

				<option value="<?=$id_celula?>"><?= $nome_celula ?></option>	
	
<?php		
		}  		
	}
?>

?>
