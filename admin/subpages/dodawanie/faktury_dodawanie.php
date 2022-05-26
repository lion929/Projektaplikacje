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

    if(isset($_POST['faktura'])){

		$ok = true;
		$numer = $_POST['faktura'];
		$data = $_POST['data'];
		$data1 = date($data);

        require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);

		try {
			$conn = new mysqli($host, $db_user, $db_pass, $db_name);
			if($conn->connect_errno != 0){
				throw new Exception(mysqli_connect_errno());
			}

			else {
		
				$check = $conn->query("SELECT * FROM faktury WHERE Nr_faktury='$numer'");
				if(!$check) 
					throw new Exception($conn->error);

				$count = $check->num_rows;
				if($count > 0) {
					$ok = false;
					$_SESSION['err_invoice'] = "<script> document.getElementById('invoice').innerHTML = 'Istnieje już taka faktura'; </script>";
				}

				if($ok == true)
				{
					if($conn->query("INSERT INTO faktury VALUES (NULL, '$numer', '$data1')")){

						echo "<span style='color:orange; text-align:center; display:block; font-size: 20px; font-weight:bold;'>Pomyślnie dodano rekord</span>";
	
					} 
					else
					{
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
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" />
    </head>

    <body>

        <div id="content">

            <div class="container">

                <h2 class="mb-4"><i class="fas fa-pencil mr-2"></i>Dodawanie rekordu</h2>

                <form action="" method="post" autocomplete="off">

					<div class="form-row">
						<div class="col-md-6 mb-3">
							<label for="faktura1">Nr faktury</label>
							<input type="text" class="form-control bg-dark text-light d-block" name="faktura" id="faktura1" placeholder="Nr faktury" required>
							<span style="color: #990066; font-weight: bold;" id="invoice"></span>
						</div>

						<div class="col-md-6 mb-3">
							<label for="">Data wystawienia</label>
							<input placeholder="Wybierz datę" type="text" id="date" name="data" class="form-control bg-dark text-light">
						</div>

					</div>

					<?php
						if(isset($_SESSION['err_invoice'])){
							echo $_SESSION['err_invoice'];
							unset($_SESSION['err_invoice']);
						}
					?>

					<div class="d-flex justify-content-center">
						<button id="submit" class="btn btn-success btn-block mt-5 mb-4 w-50" type="submit"><i class="fas fa-plus mr-2"></i>Dodaj rekord</button>
					</div>
					<div class="d-flex justify-content-center">
						<a href="../faktury.php" class="btn btn-outline-warning btn-block w-50"><i class="fas fa-arrow-left mr-2"></i>Powrót</a>
					</div>

                </form>

            </div>

        </div>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	    <script src="../../js/bootstrap.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous"></script>
		<script> 
			$('#date').datepicker({
				datetpicker: true,
				format: 'yyyy-mm-dd'
			});
		</script>
        
    </body>

</html>