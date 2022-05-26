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
			$query = "SELECT * FROM faktury WHERE ID_faktury = '$id'";

			$result = $conn->query($query);

			if (!$result)
			{
				throw new Exception($conn->error);
			}

			else
			{
				$row = $result->fetch_assoc();
				$faktura = $row['Nr_faktury'];
				$data = $row['Data_wystawienia'];
			}
		
			$result->close();

			$conn->close();
		}

	}

	catch(Exception $error) 
	{
		echo "Błąd serwera. Przepraszamy";
	}

    if(isset($_POST['faktura'])){
		$ok = true;

		$faktura1 = $_POST['faktura'];
		$data1 = $_POST['data'];

        require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);

		try {
			$conn1 = new mysqli($host, $db_user, $db_pass, $db_name);
			if($conn1->connect_errno != 0){
				throw new Exception(mysqli_connect_errno());
		}
			else {

				$check = $conn1->query("SELECT * FROM faktury WHERE Nr_faktury='$faktura1'");

				if(!$check) throw new Exception($conn1->error);

				$count = $check->num_rows;
				if($faktura1!=$faktura && $count > 0) {
					$ok = false;
					$_SESSION['err_invoice'] = "<script> document.getElementById('invoice').innerHTML = 'Istnieje już faktura o takim numerze'; </script>";
				}

				if($ok == true){
					
					if($conn1->query("UPDATE faktury SET Nr_faktury='$faktura1', Data_wystawienia='$data1' WHERE ID_faktury=$id")){

						$faktura = $faktura1;
						$data = $data1;
						echo "<span style='color:orange; text-align:center; display:block; font-size: 20px; font-weight:bold;'>Pomyślnie zaktualizowano dane</span>";	
					}
					else {
						throw new Exception($conn1->error);
					}
				}

				$conn1->close();
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
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" />
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
						<div class="col-md-6">
							<label for="faktura1">Nr faktury</label>
							<input type="text" class="form-control bg-dark text-light d-block" name="faktura" id="faktura1" placeholder="Nr faktury" value="<?php echo $faktura ?>" required disabled>
							<span style="color: #990066; font-weight: bold;" id="invoice"></span>
						</div>

						<div class="col-md-6">
							<label for="">Data wystawienia</label>
							<input placeholder="Wybierz datę" type="text" id="date" name="data" class="form-control bg-dark text-light" value="<?php echo $data ?>" requirde disabled>
						</div>

					</div>

					<?php
						if(isset($_SESSION['err_invoice'])){
							echo $_SESSION['err_invoice'];
							unset($_SESSION['err_invoice']);
						}
					?>

					<div class="d-flex justify-content-center">
						<button id="submit" class="btn btn-primary btn-block mt-4 mb-4 w-50" type="submit" disabled><i class="fas fa-check mr-2"></i>Zapisz zmiany</button>
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