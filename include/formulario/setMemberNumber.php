<?php
require_once ('../../Connections/connection.php');

	$sql = "SELECT frl_cad_id FROM frl_cadastro_de_membros ORDER BY frl_cad_id DESC";
	$result = mysqli_query($con, $sql);
	$row = mysqli_fetch_assoc($result);
	$numberRow = mysqli_num_rows($result);
	$nr                           = "0000000";
	
	if($numberRow != 0)
		$nr                           .= ($row['frl_cad_id']+1);
	else
		$nr                           .= 1;
	
?>
<input required name="cartaoMembroNr" type="text" class="form-control" id="cartaoMembroNr" style="width:100px" value="<?=substr($nr,-7);?>"/>