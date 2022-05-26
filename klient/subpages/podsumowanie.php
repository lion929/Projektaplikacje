<?php

    session_start();

	$tmp = array();

/*	if(isset($_SESSION['liczba_szt']))
		$_SESSION['liczba_szt'] = array();*/

	for($i=0; $i<=$_SESSION['licznik']; $i++)
	{
		if(isset($_POST['liczbaszt'.$i.'']))
		{
			$tmp[$i] = $_POST['liczbaszt'.$i.''];
		}
	}
	$_SESSION['liczba_szt'] = $tmp;

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Księgarnia</title>
		<link rel="stylesheet" href="../css/bootstrap.min.css">
		<link rel="icon" href="../images/favikon.png" type="image/png">
		<link rel="stylesheet" href="css/koszyk.css">
		<link href="../glyphicons/_glyphicons.css" rel="stylesheet">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
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
							<a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" href=""><i class="fas fa-book mr-2"></i>Książki</a>

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
							<a class="nav-link" href="historia.php"><i class="fas fa-shopping-bag mr-2"></i>Historia zamówień</a>
						</li>

						<li class="nav-item mr-4">
							<a class="nav-link active" href="koszyk.php"><i class="fas fa-shopping-cart mr-2"></i>Koszyk</a>
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
                <div class="d-block ml-auto col-12 col-sm-12 col-md-12 col-lg-12 container-group">
			        <h2 class="mb-4">Podsumowanie</h2>
					<table class="mt-3 table">
						<thead class="thead-dark"><tr><th>Nazwa produktu</th><th>Ilość</th><th>Cena</th></tr></thead>
						<tbody>
							<?php
								$tabid = [];
								$tabilosc = [];
								$i = 0;
								$suma = 0;
								$cena_laczna = 0;

								require_once "connect.php";
								$conn = new mysqli($host, $db_user, $db_pass, $db_name);

								foreach ($_SESSION['koszyk'] as $sub => $key)
								{
									$tabid[$i] = $key['idk'];
									$tabcena[$i] = $key['cena'];

									mysqli_report(MYSQLI_REPORT_STRICT);

									try {

										if ($conn->connect_errno!=0)
										{
											throw new Exception(mysqli_connect_errno());
										}

										else
										{
											$query = "SELECT książki.Tytuł FROM książki WHERE książki.ID_ksiązki =".$tabid[$i]."";

											$result = $conn->query($query);

											if (!$result)
											{
												throw new Exception($conn->error);
											}

											else
											{
												while ($row = $result->fetch_assoc())
												{
													echo "<tr><td>".$row['Tytuł']."</td><td>".$tmp[$i]."</td><td>".$tmp[$i] * $tabcena[$i]."</td></tr>";
													$suma += $tmp[$i];
													$cena_laczna += $tmp[$i] * $tabcena[$i];
												}

												$result->close();
											} 

										}

									}

									catch(Exception $error) 
									{
										echo "Problemy z odczytem danych";
									}

									$i++;
								}
															
							?>
						</tbody>
					</table>
					
					<span class="float-right">Dostawa: 0,00 zł</span><br/>
					<span class="float-right">Rabat:
						<?php
							$rabat = 0;
							if($suma >= 3 && $suma <=5)
								$rabat = 5;

							else if($suma >= 6 && $suma <=10)
								$rabat = 10;
							
							else if($suma >= 11 && $suma <= 15)
								$rabat = 15;
							
							else if($suma > 15)
								$rabat = 20;
							
							echo $rabat. '%';
						?>
					</span><br/><br/>
					<span class="float-right" style="font-size: 18px;">Razem do zapłaty: <strong><?php echo $cena_laczna - ($cena_laczna*$rabat/100); ?> zł</strong></span><br/>
					<br/>
					<button id="btt" name="butt" type="button" class="btn btn-dark mt-3 float-right" data-toggle="modal" data-target="#mod" data-backdrop="static" data-keyboard="false"><i class="fa fa-check mr-2"></i>Dalej</button>
					<a href="koszyk.php" class="btn btn-light mt-3 mr-6" role="button">Powrót</a>
                </div>
            </div>
			<div class="modal" tabindex="-1" role="dialog" id="mod">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Metoda płatności</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<img onclick="wybierz('paypal')" id="paypal" class="btn m-1 metody" src="../images/paypal.png" width="150px" height="70px"/><img onclick="wybierz('paysafecard')" id="paysafecard" class="btn mr-1 metody" src="../images/paysafecard.jpg" width="170px" height="70px"/><img onclick="wybierz('visa')" id="visa" class="btn metody" src="../images/visa.png" width="130px" height="70px"/><img onclick="wybierz('mastercard')" id="mastercard" class="btn metody" src="../images/mastercard.png" width="130px" height="70px"/>
					</div>
					<div class="modal-footer">
						<form method="post" action="zakonczenie.php">
							<div class="ml-4"><label id="en"><input type="checkbox" class="form-check-input" name="faktura"><strong>Chcę otrzymać fakturę</strong></label></div><br/>
							<button type="submit" name="submit" id="s" class="btn btn-primary" disabled><i class="fa fa-check mr-2"></i>Potwierdź zamówienie</button>
							<a class="btn btn-secondary" href="ksiazki.php?page=1">Wróć do sklepu</a>
						</form>
					</div>
					</div>
				</div>
			</div>
		</main>

		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="../js/bootstrap.min.js"></script>
		<script>
			function wybierz(id){
				var ok = 1;
				var metoda = document.getElementById(id);
				metoda.style.borderWidth = "3px";
				metoda.style.borderStyle = "solid";
				metoda.style.borderRadius = "5px";
				metoda.style.borderColor = "#3393F2";
				var przyciski = document.getElementsByClassName("metody");
				for(var i = 0; i<przyciski.length; i++){
					przyciski[i].removeAttribute("onclick");
				}
				ok = 0;
				if(ok == 0){
					document.getElementById("s").disabled = false;
				}
			}
		</script>
	</body>
	
</html>