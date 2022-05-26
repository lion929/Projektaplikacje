<?php

	$password = $_POST['pass'];

	if(isset($password))
	{
		$haslo_hash = password_hash($password, PASSWORD_DEFAULT);
		echo $haslo_hash;
	}

	exit();

?>