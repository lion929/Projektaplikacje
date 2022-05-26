<?php

    session_start();

    if (!isset($_SESSION['log_in']))
    {
        header("Location: ../../index.php");
        exit();
    }

    if(isset($_SESSION['user']) == true){
		$login = $_SESSION['user'];
	}

	$id = $_GET['id'];

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
			$query = "SELECT książki.Tytuł, książki.Rok_wydania, książki.Cena, książki.Liczba_sztuk, wydawnictwa.ID_wydawnictwa, kategorie.ID_kategorii, wydawnictwa.Nazwa as 'Wyd', kategorie.Nazwa as 'Kat'
			 FROM książki INNER JOIN wydawnictwa ON książki.ID_wydawnictwa=wydawnictwa.ID_wydawnictwa INNER JOIN kategorie ON książki.ID_kategorii=kategorie.ID_kategorii
			  WHERE ID_ksiązki = '$id'";

			$result = $conn->query($query);

			if (!$result)
			{
				throw new Exception($conn->error);
			}

			else
			{
				$row = $result->fetch_assoc();
				$tytul = $row['Tytuł'];
				$rok = $row['Rok_wydania'];
				$cena = $row['Cena'];
				$sztuk = $row['Liczba_sztuk'];
				$wydawnictwo = $row['Wyd'];
				$kategoria = $row['Kat'];
				$idwyd = $row['ID_wydawnictwa'];
				$idkat = $row['ID_kategorii'];
			}
		
			$result->close();

			$conn->close();
		}

	}

	catch(Exception $error) 
	{
		echo "Błąd serwera. Przepraszamy";
	}

    if(isset($_POST['tytul'])){
		$ok = true;

		$tytul1 = $_POST['tytul'];
		$rok1 = $_POST['rok'];
		$cena1 = $_POST['cena'];
		$sztuk1 = $_POST['sztuk'];
		$wydawnictwo1 = $_POST['wydawnictwo'];
		$kategoria1 = $_POST['kategoria'];

		if((strlen($rok1)!=4) && !is_int($rok1))
		{
			$ok = false;
			$_SESSION['err_rok'] = "<script> document.getElementById('year').innerHTML = 'Nieprawidłowy rok'; </script>";
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

					$idw=0; $idk=0;
					$w = $conn->query("SELECT Nazwa FROM wydawnictwa WHERE ID_wydawnictwa='$wydawnictwo1'");

					if(!$w) throw new Exception($conn->error);

					else {
						while($r = $w->fetch_assoc())
						{
							$nw = $r['Nazwa'];
						}
					}

					$k = $conn->query("SELECT Nazwa FROM kategorie WHERE ID_kategorii='$kategoria1'");
					if(!$k) throw new Exception($conn->error);

					else {
						while($r1 = $k->fetch_assoc())
						{
							$nk = $r1['Nazwa'];
						}
					}
					
					if($conn->query("UPDATE książki SET ID_wydawnictwa=$wydawnictwo1, ID_kategorii=$kategoria1, Tytuł='$tytul1', Rok_wydania=$rok1, Cena=$cena1, Liczba_sztuk=$sztuk1
					WHERE ID_ksiązki = $id")) {

						$tytul = $tytul1;
						$rok = $rok1;
						$cena = $cena1;
						$sztuk = $sztuk1;
						$wydawnictwo = $nw;
						$kategoria = $nk;

						echo "<span style='color:orange; text-align:center; display:block; font-size: 20px; font-weight:bold;'>Pomyślnie zaktualizowano rekord</span>";
		
					}
					else{
						throw new Exception($conn->error);
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

            <div class="container">

                <h2 class="mb-4"><i class="fas fa-pencil mr-2"></i>Edycja</h2>

                <form action="" method="post" autocomplete="off">

					<div class="form-check text-center mb-4">
						<label id="en"><input class="form-check-input" type="checkbox" id="enable" onchange="enble()"> Zmień ustawienia</label>
					</div>

					<div class="form-row">
						<div class="col-md-6 mb-3">
                            <label for="tytul1">Tytuł</label>
                            <input type="text" class="form-control bg-dark text-light" name="tytul" id="tytul1" placeholder="Tytuł" value="<?php echo $tytul; ?>" required disabled>
                        </div>

						<div class="col-md-2 mb-3">
                            <label for="rok1">Rok wydania</label>
                            <input type="number" class="form-control bg-dark text-light" name="rok" id="rok1" placeholder="Rok wydania" value="<?php echo $rok; ?>" required disabled>
							<span style="font-weight: bold; text-shadow: 0 0 15px white;" class="text-danger form-group" id="year"></span>

							<?php
								if(isset($_SESSION['err_rok'])){
									echo $_SESSION['err_rok'];
									unset($_SESSION['err_rok']);
								}
							?>
                        </div>

						<div class="col-md-2 mb-3">
                            <label for="cena1">Cena</label>
                            <input type="number" class="form-control bg-dark text-light" name="cena" id="cena1" step="0.01" min="1" placeholder="Cena" value="<?php echo $cena; ?>" required disabled>
                        </div>

						<div class="col-md-2 mb-3">
                            <label for="sztuk1">Liczba sztuk</label>
                            <input type="number" class="form-control bg-dark text-light" name="sztuk" id="sztuk1" placeholder="Liczba sztuk" value="<?php echo $sztuk; ?>" min="0" required disabled>
                        </div>
					</div>

					<div class="form-row">
						<div class="col-md-5 mb-3">
                            <label>Wydawnictwo</label>
							<select class="form-control bg-dark text-light" id="wyd" name="wydawnictwo" required disabled>
								<optgroup label="Wybierz">
								<option hidden value=<?php echo $idwyd ?> selected><?php echo $wydawnictwo; ?></option>
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
											$query = "SELECT * FROM wydawnictwa";
	
											$result = $conn->query($query);
	
											if (!$result)
											{
												throw new Exception($conn->error);
											}
	
											else
											{
												while ($row = $result->fetch_assoc())
												{
													echo "<option value=".$row['ID_wydawnictwa'].">".$row['Nazwa']."</option>";
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
                        </div>

						<div class="col-md-5 mb-3">
                            <label>Kategoria</label>
                            <select class="form-control bg-dark text-light" id="kat" name="kategoria" required disabled>
								<option hidden selected value=<?php echo $idwyd ?>><?php echo $kategoria; ?></option>
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
											$query = "SELECT * FROM kategorie";
	
											$result = $conn->query($query);
	
											if (!$result)
											{
												throw new Exception($conn->error);
											}
	
											else
											{
												while ($row = $result->fetch_assoc())
												{
													echo "<option value=".$row['ID_kategorii'].">".$row['Nazwa']."</option>";
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
							</select>
                        </div>
					</div>

                    <div class="d-flex justify-content-center">
                        <button id="submit" class="btn btn-primary btn-block mt-4 mb-4 w-50" type="submit" disabled><i class="fas fa-check mr-2"></i>Zapisz zmiany</button>
					</div>
					<div class="d-flex justify-content-center">
                        <a href="../ksiazki.php" class="btn btn-outline-warning btn-block w-50"><i class="fas fa-arrow-left mr-2"></i>Powrót</a>
                    </div>

                </form>

            </div>

        </div>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	    <script src="../../js/bootstrap.min.js"></script>
        
    </body>

</html>