<?php

require_once ('../../Connections/connection.php');

if($_POST['id'] == '')
{
	?>
		<option value=""></option>
	<?php
}
else
{
	$sql = "SELECT * FROM `sms_postos_administrativos` WHERE `cod_distrito`=".$_POST['id']." ORDER BY sms_pos_id ASC";
	$result = mysqli_query($con, $sql);
	?>
	<option value="">Selecione aqui...</option>
	<?php while($linhaP = mysqli_fetch_array($result)){
	?>
		<option value="<?=$linhaP['sms_pos_id']?>"><?=$linhaP['posto_administrativo']?></option>
	<?php
	}
}?>