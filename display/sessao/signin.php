<?php

	$usuario = '';
	$senha = '';
	$activo = '';
	$mensagem = '';

///Provincias
$sql = "SELECT * FROM `sms_provincias`";
$result = mysqli_query($con, $sql);

if(isset($_POST['iniciar']))
{
	$usuario = $_POST['usuario'];
	$senha = $_POST['senha'];
	$provincia = $_POST['provincia2'];
    $distrito = $_POST['distrito'];
    $zona = $_POST['zona'];
    $classUser = new Usuario();
	//$activo = $_POST['activo'];
	
	if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $usuario) || preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $senha))
    {
        $mensagem =  '<div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        Caracteres Especiais n&atilde;o s&atilde;o Permetidos.
        </div>';
    }
	else
	{
	    $resultUser = $classUser->verificaDados($usuario, $senha, $provincia, $distrito, $zona);
	    $num = mysqli_num_rows($resultUser);
		if($num == 0)
		{
			$mensagem =  '<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			Senha ou palavra incorrecto.
			</div>';
		}
		else
        {
			$result = mysqli_fetch_assoc($resultUser);
			$idUser = $result['usuarioId'];
            $resultMac = $classUser->verificaMacAddress($idUser);
            $numMac = mysqli_num_rows($resultMac);
            if($numMac != 0) {
                $_SESSION['frl_idUser'] = $idUser;
            }
            else{
                $mensagem =  '<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			Senha ou palavra incorrecto.
			</div>';
            }

            ?>
            <script> window.location = "<?=principal?>"; </script>
            <?php
		}
	}
	
}

?>
<!-- ############ LAYOUT START-->
  <div class="center-block w-xxl w-auto-xs p-y-md">
    <div class="p-a-md box-color r box-shadow-z1 text-color m-a ">
	<div align="center">
	  <img src="assets/images/frelimoLogo.jpg" style="width: 200px; height: 250px; margin-left: 0px;" alt="." class="">
	 </div>
      <div class="m-b text-sm">
        Inicia a Sessao com sua Conta
      </div>
      <form name="form" method="post" action="<?=principal?>signin">
	  <?=$mensagem?>
        <div class="md-form-group float-label">
          <input type="text" class="md-input" name="usuario" required>
          <label>Usu&aacute;rio</label>
        </div>
        <div class="md-form-group float-label">
          <input type="password" class="md-input" name="senha" ng-model="user.password" required>
          <label>Senha</label>
        </div>
          <div class="form-group">
              <label>Selecione sua provincia</label>
              <select name="provincia2" class="form-control" id="provincia2">
                  <option value="0">selecione aqui...</option>
<?php
            while($linhaP = mysqli_fetch_array($result)){
                ?>
                <option value="<?=$linhaP['sms_pro_id']?>"><?=$linhaP['provincia']?></option>
                <?php
            }
?>
              </select>
          </div>
          <div class="form-group">
              <label>Selecione seu distrito</label>
              <select name="distrito" class="form-control" id="distrito">
                  <option value="0">Selecione Prov&iacute;ncia...</option>
              </select>
          </div>
          <div class="form-group">
              <label>Selecione tua zona</label>
              <select name="zona" class="form-control" id="zona">
                  <option value="0">Selecione Distrito...</option>
              </select>
          </div>

          <div class="m-b-md">
          <label class="md-check">
            <input type="checkbox"><i class="primary" name="activo"></i> Estar sempre logado
          </label>
        </div>
        <button type="submit" class="btn red-800 btn-block p-x-md" name="iniciar">Iniciar Sessao</button>
      </form>
    </div>
  </div>