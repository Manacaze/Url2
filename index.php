<?php session_start();

include_once "./include/cabecalho.php";

$url = filter_input(INPUT_SERVER, "REQUEST_URI");

$INIT = strpos($url, "&");

if($INIT){
    // Se na URL tiver ?, ele nao leva o que esta depois.
    $url = substr($url, 0, $INIT);
}


$url_pasta = substr($url, 1);
$url = explode("/", $url_pasta);

$posicao = 0;

//print_r($todasP);
foreach ($url as $cont => $value) {
    if($cont >= 1){
        $caminho[$posicao] = $value;
        $posicao++;
    }
}
if(empty($caminho[0])){
    include_once("include/menu.php");
    include_once("display/home.php");
}
else{
	include_once("display/erro/404.php");
}
include_once "./include/rodape.php";
