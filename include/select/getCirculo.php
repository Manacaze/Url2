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
	$sql = "SELECT * FROM `frl_circulo` WHERE `cod_zona`=".$_POST['id']." ORDER BY frl_cir_id ASC";
	$result = mysqli_query($con, $sql);
	?>
	<option value="">Selecione aqui...</option>
	<?php while($linhaP = mysqli_fetch_array($result)){
	?>
		<option value="<?=$linhaP['frl_cir_id']?>"><?=$linhaP['circulo']?></option>
	<?php
	}
}?>