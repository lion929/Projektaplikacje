<?php

	$id=$_GET['id'];
    session_start();
	unset($_SESSION['koszyk'][$id]);

?>
