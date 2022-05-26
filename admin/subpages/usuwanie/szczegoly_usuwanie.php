<?php

    session_start();

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
		$conn->query("DROP PROCEDURE IF EXISTS deleteDetailsA");
		$conn->query("CREATE PROCEDURE deleteDetailsA(IN id INT) 
		BEGIN 
			DECLARE ilosc2, ilosc3, suma_ilosc, idk, suma, id_zam, rabat INT DEFAULT 0;

			SELECT Ilość INTO ilosc2 FROM szczegóły_zamowienia WHERE szczegóły_zamowienia.ID = id;
			SELECT ID_książki INTO idk FROM szczegóły_zamowienia WHERE szczegóły_zamowienia.ID = id;
			SELECT ID_zamówienia INTO id_zam FROM szczegóły_zamowienia WHERE szczegóły_zamowienia.ID = id;

			SELECT Liczba_sztuk INTO ilosc3 FROM książki WHERE ID_ksiązki = idk;
			SET suma_ilosc = ilosc3+ilosc2; 

			DELETE FROM szczegóły_zamowienia WHERE szczegóły_zamowienia.ID = id;
			UPDATE książki SET Liczba_sztuk = suma_ilosc WHERE ID_ksiązki = idk;

			SELECT SUM(Ilość) INTO suma FROM szczegóły_zamowienia WHERE ID_zamówienia = id_zam;

			IF suma >= 3 AND suma <= 5 THEN
				SET rabat = 5;

			ELSEIF suma >= 6 AND suma <= 10 THEN
				SET rabat = 10;

			ELSEIF suma >= 11 AND suma <= 15 THEN
				SET rabat = 15;

			ELSEIF suma > 15 THEN
				SET rabat = 20;

			ELSE
				SET rabat = 0;

			END IF;

			UPDATE zamówienia SET Rabat = rabat WHERE ID_zamowienia = id_zam;
		END;");
		
		$query = "CALL deleteDetailsA($id)";

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