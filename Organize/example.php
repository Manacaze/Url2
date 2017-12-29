<?php
require_once('google_weather_api.php');

$weather = new weather();
if (!empty($_GET['loc'])) {
	$weather->location = $_GET['loc'];
}
$weather->get();
if($weather->error){
	die('We couldn\'t find your location.');
}else{
	echo '
	<div id="currentWeather">
		<h1>Now in '.ucwords($weather->location).': '.$weather->current->temp_c['data'].' &#8451;</h1>
		<img src="http://www.google.com/' .$weather->current->icon['data'] . '"/>
		<p>'.$weather->current->condition['data'].'</p>
		<p>'.$weather->current->humidity['data'].'</p>
		<p>'.$weather->current->wind_condition['data'].'</p>
	</div>
	';
	// display more days info
	// print_r($weather->nextdays);
	$weather->display();
}