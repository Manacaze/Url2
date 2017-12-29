<?php

require_once ('../../Connections/connection.php');
include_once("../../get/variaveis_accoes.php");
if($_POST['id'] == '')
{
	?>
		<option value=""></option>
	<?php
}
else 
{
	$sql = "SELECT * FROM `sms_distritos` WHERE `cod_provincia`=".$_POST['id']." ORDER BY sms_dis_id ASC";
	$result = mysqli_query($con, $sql);
	?>
	<option value="">Selecione aqui...</option>
	<?php 
		while($linhaP = mysqli_fetch_array($result)){
			$id_distrito = $linhaP['sms_dis_id'];
			if($nivelAcesso == 3 && $usu_distrito == $id_distrito || $nivelAcesso == 4 && $usu_distrito == $id_distrito){// se o usuario for um registrador, so pode registrar membros do seu distrito, se for um supervisor a nivel Distrital so mostra a sua provincia
			?>
	?>
		<option value="<?=$linhaP['sms_dis_id']?>"><?=$linhaP['distrito']?></option>
	<?php
			}else
			if($nivelAcesso != 3 && $nivelAcesso != 4){
	?>			
				<option value="<?=$linhaP['sms_dis_id']?>"><?=$linhaP['distrito']?></option>
	<?php			
			}
		}
}
?>