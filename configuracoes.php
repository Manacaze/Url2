<?php
	$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$cam = explode('?', $_SERVER['REQUEST_URI'], 2);
	$paginaActual = $cam[0];
	$quebrada = explode("/", $paginaActual);
	$paginaInicial = "/".$quebrada[1]."/";
	$servidorQuebrado = explode("/", $actual_link);
	$servidor = $servidorQuebrado[0]."//".$servidorQuebrado[2];
	
	define("principal", $servidor.$paginaInicial);
?>