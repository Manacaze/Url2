<?php

//localhost
	$hostname_sigre = "";
	$database_sigre = "=";
	$username_sigre = "=";
	$password_sigre = "";

	$con=mysqli_connect($hostname_sigre, $username_sigre,$password_sigre) or trigger_error(mysqli_error(),E_USER_ERROR);

	mysqli_select_db($con, $database_sigre);
    mysqli_query($con, "SET NAMES 'utf8'");
    mysqli_query($con, 'SET character_set_connection=utf8');
    mysqli_query($con, 'SET character_set_client=utf8');
    mysqli_query($con, 'SET character_set_results=utf8');
