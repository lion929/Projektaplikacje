<?php

    session_start();

	unset($_SESSION['koszyk'][$_GET['id']]);

	header("Location: koszyk.php");

?>
