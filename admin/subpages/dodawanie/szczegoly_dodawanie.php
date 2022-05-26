<?php

    session_start();

	$idsz = $_GET['id'];

    if(isset($_POST['produkt'])){
		$ok = true;

		$produkt = $_POST['produkt'];
		$sztuk = $_POST['sztuk'];

		/*if($sztuk < 0)
		{
			$ok = false;
			$_SESSION['err_sztuk'] = "<script> document.getElementById('count').innerHTML = 'Nieprawidłowa liczba'; </script>";
		}*/

		if($produkt == 'wybierz')
		{
			$ok = false;
			$_SESSION['err_prod'] = "<script> document.getElementById('produkt').innerHTML = 'Nieprawidłowa nazwa produktu'; </script>";
		}

        require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);

		try {
			$conn = new mysqli($host, $db_user, $db_pass, $db_name);
			if($conn->connect_errno != 0){
				throw new Exception(mysqli_connect_errno());
			}
			else {

				$zapytanie = $conn->query("SELECT * FROM szczegóły_zamowienia WHERE ID_książki = '$produkt'");
				$il = $zapytanie->num_rows;

				if($il > 1)
				{
					$ok = false;
					$_SESSION['err_prod'] = "<script> document.getElementById('produkt').innerHTML = 'Ten produkt znajduje się w zamówieniu'; </script>";
				}

				if($ok == true){

					$idp;
					$p = $conn->query("SELECT ID_ksiązki, Cena FROM książki WHERE ID_ksiązki='$produkt'");

					if(!$p) throw new Exception($conn->error);

					else {
						while($r = $p->fetch_assoc())
						{
							$idp = $r['ID_ksiązki'];
							$cena = $r['Cena'];
						}
					}

					$conn->query("CREATE OR REPLACE FUNCTION Price(price DOUBLE, count INT)
					RETURNS DOUBLE
					BEGIN
						RETURN price * count;
					END;");

					$conn->query("DROP PROCEDURE IF EXISTS addDetailsA");
					$conn->query("CREATE PROCEDURE addDetailsA(IN idd INT, IN idb INT, IN count INT, IN price DOUBLE)
				
					BEGIN
						DECLARE ilosc2, ilosc3, suma, rabat, odp INT DEFAULT 0;
						DECLARE tekst TEXT;

						SELECT Liczba_sztuk INTO ilosc2 FROM książki WHERE ID_ksiązki = idb;		
						SET ilosc3 = ilosc2-count;

						IF ilosc3 >= 0 THEN
							UPDATE książki SET Liczba_sztuk = ilosc3 WHERE ID_ksiązki = idb;
							INSERT INTO szczegóły_zamowienia VALUES (NULL, idd, idb, count, Price(price, count));
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

							SET odp = 1;
							SELECT odp;
						ELSE
							SET odp = 0;
							SELECT odp;
						END IF;
					END");

					$res = $conn->query("CALL addDetailsA($idsz, $idp, $sztuk, $cena)"); 

					while ($row = $res->fetch_assoc())
					{
						if($row["odp"] == 1)
						{
							echo "<span style='color:orange; text-align:center; display:block; font-size: 20px; font-weight:bold;'>Pomyślnie dodano rekord</span>";
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
        <link rel="stylesheet" href="css/dodawanie.css">
    </head>

    <body>

        <div id="content">

            <div class="container col-md-5">

                <h2 class="mb-4"><i class="fas fa-pencil mr-2"></i>Dodawanie rekordu</h2>

                <form action="" method="post" autocomplete="off">
					<div class="">
						<label>Nazwa produktu</label>
						<select class="form-control bg-dark text-light" id="prod" name="produkt" required>
							<optgroup label="Wybierz">
								<option value="wybierz" selected hidden>Wybierz</option>
								<?php
									mysqli_report(MYSQLI_REPORT_STRICT);

									try {
	
										require_once "connect.php";
	
										$conn = new mysqli($host, $db_user, $db_pass, $db_name);
	
										if ($conn->connect_errno!=0)
										{
											throw new Exception(mysqli_connect_errno());
										}
	
										else
										{
											$query = "SELECT * FROM książki";
	
											$result = $conn->query($query);
	
											if (!$result)
											{
												throw new Exception($conn->error);
											}
	
											else
											{
												while ($row = $result->fetch_assoc())
												{
													$idk=$row['ID_ksiązki'];
													$zap1 = $conn->query("SELECT autorzy.Imie, autorzy.Nazwisko FROM książki_autorzy INNER JOIN autorzy ON książki_autorzy.ID_autora = autorzy.ID_autora WHERE książki_autorzy.ID_książki = $idk");
													$autorzy = "";
													while($row1 = mysqli_fetch_assoc($zap1))
													{
														$autorzy .= ", ".$row1['Imie'];	
														$autorzy .= " ".$row1['Nazwisko'];
													}

													$zap2 = $conn->query("SELECT wydawnictwa.Nazwa FROM książki INNER JOIN wydawnictwa ON książki.ID_wydawnictwa=wydawnictwa.ID_wydawnictwa WHERE książki.ID_ksiązki=$idk");
													$wydawnictwo ="";
													while($row2 = mysqli_fetch_assoc($zap2))
													{
														$wydawnictwo .= ", wyd.: ".$row2['Nazwa'];	
													}


													echo "<option value='".$row['ID_ksiązki']."'>".$row['Tytuł'].$autorzy.$wydawnictwo."</option>";
												}
	
												$result->close();
	
												$conn->close();
											}
										}
	
									}
	
									catch(Exception $error) 
									{
										echo "Problemy z odczytem danych";
									}
								?>
								</optgroup>
							</select>
							<span style="font-weight: bold; text-shadow: 0 0 15px white;" class="text-danger form-group" id="produkt"></span>
							<?php
								if(isset($_SESSION['err_prod'])){
									echo $_SESSION['err_prod'];
									unset($_SESSION['err_prod']);
								}
							?>
					<div>

						<div class="mt-3">
                            <label for="sztuk1">Liczba sztuk</label>
                            <input type="number" class="form-control bg-dark text-light col-md-4 mb-2" min="1" name="sztuk" id="sztuk1" placeholder="Liczba sztuk" required>
							<span style="font-weight: bold; text-shadow: 0 0 15px white;" class="text-danger form-group" id="count"></span>
						</div>


                    <div class="d-flex justify-content-center">
                        <button id="submit" class="btn btn-success btn-block mt-4 mb-4 w-75" type="submit" name="pods"><i class="fas fa-plus mr-2"></i>Dodaj rekord</button>
					</div>
					<div class="d-flex justify-content-center">
                        <a href="../szczegoly.php?id=<?php echo $idsz; ?>" class="btn btn-outline-warning btn-block w-75"><i class="fas fa-arrow-left mr-2"></i>Powrót</a>
                    </div>

                </form>

            </div>

        </div>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	    <script src="../../js/bootstrap.min.js"></script>
        
    </body>

</html>