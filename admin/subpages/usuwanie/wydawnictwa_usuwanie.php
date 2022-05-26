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
		$query = "DELETE FROM wydawnictwa WHERE ID_wydawnictwa= $id";
		$query1 = "SELECT książki.ID_wydawnictwa FROM książki WHERE książki.ID_wydawnictwa = $id";

		if(!$result1 = $conn->query($query1))
		{
			echo 0;
			exit();
		}

		else
		{
			$categories = $result1->num_rows;
			if($categories > 0)
			{
				echo 2;
				exit();
			}

			else
			{
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
			}
		}

		$result1->close();
		$result->close();

		$conn->close();
	}

?>
