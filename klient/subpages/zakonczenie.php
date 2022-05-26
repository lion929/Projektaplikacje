

<?php
	session_start();
	
	$tabid = [];
	$tabilosc = [];
	$i = 0;

	require_once "connect.php";
	$conn = new mysqli($host, $db_user, $db_pass, $db_name);

	if(isset($_POST["submit"]))
	{
		$user = $_SESSION['user1'];
		$query1 = $conn->query("SELECT ID_klienta FROM klienci WHERE Nazwa_użytkownika = '$user'");
		$r = mysqli_fetch_row($query1);
		$idkl = $r[0];
		$date=date('Y-m-d');
		if(!isset($_POST['faktura']))
		{
			$query2 = $conn->query("INSERT INTO zamówienia VALUES(NULL, $idkl, NULL, 0, '$date')");
		}

		else
		{	
			$nrf = "KS/";
			while(true)
			{
				$nr = rand(10, 100000);
				$nrf .= $nr;
				$q2 = $conn->query("SELECT Nr_faktury FROM faktury WHERE Nr_faktury = '$nrf'");
				if($q2->num_rows == 0)
				{
					break;
				}
			}

			$q = $conn->query("INSERT INTO faktury VALUES(NULL, '$nrf', '$date')");
			$q1 = $conn->query("SELECT ID_faktury FROM faktury ORDER BY ID_faktury DESC LIMIT 1");
			$r1 = mysqli_fetch_row($q1);
			$idf = $r1[0];

			$q3 = $conn->query("INSERT INTO zamówienia VALUES(NULL, $idkl, $idf, 0, '$date')");
		}
	}
	
	foreach ($_SESSION['koszyk'] as $sub => $key)
	{
		$tabid[$i] = $key['idk'];
		$tabcena[$i] = $key['cena'];

		mysqli_report(MYSQLI_REPORT_STRICT);

		try {

			if ($conn->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}

			else
			{
				$query = "SELECT książki.Tytuł FROM książki WHERE książki.ID_ksiązki =".$tabid[$i]."";

				$result = $conn->query($query);


				if(isset($_POST["submit"]))
				{
					$q = $conn->query("SELECT ID_zamowienia FROM zamówienia ORDER BY ID_zamowienia DESC LIMIT 1");
					$r = $q->fetch_assoc();

					//$insert = $conn->query("INSERT INTO szczegóły_zamowienia VALUES(NULL, ".$r['ID_zamowienia'].", ".$key['idk'].", '".$_SESSION['liczba_szt'][$i]."', ".$key['cena'].")");

					$idzam = $r['ID_zamowienia']; $idksiaz = $key['idk']; $sztuki = $_SESSION['liczba_szt'][$i]; $cena = $key['cena'];

					$conn->query("DROP PROCEDURE IF EXISTS addDetailsC");
					$conn->query("CREATE PROCEDURE addDetailsC(IN idd INT, IN idb INT, IN count INT, IN price DOUBLE)
				
					BEGIN
						DECLARE ilosc2, ilosc3, suma, rabat INT DEFAULT 0;

						SELECT Liczba_sztuk INTO ilosc2 FROM książki WHERE ID_ksiązki = idb;		
						SET ilosc3 = ilosc2-count;

						IF ilosc3 >= 0 THEN
							UPDATE książki SET Liczba_sztuk = ilosc3 WHERE ID_ksiązki = idb;
							INSERT INTO szczegóły_zamowienia VALUES (NULL, idd, idb, count, price);
							SELECT SUM(Ilość) INTO suma FROM szczegóły_zamowienia WHERE ID_zamówienia = idd;

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

							UPDATE zamówienia SET Rabat = rabat WHERE ID_zamowienia = idd;

						END IF;
					END");

					$insert = $conn->query("CALL addDetailsC($idzam, $idksiaz, $sztuki, $cena)");

					unset($_SESSION['koszyk']);
					header("Location: koniec.php");
				}
					
			}

		}

		catch(Exception $error) 
		{
			echo "Problemy z odczytem danych";
		}

		$i++;
	}
								
?>
