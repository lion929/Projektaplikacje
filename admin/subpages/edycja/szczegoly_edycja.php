<?php

    session_start();
	$idks = $_SESSION['idks'];
	$id = $_GET['id'];

	try {

		require_once "connect.php";

		$conn = new mysqli($host, $db_user, $db_pass, $db_name);

		if ($conn->connect_errno!=0)
		{
			throw new Exception(mysqli_connect_errno());
		}

		else
		{
			$query = "SELECT * FROM szczegóły_zamowienia INNER JOIN książki ON książki.ID_ksiązki=szczegóły_zamowienia.ID_książki WHERE ID = '$id'";

			$result = $conn->query($query);

			if (!$result)
			{
				throw new Exception($conn->error);
			}

			else
			{
				$autorzy="";

				$row = $result->fetch_assoc();
				$idp1 = $row['ID_ksiązki'];
				$produkt1 = $row['Tytuł'];
				$sztuk1 = $row['Ilość'];


			}
		
			$result->close();

			$conn->close();
		}

	}

	catch(Exception $error) 
	{
		echo "Błąd serwera. Przepraszamy";
	}

    if(isset($_POST['sztuk'])){
		$ok = true;
		$sztuk = $_POST['sztuk'];
		$cena = 0;

		if($sztuk < 0)
		{
			$ok = false;
			$_SESSION['err_sztuk'] = "<script> document.getElementById('count').innerHTML = 'Nieprawidłowa liczba'; </script>";
		}

        require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);

		try {
			$conn = new mysqli($host, $db_user, $db_pass, $db_name);
			if($conn->connect_errno != 0){
				throw new Exception(mysqli_connect_errno());
			}
			else {

				if($ok == true){

					$idp;
					$p = $conn->query("SELECT Tytuł, Cena FROM książki WHERE ID_ksiązki='$idks'");

					if(!$p) throw new Exception($conn->error);

					else {
						while($r = $p->fetch_assoc())
						{
							$cena = $r['Cena'];
						}
					}

					$conn->query("CREATE OR REPLACE FUNCTION Price(price DOUBLE, count INT)
					RETURNS DOUBLE
					BEGIN
						RETURN price * count;
					END;");

					$conn->query("DROP PROCEDURE IF EXISTS updateDetailsA");
					$conn->query("CREATE PROCEDURE updateDetailsA(IN idb INT, IN count INT, IN price DOUBLE, IN id INT)
					BEGIN
						DECLARE ilosc2, ilosc3, suma_ilosc, roznica_ilosc, idk, ilosc_akt, ilosc_k, suma, id_zam, rabat INT DEFAULT 0;
						DECLARE odp INT;

						SELECT Liczba_sztuk INTO ilosc2 FROM książki WHERE ID_ksiązki = idb;
						SELECT Ilość INTO ilosc_akt FROM szczegóły_zamowienia WHERE szczegóły_zamowienia.ID = id;
						SELECT ID_zamówienia INTO id_zam FROM szczegóły_zamowienia WHERE szczegóły_zamowienia.ID = id;

						IF count > 0 THEN
							IF count <= (ilosc2+ilosc_akt) && count < ilosc_akt THEN
								SET ilosc_k = ilosc2 + (ilosc_akt-count);
								UPDATE szczegóły_zamowienia SET ID_książki = idb, Ilość = count, Cena = Price(price, count) WHERE szczegóły_zamowienia.ID = id;
								UPDATE książki SET Liczba_sztuk = ilosc_k WHERE ID_ksiązki = idb;

								SET odp=1;
								SELECT odp;

						 	ELSEIF count <= (ilosc2+ilosc_akt) && count > ilosc_akt THEN
								IF (ilosc2+ilosc_akt-count) >= 0 THEN
									SET ilosc_k = ilosc2-(count-ilosc_akt);
									UPDATE szczegóły_zamowienia SET ID_książki = idb, Ilość = count, Cena = Price(price, count) WHERE szczegóły_zamowienia.ID = id;
									UPDATE książki SET Liczba_sztuk = ilosc_k WHERE ID_ksiązki = idb;

									SET odp=1;
									SELECT odp;
								ELSE
									SET odp=0;
									SELECT odp;
								END IF;

							ELSE
								SET odp=0;
								SELECT odp;
							END IF;

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
						END IF;
					END;");

					$res = $conn->query("CALL updateDetailsA($idp1, $sztuk, $cena, $id)");

					while ($row = $res->fetch_assoc())
					{
						if($row['odp'] == 1)
						{
							echo "<span style='color:orange; text-align:center; display:block; font-size: 20px; font-weight:bold;'>Pomyślnie zaktualizowano dane</span>";
							$sztuk1 = $sztuk;
						}
						
						else
							echo "<span class='text-danger' style='text-align:center; display:block; font-size: 20px; font-weight:bold;'>Podano liczbę sztuk przekraczającą ilość dostępnych produktów</span>";
					}

				}

				$conn->close();
			}

		}
		catch (Exception $error){
			echo 'Błąd serwera. Przepraszamy';
		}
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Księgarnia internetowa</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <link rel="stylesheet" href="../../css/bootstrap.min.css">
        <link rel="icon" href="../../images/favikon.png" type="image/png">
		<link href="../../glyphicons/_glyphicons.css" rel="stylesheet">
        <link rel="stylesheet" href="css/edycja.css">
		<script src="js/edycja.js"></script>
    </head>

    <body>

        <div id="content">

            <div class="container col-md-5">

                <h2 class="mb-4"><i class="fas fa-pencil mr-2"></i>Edycja</h2>

                <form action="" method="post" autocomplete="off">

					<div class="form-check text-center mb-4">
						<label id="en"><input class="form-check-input" type="checkbox" id="enable" onchange="enble()"> Zmień ustawienia</label>
					</div>
						<div>
                            <label for="sztuk1">Liczba sztuk</label>
                            <input type="number" class="form-control bg-dark text-light col-md-4 mb-2" name="sztuk" id="sztuk1" min="1" placeholder="Liczba sztuk" value="<?php echo $sztuk1; ?>" required disabled>
							<span style="font-weight: bold; text-shadow: 0 0 15px white;" class="text-danger form-group" id="count"></span>

							<?php
								if(isset($_SESSION['err_sztuk'])){
									echo $_SESSION['err_sztuk'];
									unset($_SESSION['err_sztuk']);
								}
							?>
						</div>

					<div class="d-flex justify-content-center">
						<button id="submit" class="btn btn-primary btn-block mt-4 mb-4" type="submit" disabled><i class="fas fa-check mr-2"></i>Zapisz zmiany</button>
					</div>
					<div class="d-flex justify-content-center">
						<a href="../szczegoly.php?id=<?php echo $idks; ?>" class="btn btn-outline-warning btn-block"><i class="fas fa-arrow-left mr-2"></i>Powrót</a>
					</div>

                </form>

            </div>

        </div>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	    <script src="../../js/bootstrap.min.js"></script>
        
    </body>

</html>