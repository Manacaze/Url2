<?php 
//Cabecalho
include '../include/cabecalho.php';

//Home de Paginas
	if(isset($_GET['rg_Mbr']))
	{
		include './rg/novoMembro.php';
	}
	else if(isset($_GET['rg_UMbr']))
	{
		include './rg/editarMembro.php';
	}
	else if(isset($_GET['ps_Mbr']))
	{
		include './ps/membros.php';
	}
	else if(isset($_GET['rg_MbrIns']))
	{
		include './rg/insertIntoMembro.php';
	}
	else if(isset($_GET['rg_UMbrIns']))
	{
		include './rg/updateIntoMembro.php';
	}
	else if(isset($_GET['ps_DMbr'])){
		include './ps/detalhesMembro.php';
	}

	
	
//Rodape da Pagina
include '../include/rodape.php';
?>