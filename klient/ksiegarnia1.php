<?php

    session_start();

    if (!isset($_SESSION['log_in1']))
    {
        header("Location: index.php");
        exit();
    }

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Księgarnia <?php if(isset($_SESSION['koszyk'])){if(count($_SESSION['koszyk']) != 0) echo "(".count($_SESSION['koszyk']).")";}?></title>
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="icon" href="./images/favikon.png" type="image/png">
		<link rel="stylesheet" href="css1/ksiegarnia1.css">
		<link href="glyphicons/_glyphicons.css" rel="stylesheet">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
		<script src="js1/funkcje.js"></script>
		
	</head>

	<body>

		<header>
			<nav class="navbar navbar-dark bg-dark navbar-expand-lg">
				<div class="navbar-brand">
					<img src="images/book2.png" class="mr-2">Księgarnia internetowa
				</div>

				<button class="navbar-toggler order-first" type="button" data-toggle="collapse" data-target="#list">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse" id="list">
					<ul class="navbar-nav mr-5">

						<li class="nav-item dropdown mr-4">
							<a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" href=""><i class="fas fa-book mr-2"></i>Książki</a>

							<ul class="dropdown-menu">
								<a class="dropdown-item" href="subpages/ksiazki.php?page=1">Wszystkie</a>
								<i class="fa fa-tasks mr-2 ml-2"></i>Kategorie:
								
								<?php
									require_once "connect.php";
									mysqli_report(MYSQLI_REPORT_STRICT);

									try {

										$conn = new mysqli($host, $db_user, $db_pass, $db_name);
										$query = $conn->query("SELECT * FROM kategorie");

										while($row = mysqli_fetch_assoc($query))
										{
											echo '<a class="dropdown-item" href="subpages/kategorie.php?kategoria='.$row['Nazwa'].'"><i class="fa fa-angle-right" aria-hidden="true"></i> '.$row['Nazwa'].'</a>';
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
							<a class="nav-link" href="subpages/historia.php"><i class="fas fa-shopping-bag mr-2"></i>Historia zamówień</a>
						</li>

						<li class="nav-item">
							<a class="nav-link" href="subpages/koszyk.php"><i class="fas fa-shopping-cart mr-2"></i>Koszyk</a>
						</li>

						<li class="nav-item">
							<div class="bg-danger text-center text-white rounded-circle" style="width:20px"><?php if(isset($_SESSION['koszyk'])){if(count($_SESSION['koszyk']) != 0) echo count($_SESSION['koszyk']);}?></div>
						</li>

					</ul>

					<div id="buttons" class="ml-auto">
						<a class="btn btn-dark glyphicon glyphicon-home active" href="ksiegarnia1.php" role="button" title="Strona główna"></a>
						<a class="btn btn-dark glyphicon glyphicon-log-out" href="wyloguj.php" role="button" title="Wyloguj"></a>
					</div>
				</div>
			</nav>
		</header>

		<main>

			<div class="container">

				<div class="mb-4">
					<a class="text-dark" href="subpages/ustawienia.php"><i class="fas fa-wrench mr-2"></i>Moje ustawienia</a>
				</div>

				<h1>Witaj <?php echo $_SESSION['user1']; ?>!</h1>

				<div>
					<img src="images/user.png" class="d-block ml-auto mr-auto img-fluid">
				</div>

				<div class="mt-4 mb-5">
					<span id="date" class="d-block ml-auto mr-auto"></span>
					<span id="clock" class="d-block ml-auto mr-auto"></span>
				</div>

				<script>
					date();
					time();
				</script>

				<div class="mt-4 mb-5">
					<h3 class="text-white"> Mamy dla ciebie specjalną ofertę!</h3>
					<ul>
						<h5><li>Przy zakupie 3-5 książek z wybranej kategorii otrzymasz 5 % rabatu.</li></h5>
						<h5><li>Przy zakupie 6-10 książek z wybranej kategorii zyskasz 10 % rabatu.</li></h5>
						<h5><li>Przy zakupie 11-15 książek z wybranej kategorii możesz zyskać nawet 15 % rabatu.</li></h5>
						<h5><li>Przy zakupie powyżej 15 książek z wybranej kategorii otrzymasz zawrotne 20 % rabatu.</li></h5>
					</ul>
					<h3 class="text-danger"> Nie czekaj! Zobacz co możesz u nas kupić.</h3>
					<a href="subpages/ksiazki.php?page=1" class="btn btn-dark">Przejdź do zakupów!</a>
				</div>
			</div>

		</main>
		<footer class="p-3">
			<h3>Kontakt do księgarni:</h3>
			<strong>Telefon: 123 456 789 <i class="fas fa-phone-volume"></i></strong> <br/> <strong><i class="fas fa-at"></i> Adres e-mail: ksiegarnia@gmail.com</strong>
		</footer>
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="js/bootstrap.min.js"></script>

		
	</body>
	
</html>