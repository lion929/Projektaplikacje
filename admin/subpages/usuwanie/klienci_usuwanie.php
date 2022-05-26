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
		$conn->query("DROP PROCEDURE IF EXISTS deleteClientA");
		$conn->query("CREATE PROCEDURE deleteClientA(IN id INT) 
		BEGIN 
			DECLARE licz, liczba INT;
			SELECT COUNT(*) INTO liczba FROM zamówienia WHERE ID_klienta = id;

			IF liczba > 0 THEN
				SET licz = 2;
				SELECT licz;
			ELSE
				DELETE FROM klienci WHERE ID_klienta = id;
				SET licz = 1;
				SELECT licz;
			END IF;
		END;");
		
		$query = "CALL deleteClientA($id)";
		$result = $conn->query($query);

		$l;

		while($row = $result->fetch_assoc())
		{
			$l = $row['licz'];
		}

		if($result = $conn->query($query))
		{
			echo $l;
			exit();
		}

		else if(!$result)
		{
			echo $l;
			exit();
		}

		$result->close();

		$conn->close();
	}

?>
