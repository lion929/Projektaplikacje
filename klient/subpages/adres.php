<?php

    session_start();

    if (!isset($_SESSION['log_in1']))
    {
        header("Location: ../index.php");
        exit();
    }

	if(isset($_SESSION['user1']) == true) {
		$login = $_SESSION['user1'];
	}

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
			$query = "SELECT * FROM klienci WHERE Nazwa_użytkownika='$login'";

			$result = $conn->query($query);

			if (!$result)
			{
				throw new Exception($conn->error);
			}

			else
			{
				$row = $result->fetch_assoc();
				$id_kl1 = $row['ID_klienta'];
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

	$ulica1 = $_POST['ulica'];
	$kodpocztowy1 = $_POST['kodpocztowy'];
	$miasto1 = $_POST['miasto'];

	if ( !preg_match('/^[0-9]{2}-?[0-9]{3}$/Du', $kodpocztowy1) ) {
		$ok = false;
		$_SESSION['err_kod'] = "<script> document.getElementById('postcode').innerHTML = 'Nieprawidłowy kod pocztowy'; </script>";
	}

	try {
		$conn2 = new mysqli($host, $db_user, $db_pass, $db_name);
		if($conn2->connect_errno != 0){
			throw new Exception(mysqli_connect_errno());
	}
	else {

		if($ok == true)
		{				
			if($conn2->query(
				"UPDATE klienci SET Adres_zamieszkania = '$ulica1 $miasto1 $kodpocztowy1' WHERE ID_klienta = $id_kl1"))
			{
					header('Location: ../wyloguj.php');
			}
			else
			{
				throw new Exception($conn2->error);
			}

		}

		$conn2->close();
	}

	}
	catch (Exception $e) {
		echo "Błąd serwera. Przepraszamy";
	}}

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Księgarnia <?php if(isset($_SESSION['koszyk'])){if(count($_SESSION['koszyk']) != 0) echo "(".count($_SESSION['koszyk']).")";}?></title>
		<link rel="stylesheet" href="../css/bootstrap.min.css">
		<link rel="icon" href="../images/favikon.png" type="image/png">
		<link rel="stylesheet" href="css/adres.css">
		<link href="../glyphicons/_glyphicons.css" rel="stylesheet">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
		<script src="js/adres.js"></script>
	</head>

	<body>

		<header>
			<nav class="navbar navbar-dark bg-dark navbar-expand-lg">
				<div class="navbar-brand">
					<img src="../images/book2.png" class="mr-2">Księgarnia internetowa
				</div>

				<button class="navbar-toggler order-first" type="button" data-toggle="collapse" data-target="#list">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse" id="list">
					<ul class="navbar-nav mr-5">

						<li class="nav-item dropdown mr-4">
							<a class="nav-link dropdown-toggle" data-toggle="dropdown" href=""><i class="fas fa-book mr-2"></i>Książki</a>

							<ul class="dropdown-menu">
								<a class="dropdown-item" href="ksiazki.php?page=1">Wszystkie</a>
								<i class="fa fa-tasks mr-2 ml-2"></i>Kategorie:

								<?php
									require_once "connect.php";
									mysqli_report(MYSQLI_REPORT_STRICT);

									try {

										$conn = new mysqli($host, $db_user, $db_pass, $db_name);
										$query = $conn->query("SELECT * FROM kategorie");

										while($row = mysqli_fetch_assoc($query))
										{
											echo '<a class="dropdown-item" href="kategorie.php?kategoria='.$row['Nazwa'].'"><i class="fa fa-angle-right" aria-hidden="true"></i> '.$row['Nazwa'].'</a>';
										}
										
									}

									catch(Exception $error)
									{
										echo "Problem z odczytem danych";
									}
                                ?>
							</ul>
						</li>	

						<li class="nav-item mr-4">
							<a class="nav-link" href=""><i class="fas fa-shopping-bag mr-2"></i>Historia zamówień</a>
						</li>

						<li class="nav-item">
							<a class="nav-link" href="koszyk.php"><i class="fas fa-shopping-cart mr-2"></i>Koszyk</a>
						</li>

						<li class="nav-item">
							<div class="bg-danger text-center text-white rounded-circle" style="width:20px"><?php if(isset($_SESSION['koszyk'])){if(count($_SESSION['koszyk']) != 0) echo count($_SESSION['koszyk']);}?></div>
						</li>

					</ul>

					<div id="buttons" class="ml-auto">
						<a class="btn btn-dark glyphicon glyphicon-home" href="../ksiegarnia1.php" role="button" title="Strona główna"></a>
						<a class="btn btn-dark glyphicon glyphicon-log-out" href="../wyloguj.php" role="button" title="Wyloguj"></a>
					</div>
				</div>
			</nav>
		</header>

		<main>

            <div class="container">

                <h2 class="mb-4"><i class="fa fa-address-book mr-2"></i>Dane adresowe</h2>

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

					<h3 class="mb-3">Zmiana adresu</h3>
                    
					<div class="form-row">
				  		<div class="col-md-6 mb-3">
							<label for="ulicaa">Ulica i numer lokalu</label>
							<input type="text" class="form-control bg-dark text-light" name="ulica" id="ulicaa" placeholder="Ulica i numer lokalu" required disabled>
				 		</div>

				   		<div class="col-md-3 mb-3">
							<label for="kod_pocztowy">Kod pocztowy</label>
							<input type="text" class="form-control bg-dark text-light" name="kodpocztowy" id="kod_pocztowy" placeholder="Kod pocztowy" required disabled>
							<span id="postcode"></span>
				  		</div>

				  		<div class="col-md-3 mb-3">
							<label for="miastoo">Miasto</label>
							<input type="text" class="form-control bg-dark text-light" name="miasto" id="miastoo" placeholder="Miasto" required disabled>
				  		</div>
					</div>

					<?php
						if(isset($_SESSION['err_kod']))
						{
							echo $_SESSION['err_kod'];
							unset($_SESSION['err_kod']);
						}
					?>

					<span id="warning">Uwaga! Po zatwierdzeniu zmian nastąpi automatyczne wylogowanie</span>

					<div class="d-flex justify-content-center">
						<button id="submit" class="btn btn-primary w-50 mt-4 mb-4" type="submit" disabled><i class="fas fa-check mr-2"></i>Zatwierdź</button>
					</div>
						
					<div class="form-group">
						<label>Powrót</label> 
						<div><a href="ustawienia.php" class="btn btn-secondary" role="button"><i class="fas fa-arrow-left mr-2"></i>Powrót</a></div>
					</div>
                    
                </form>

            </div>

		</main>

		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="../js/bootstrap.min.js"></script>

	</body>
</html>