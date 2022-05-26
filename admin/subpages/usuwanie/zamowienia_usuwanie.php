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
		$conn->query("DROP PROCEDURE IF EXISTS deleteOrder");
		$conn->query("CREATE PROCEDURE deleteOrder(IN id INT) 
		BEGIN 
			DECLARE done INT DEFAULT 0;
			DECLARE vid, il INT;
			DECLARE idf INT;
			DECLARE cur1 CURSOR FOR SELECT ID_książki, ilość FROM szczegóły_zamowienia WHERE ID_zamówienia = id;

			DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;

			OPEN cur1;

			petla: LOOP
				FETCH cur1 INTO vid, il;
				IF done THEN
					LEAVE petla;
				END IF;
				UPDATE książki SET Liczba_sztuk = (Liczba_sztuk + il) WHERE
				ID_ksiązki = vid;
			END LOOP;
			CLOSE cur1;

			SELECT zamówienia.ID_faktury INTO idf FROM zamówienia WHERE zamówienia.ID_zamowienia = id;
			DELETE FROM zamówienia WHERE ID_zamowienia = id;
			DELETE FROM faktury WHERE ID_faktury = idf;
			
		END;");
		
		$query = "CALL deleteOrder($id)";

		if($result = $conn->query($query))
		{
			echo 1;
			exit();
		}

		else if (!$result)
		{
			echo 0;
			exit();
		}

		$result->close();

		$conn->close();
	}

?>