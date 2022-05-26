<?php

    session_start();

    if (!isset($_SESSION['log_in1']))
    {
        header("Location: ../index.php");
        exit();
    }
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Księgarnia <?php if(isset($_SESSION['koszyk'])){if(count($_SESSION['koszyk']) != 0) echo "(".count($_SESSION['koszyk']).")";}?></title>
		<link rel="stylesheet" href="../css/bootstrap.min.css">
		<link rel="icon" href="../images/favikon.png" type="image/png">
		<link rel="stylesheet" href="css/zmiana_hasla.css">
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
							<a class="nav-link" href="historia.php"><i class="fas fa-shopping-bag mr-2"></i>Historia zamówień</a>
						</li>

						<li class="nav-item">
							<a class="nav-link" href=""><i class="fas fa-shopping-cart mr-2"></i>Koszyk</a>
						</li>

						<li class="nav-item">
							<div class="bg-danger text-center text-white rounded-circle" style="width:20px"><?php if(isset($_SESSION['koszyk'])){if(count($_SESSION['koszyk']) != 0) echo count($_SESSION['koszyk']);}?></div>
						</li>

					</ul>

                    <form class="form-inline mr-auto">
						<div class="input-group">
        					<div class="input-group-prepend">
								<div class="input-group-text"><span class="glyphicon glyphicon-search"></span></div>
							</div>
							<input class="form-control" type="search" placeholder="Szukaj">
						</div>
					</form>

					<div id="buttons" class="ml-auto">
						<a class="btn btn-dark glyphicon glyphicon-home" href="../ksiegarnia1.php" role="button" title="Strona główna"></a>
						<a class="btn btn-dark glyphicon glyphicon-log-out" href="../wyloguj.php" role="button" title="Wyloguj"></a>
					</div>
				</div>
			</nav>
		</header>

		<main>

            <div class="container">

				<a class="btn btn-primary mb-3" href="historia.php"><i class="fas fa-arrow-left mr-2"></i>Powrót</a>

                <?php
				require_once "connect.php";
				mysqli_report(MYSQLI_REPORT_STRICT);
				try{

					$user = $_SESSION['user1'];
					$poloczenie = new mysqli($host, $db_user, $db_pass, $db_name);
					if($poloczenie->connect_errno != 0){
						throw new Exception(mysqli_connect_errno());
					}else{
                        
						$idz = $_GET['id'];
						$suma=0;

						$zap = $poloczenie->query("SELECT książki.Tytuł, szczegóły_zamowienia.Ilość, (szczegóły_zamowienia.Cena*szczegóły_zamowienia.Ilość) as Koszt, książki.ID_ksiązki FROM szczegóły_zamowienia 
						INNER JOIN książki ON szczegóły_zamowienia.ID_książki=książki.ID_ksiązki WHERE szczegóły_zamowienia.ID_zamówienia = $idz");

						echo '<table class="table table-secondary">';
							echo '<thead class="thead-dark"><tr><th scope="col">Nazwa produktu</th><th scope="col">Ilość</th><th scope="col">Cena</th></tr></thead>';
							while($row = mysqli_fetch_row($zap)){

								$idk = $row[3];
								$zap1 = $poloczenie->query("SELECT autorzy.Imie, autorzy.Nazwisko FROM książki_autorzy INNER JOIN autorzy ON książki_autorzy.ID_autora = autorzy.ID_autora WHERE książki_autorzy.ID_książki = $idk");
								$autorzy = "";
								while($row1 = mysqli_fetch_row($zap1))
								{
									$autorzy .= ", ".$row1[0];	
									$autorzy .= " ".$row1[1];
								}

								$zap2 = $poloczenie->query("SELECT wydawnictwa.Nazwa FROM książki INNER JOIN wydawnictwa ON książki.ID_wydawnictwa=wydawnictwa.ID_wydawnictwa WHERE książki.ID_ksiązki=$idk");
								$wydawnictwo ="";
								while($row2 = mysqli_fetch_row($zap2))
								{
									$wydawnictwo .= ", wyd.: ".$row2[0];	
								}

								echo '<tr><th scope="col">'.$row[0].$autorzy.$wydawnictwo.'</th><td>'.$row[1].'</td><td>'.$row[2].'</td></tr>';
								$suma += $row[2];
							}
						echo '</table>';

						$query = $poloczenie->query("SELECT Rabat FROM zamówienia WHERE ID_zamowienia = $idz");
						$row1 = mysqli_fetch_row($query);

						@$suma = $suma - ($suma * ($row1[0] * 0.01));
						echo '<span class="float-right" style="font-size: 18px;"><strong>Suma z rabatem: </strong>'.$suma.' PLN</span>';
						$poloczenie->close();
					}
				}catch(Exception $e){
					echo '<span style="color:red;"> Błąd serwera. Przepraszamy.</span>';
					echo '<br/>Info o błędzie:'.$e;
				}
				?>
            </div>

		</main>

		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="../js/bootstrap.min.js"></script>

	</body>
</html>