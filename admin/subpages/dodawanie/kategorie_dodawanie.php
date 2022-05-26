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

    if(isset($_POST['nazwa'])){

		$ok = true;
		$nazwa = $_POST['nazwa'];

        require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);

		try {
			$conn = new mysqli($host, $db_user, $db_pass, $db_name);
			if($conn->connect_errno != 0){
				throw new Exception(mysqli_connect_errno());
			}

			else {
		
				$check = $conn->query("SELECT * FROM kategorie WHERE Nazwa='$nazwa'");
				if(!$check) 
					throw new Exception($conn->error);

				$count = $check->num_rows;
				if($count > 0) {
					$ok = false;
					$_SESSION['err_name'] = "<script> document.getElementById('name').innerHTML = 'Istnieje już kategoria o takiej nazwie'; </script>";
				}

				if($ok == true)
				{
					if($conn->query("INSERT INTO kategorie VALUES (NULL, '$nazwa')")){

						echo "<span style='color:orange; text-align:center; display:block; font-size: 20px; font-weight:bold;'>Pomyślnie dodano rekord</span>";
	
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
        <link rel="stylesheet" href="css/dodawanie.css">
    </head>

    <body>

        <div id="content">

            <div class="container col-md-4">

                <h2 class="mb-4"><i class="fas fa-pencil mr-2"></i>Dodawanie rekordu</h2>

                <form action="" method="post" autocomplete="off">

					<label for="nazwa1">Nazwa</label>
					<input type="text" class="form-control bg-dark text-light d-block" name="nazwa" id="nazwa1" placeholder="Nazwa" required>
					<span style="font-weight: bold; text-shadow: 0 0 15px white;" class="text-danger form-group" id="name"></span>

					<?php
						if(isset($_SESSION['err_name'])){
							echo $_SESSION['err_name'];
							unset($_SESSION['err_name']);
						}
					?>

					<div class="d-flex justify-content-center">
						<button id="submit" class="btn btn-success btn-block mt-5 mb-4 w-75" type="submit"><i class="fas fa-plus mr-2"></i>Dodaj rekord</button>
					</div>
					<div class="d-flex justify-content-center">
						<a href="../kategorie.php" class="btn btn-outline-warning btn-block w-75"><i class="fas fa-arrow-left mr-2"></i>Powrót</a>
					</div>

                </form>

            </div>

        </div>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	    <script src="../../js/bootstrap.min.js"></script>
        
    </body>

</html>