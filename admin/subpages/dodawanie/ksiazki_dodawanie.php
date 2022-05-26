<?php

    session_start();
	error_reporting(E_ERROR | E_PARSE);

    if (!isset($_SESSION['log_in']))
    {
        header("Location: ../../index.php");
        exit();
    }

    if(isset($_SESSION['user']) == true){
		$login = $_SESSION['user'];
	}

    if(isset($_POST['tytul'])){
		$ok = true;

		$tytul = $_POST['tytul'];
		$rok = $_POST['rok'];
		$cena = $_POST['cena'];
		$sztuk = $_POST['sztuk'];
		$wydawnictwo = $_POST['wydawnictwo'];
		$kategoria = $_POST['kategoria'];
		$sciezka = $_POST['sciezka'];

		$target_dir = $sciezka."Projektaplikacje/klient/images/ksiazki/";
		$nazwa = $tytul.".jpg";
		$_FILES["obrazek"]["name"] = $nazwa;
		$target_file = $target_dir . basename($_FILES["obrazek"]["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		// Check if image file is a actual image or fake image
		
			$check = getimagesize($_FILES["obrazek"]["tmp_name"]);
			if($check !== false) {
				echo "File is an image - " . $check["mime"] . ".";
				$uploadOk = 1;
			} else {
				echo "File is not an image.";
				$uploadOk = 0;
			}

			if (file_exists($target_file)) {
				echo "Sorry, file already exists.";
				$uploadOk = 0;
			}

			if ($uploadOk == 0) {
				echo "Sorry, your file was not uploaded.";
			// if everything is ok, try to upload file
			}else{
				if (move_uploaded_file($_FILES["obrazek"]["tmp_name"], $target_file)) {
					echo "The file ". htmlspecialchars( basename( $_FILES["obrazek"]["name"])). " has been uploaded.";
				} else {
					echo "Sorry, there was an error uploading your file.";
				}
			}

		$target_dir1 = $sciezka."Projektaplikacje/klient/opisyksiazek/";
		$nazwa1 = $tytul."-opis.txt";
		$_FILES["opis"]["name"] = $nazwa1;
		$target_file1 = $target_dir1 . basename($_FILES["opis"]["name"]);
		$uploadOk1 = 1;
		$imageFileType1 = strtolower(pathinfo($target_file1,PATHINFO_EXTENSION));
	
			if (file_exists($target_file1)) {
				echo "Sorry, file already exists.";
				$uploadOk1 = 0;
			}

			if ($uploadOk1 == 0) {
				echo "Sorry, your file was not uploaded.";
			// if everything is ok, try to upload file
			}else{
				if (move_uploaded_file($_FILES["opis"]["tmp_name"], $target_file1)) {
					echo "The file ". htmlspecialchars( basename( $_FILES["opis"]["name"])). " has been uploaded.";
				} else {
					echo "Sorry, there was an error uploading your file.";
				}
			}

		$target_dir2 = $sciezka."Projektaplikacje/klient/fragmentyksiazek/";
		$nazwa2 = $tytul."-tekst.txt";
		$_FILES["fragment"]["name"] = $nazwa2;
		$target_file2 = $target_dir2 . basename($_FILES["fragment"]["name"]);
		$uploadOk2 = 1;
		$imageFileType2 = strtolower(pathinfo($target_file2,PATHINFO_EXTENSION));
	
			if (file_exists($target_file2)) {
				echo "Sorry, file already exists.";
				$uploadOk2 = 0;
			}

			if ($uploadOk2 == 0) {
				echo "Sorry, your file was not uploaded.";
			// if everything is ok, try to upload file
			}else{
				if (move_uploaded_file($_FILES["fragment"]["tmp_name"], $target_file2)) {
					echo "The file ". htmlspecialchars( basename( $_FILES["fragment"]["name"])). " has been uploaded.";
				} else {
					echo "Sorry, there was an error uploading your file.";
				}
			}

		if((strlen($rok)!=4) && !is_int($rok))
		{
			$ok = false;
			$_SESSION['err_rok'] = "<script> document.getElementById('year').innerHTML = 'Nieprawidłowy rok'; </script>";
		}

		if(($cena < 0) && !is_double($cena))
		{
			$ok = false;
			$_SESSION['err_cena'] = "<script> document.getElementById('price').innerHTML = 'Nieprawidłowa cena'; </script>";
		}

		if($sztuk < 1)
		{
			$ok = false;
			$_SESSION['err_sztuk'] = "<script> document.getElementById('count').innerHTML = 'Nieprawidłowa liczba'; </script>";
		}

		if($wydawnictwo == 'wybierz')
		{
			$ok = false;
			$_SESSION['err_wyd'] = "<script> document.getElementById('wydaw').innerHTML = 'Nie wybrano wydawnictwa'; </script>";
		}

		if($kategoria == 'wybierz')
		{
			$ok = false;
			$_SESSION['err_kat'] = "<script> document.getElementById('kateg').innerHTML = 'Nie wybrano kategorii'; </script>";
		}

		if(realpath($sciezka) == false)
		{
			$ok = false;
			$_SESSION['err_sc'] = "<script> document.getElementById('sc').innerHTML = 'Nieprawidłowa ściezka do katalogu.'; </script>";
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

					if($conn->query("INSERT INTO książki VALUES (NULL, $wydawnictwo, $kategoria, '$tytul', $rok, $cena, $sztuk)")) {

						echo "<span style='color:orange; text-align:center; display:block; font-size: 20px; font-weight:bold;'>Pomyślnie dodano rekord</span>";
		
					}else{
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
        <link rel="stylesheet" href="css/dodawanie.css">
    </head>

    <body>

        <div id="content">

            <div class="container">

                <h2 class="mb-4"><i class="fas fa-pencil mr-2"></i>Dodawanie rekordu</h2>

                <form action="" method="post" autocomplete="off" enctype="multipart/form-data">

					<div class="form-row">
						<div class="col-md-6 mb-3">
                            <label for="tytul1">Tytuł</label>
                            <input type="text" class="form-control bg-dark text-light" name="tytul" id="tytul1" placeholder="Tytuł" required>
                        </div>

						<div class="col-md-2 mb-3">
                            <label for="rok1">Rok wydania</label>
                            <input type="number" class="form-control bg-dark text-light" name="rok" id="rok1" placeholder="Rok wydania" required>
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
                            <input type="number" class="form-control bg-dark text-light" name="cena" id="cena1" step="0.01" min="1" placeholder="Cena" required>
							<span style="font-weight: bold; text-shadow: 0 0 15px white;" class="text-danger form-group" id="price"></span>

							<?php
								if(isset($_SESSION['err_cena'])){
									echo $_SESSION['err_cena'];
									unset($_SESSION['err_cena']);
								}
							?>
                        </div>

						<div class="col-md-2 mb-3">
                            <label for="sztuk1">Liczba sztuk</label>
                            <input type="number" class="form-control bg-dark text-light" name="sztuk" id="sztuk1" placeholder="Liczba sztuk" min="0" required>
							<span style="font-weight: bold; text-shadow: 0 0 15px white;" class="text-danger form-group" id="count"></span>

							<?php
								if(isset($_SESSION['err_sztuk'])){
									echo $_SESSION['err_sztuk'];
									unset($_SESSION['err_sztuk']);
								}
							?>
						</div>
					</div>

					<div class="form-row">
						<div class="col-md-5 mb-3">
                            <label>Wydawnictwo</label>
							<select class="form-control bg-dark text-light" id="wyd" name="wydawnictwo" required>
								<optgroup label="Wybierz">
									<option hidden selected value="wybierz">Wybierz</option>
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
							<span style="font-weight: bold; text-shadow: 0 0 15px white;" class="text-danger form-group" id="wydaw"></span>
							<?php
								if(isset($_SESSION['err_wyd'])){
									echo $_SESSION['err_wyd'];
									unset($_SESSION['err_wyd']);
								}
							?>
                        </div>
						<div class="col-md-5 mb-3">
                            <label>Kategoria</label>
                            <select class="form-control bg-dark text-light" id="kat" name="kategoria" required>
								<optgroup label="Wybierz">
									<option hidden selected value="wybierz">Wybierz</option>
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
								</optgroup>
							</select>
							<span style="font-weight: bold; text-shadow: 0 0 15px white;" class="text-danger form-group" id="kateg"></span>
							<?php
								if(isset($_SESSION['err_kat'])){
									echo $_SESSION['err_kat'];
									unset($_SESSION['err_kat']);
								}
							?>
                        </div>
					</div>
					<div class="form-row">
					<div class="col-md-5 mb-3">
						<label for="sztuk1">Ścieżka do folderu htdocs:</label>
                        <input type="text" class="form-control bg-dark text-light" name="sciezka" id="sciezka1" placeholder="Np. C:/xampp/htdocs/" required>
						<span style="font-weight: bold; text-shadow: 0 0 15px white;" class="text-danger form-group" id="sc"></span>
						<?php
						if(isset($_SESSION['err_sc'])){
							echo $_SESSION['err_sc'];
							unset($_SESSION['err_sc']);
							}
						?>
					</div></div>
					<div class="col-md-6 m-auto">
						<label>Miniatura książki (.jpg):</label>
							<input type="file" name="obrazek" accept="image/jpeg" required>
					</div>

					<div class="col-md-6 m-auto">
						<label>Opis książki (.txt):</label>
							<input type="file" name="opis" accept=".txt" required>
					</div>
					<div class="col-md-6 m-auto">
						<label>Fragment książki (.txt):</label>
							<input type="file" name="fragment" accept=".txt" required>
					</div>
                    <div class="d-flex justify-content-center">
                        <button id="submit" class="btn btn-success btn-block mt-4 mb-4 w-50" type="submit"><i class="fas fa-plus mr-2"></i>Dodaj rekord</button>
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