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
			$query = "SELECT * FROM klienci WHERE ID_klienta = '$id'";

			$result = $conn->query($query);

			if (!$result)
			{
				throw new Exception($conn->error);
			}

			else
			{
				$row = $result->fetch_assoc();
				$imie = $row['Imię'];
				$nazwisko = $row['Nazwisko'];
				$email = $row['Adres_email'];
				$telefon = $row['Nr_telefonu'];
				$uzytkownik = $row['Nazwa_użytkownika'];
			}
		
			$result->close();

			$conn->close();
		}

	}

	catch(Exception $error) 
	{
		echo "Błąd serwera. Przepraszamy";
	}

    if(isset($_POST['imie'])){
		$ok = true;

		$imie1 = $_POST['imie'];
		$nazwisko1 = $_POST['nazwisko'];

		$mail1 = $_POST['mail'];
		$mailB = filter_var($mail1, FILTER_SANITIZE_EMAIL);

		if((filter_var($mailB, FILTER_VALIDATE_EMAIL) == false) || ($mailB != $mail1)){
			$ok = false;
			$_SESSION['err_mail'] = "<script> document.getElementById('e_mail').innerHTML = 'Nieprawidłowy adres e-mail'; </script>";
		}

		$numer_tel1 = $_POST['nrtel'];

		if((strlen($numer_tel1)!=9) && !is_int($numer_tel1))
		{
			$ok = false;
			$_SESSION['err_tel'] = "<script> document.getElementById('phone').innerHTML = 'Nieprawidłowy numer telefonu'; </script>";
		}

		$nazwa_uzytkownika1 = $_POST['nazwauz'];

		if((strlen($nazwa_uzytkownika1)<5) || (strlen($nazwa_uzytkownika1)>15)){
			$ok = false;
			$_SESSION['err_nick'] = "<script> document.getElementById('username').innerHTML = 'Nazwa użytkownika musi zawierać od 5 znaków do 15 znaków'; </script>";
		}

		if(ctype_alnum($nazwa_uzytkownika1) == false){
			$ok = false;
			$_SESSION['err_nick1'] = "<script> document.getElementById('username').innerHTML = 'Nazwa użytkownika musi składać się tylko z liter i cyfr (bez polskich znaków)'; </script>";
		}

        require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);

		try {
			$conn1 = new mysqli($host, $db_user, $db_pass, $db_name);
			if($conn1->connect_errno != 0){
				throw new Exception(mysqli_connect_errno());
		}
			else {

				$rezultat = $conn1->query("SELECT ID_klienta FROM klienci WHERE Adres_email='$mail1'");

				if(!$rezultat) throw new Exception($conn1->error);

				$ile_maili = $rezultat->num_rows;
				if($mail1 != $email && $ile_maili > 0) {
					$ok = false;
					$_SESSION['err_mail'] = "Istnieje już konto o takim adresie e-mail";
				}

				$rezultat = $conn1->query("SELECT ID_klienta FROM klienci WHERE Nazwa_użytkownika='$nazwa_uzytkownika1'");

				if(!$rezultat) throw new Exception($conn1->error);

				$row1 = $rezultat->fetch_assoc();
				$ile_nazw = $rezultat->num_rows;

				if($nazwa_uzytkownika1 != $uzytkownik && $ile_nazw > 0) {
					$ok = false;
					$_SESSION['err_nick'] = "<script> document.getElementById('username').innerHTML = 'Istnieje już konto o takiej nazwie'; </script>";
				}

				if($ok == true){
					
					if($conn1->query(
					"UPDATE klienci SET Imię = '$imie1', Nazwisko = '$nazwisko1', Nr_telefonu = '$numer_tel1', Adres_email = '$mail1', 
					Nazwa_użytkownika = '$nazwa_uzytkownika1' WHERE ID_klienta = $id")){

					$imie = $imie1;
					$nazwisko = $nazwisko1;
					$telefon = $numer_tel1;
					$email = $mail1;
					$uzytkownik = $nazwa_uzytkownika1;
					echo "<span style='color:orange; text-align:center; display:block; font-size: 20px; font-weight:bold;'>Pomyślnie zaktualizowano dane</span>";
		
					}
					else{
						throw new Exception($conn1->error);
					}

				}

				$conn1->close();
			}

		}catch (Exception $error){
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
                            <label>Imię</label>
                            <input type="text" class="form-control bg-dark text-light" name="imie" id="imiee" placeholder="Imię" value="<?php echo $imie ?>" required disabled>
                        </div>
                    
                        <div class="col-md-6 mb-3">
                            <label>Nazwisko</label>
                            <input type="text" class="form-control bg-dark text-light" name="nazwisko" id="nazwiskoo" placeholder="Nazwisko" value="<?php echo $nazwisko ?>" required disabled>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label>Numer telefonu</label>
                            <input type="text" class="form-control bg-dark text-light" name="nrtel" id="ntel" placeholder="Numer telefonu" value="<?php echo $telefon ?>" required disabled>
                            <span style="font-weight: bold; text-shadow: 0 0 15px white;" class="text-danger form-group" id="phone"></span>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Adres e-mail</label>
                            <input type="text" class="form-control bg-dark text-light" name="mail" id="email" placeholder="E-mail" value="<?php echo $email ?>" required disabled>
                            <span style="font-weight: bold; text-shadow: 0 0 15px white;" class="text-danger form-group" id="e_mail"></span>
                        </div>
                    </div>

                    <?php
                        if(isset($_SESSION['err_tel'])){
                            echo $_SESSION['err_tel'];
                            unset($_SESSION['err_tel']);
                        }
                    ?>

                    <?php
                        if(isset($_SESSION['err_mail'])){
                            echo $_SESSION['err_mail'];
                            unset($_SESSION['err_mail']);
                        }						
                    ?>

                    <div class="form-row">
                        <div class="col-md-6 mb-3">	
                            <label>Nazwa użytkownika</label>
                            <input type="text" class="form-control bg-dark text-light" name="nazwauz" id="nazwau" placeholder="Nazwa użytkownika" value="<?php echo $uzytkownik ?>" required disabled>
                            <span style="font-weight: bold; text-shadow: 0 0 15px white;" class="text-danger form-group" id="username"></span>
                        </div>
                    </div>

                    <?php
                        if(isset($_SESSION['err_nick'])){
                            echo $_SESSION['err_nick'];
                            unset($_SESSION['err_nick']);
                        }
                    ?>

                    <?php
                        if(isset($_SESSION['err_nick1'])){
                            echo $_SESSION['err_nick1'];
                            unset($_SESSION['err_nick1']);
                        }
                    ?>

					<div class="d-flex justify-content-center">
                        <button id="submit" class="btn btn-primary btn-block mt-4 mb-4 w-50" type="submit" disabled><i class="fas fa-check mr-2"></i>Zapisz zmiany</button>
					</div>
					<div class="d-flex justify-content-center">
                        <a href="adres.php?id=<?php echo $id ?>" class="btn btn-success btn-block mt-4 mb-4 w-50"><i class="fas fa-address-card mr-2"></i>Zmień dane adresowe</a>
                    </div>
					<div class="d-flex justify-content-center">
						<a href="../klienci.php" class="btn btn-outline-warning btn-block w-50"><i class="fas fa-arrow-left mr-2"></i>Powrót</a>
                    </div>

                </form>

            </div>

        </div>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	    <script src="../../js/bootstrap.min.js"></script>
        
    </body>

</html>