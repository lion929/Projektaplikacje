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
				$adres = $row['Adres_zamieszkania'];
			}
		
			$result->close();

			$conn->close();
		}

	}

	catch(Exception $error) 
	{
		echo "Błąd serwera. Przepraszamy";
	}

    if(isset($_POST['ulica'])){
		$ok = true;

		$ulica = $_POST['ulica'];
		$kod_pocztowy = $_POST['kodpocztowy'];
		$miasto = $_POST['miasto'];

		if ( !preg_match('/^[0-9]{2}-?[0-9]{3}$/Du', $kod_pocztowy) ) {
			$ok = false;
			$_SESSION['err_kod'] = "<script> document.getElementById('postcode').innerHTML = 'Nieprawidłowy kod pocztowy'; </script>";
		}

        require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);

		try {
			$conn1 = new mysqli($host, $db_user, $db_pass, $db_name);
			if($conn1->connect_errno != 0){
				throw new Exception(mysqli_connect_errno());
		}
			else {

				if($ok == true){
					
					if($conn1->query(
					"UPDATE klienci SET Adres_zamieszkania='$ulica $miasto $kod_pocztowy' WHERE ID_klienta = $id")){

					$adres=$ulica." ".$miasto." ".$kod_pocztowy;
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
		<script src="js/adres.js"></script>
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
						<div class="col-md-6 mb-5">
							<label>Adres zamieszkania</label>
							<input type="text" class="form-control bg-dark text-light" name="adres_zam" value="<?php echo $adres ?>" disabled>
				  		</div>
					</div>

					<div class="form-row">
				  		<div class="col-md-6 mb-3">
							<label for="ulicaa">Ulica i numer lokalu</label>
							<input type="text" class="form-control bg-dark text-light" name="ulica" id="ulicaa" placeholder="Ulica i numer lokalu" required disabled>
				 		</div>

				   		<div class="col-md-3 mb-3">
							<label for="kod_pocztowy">Kod pocztowy</label>
							<input type="text" class="form-control bg-dark text-light" name="kodpocztowy" id="kod_pocztowy" placeholder="Kod pocztowy" required disabled>
							<span style="font-weight: bold; text-shadow: 0 0 15px white;" class="text-danger form-group" id="postcode"></span>
				  		</div>

						<?php
							if(isset($_SESSION['err_kod'])){
								echo $_SESSION['err_kod'];
								unset($_SESSION['err_kod']);
							}
                    	?>

				  		<div class="col-md-3 mb-3">
							<label for="miastoo">Miasto</label>
							<input type="text" class="form-control bg-dark text-light" name="miasto" id="miastoo" placeholder="Miasto" required disabled>
				  		</div>
					</div>

                    <div class="d-flex justify-content-center">
                        <button id="submit" class="btn btn-primary btn-block mt-4 mb-4 w-50" type="submit" disabled><i class="fas fa-check mr-2"></i>Zapisz zmiany</button>
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