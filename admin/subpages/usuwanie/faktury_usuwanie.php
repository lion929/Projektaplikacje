<?php

    session_start();

    if (!isset($_SESSION['log_in']))
    {
        header("Location: ../index.php");
        exit();
    }

	$id = $_GET['id'];

	require_once "connect.php";

	$conn = new mysqli($host, $db_user, $db_pass, $db_name);

	if ($conn->connect_errno!=0)
	{
		echo 0;
		exit();
	}

	else
	{
		$query = "DELETE FROM faktury WHERE ID_faktury= $id";

		if($result = $conn->query($query))
		{
			echo 1;
			exit();
		}

		else if(!$result)
		{
			echo 0;
			exit();
		}

		$result->close();

		$conn->close();
	}

?>
