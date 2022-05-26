<?php

    session_start();

    if (!isset($_SESSION['log_in1']))
    {
        header("Location: ../index.php");
        exit();
    }

    if (!isset($_GET['tytul']))
    {
        header("Location: ksiazki.php");
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
		<link rel="stylesheet" href="css/ksiazki.css">
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
							<a class="nav-link dropdown-toggle active" data-toggle="dropdown" role="button" href="ksiazki.php"><i class="fas fa-book mr-2"></i>Książki</a>

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

			<article>
                <div class="container">

				 
                <?php
				
					$tytul = $_GET['tytul'];
					$rokwydania = $_GET['rokwydania'];
					$cena = $_GET['cena'];
					$wydawnictwo = $_GET['wydawnictwo'];
					$autorzy = $_GET['autor'];
					$kategoria = $_GET['kategoria'];
					$liczbasztuk = $_GET['liczbasztuk'];
					$id = $_GET['id']; 

					echo '<script>';
					echo 'function plus(){';
						echo 'var ilosc = document.getElementById("ilosc").value;';
						echo 'ilosc++;';
						echo 'if(ilosc <= '.$liczbasztuk.')';
							echo 'document.getElementById("ilosc").value = ilosc;';	
					echo '}';

					echo 'function minus(){';
						echo 'var ilosc = document.getElementById("ilosc").value;';
						echo 'ilosc--;';
						echo 'if(ilosc > 0)';
							echo 'document.getElementById("ilosc").value = ilosc;';
					echo '}';
					
					echo 'function sprawdz(){';
						echo 'var ilosc = document.getElementById("ilosc").value;';
						echo 'if(ilosc > '.$liczbasztuk.')';
							echo 'document.getElementById("ilosc").value = '.$liczbasztuk.';';	
						echo 'if(ilosc < 0 || ilosc == "0")';
							echo 'document.getElementById("ilosc").value = "1";';	
					echo '}';
					echo '</script>';
	
                    echo '<img src="../images/ksiazki/'.$tytul.'.jpg" class="container-group float-left mb-3 mr-3" width="200px" height="300px">';
                    echo '<h2>'.$tytul.'</h2><br/>';
                    echo '<div class="float-right col-lg-3">';
                    echo '<span class="float-right h3 mr-4" style="font-size:29pt;">'.$cena.' zł</span><br/>';
					echo '<span class="float-right h3 mr-4" style="font-size:12pt;">'.$liczbasztuk.' szt.</span><br/>';
					echo '<form action="koszyk.php?tytul='.$tytul.'&cena='.$cena.'&id='.$id.'" method="post">';
                    echo '<div class="input-group mb-2 col-md-3 col-6 col-lg-8 ml-auto">';
                    echo '<div class="input-group-prepend">';
                    echo '<button class="input-group-text" onclick="minus()" type="button"><i class="fas fa-minus"></i></button>';
                    echo '</div>';
                    echo '<input class="form-control" type="text" name="iloscsztuk" value="1" id="ilosc" oninput="sprawdz()" required>';
					echo '<div class="input-group-append">';
                    echo '<button class="input-group-text" onclick="plus()" type="button"><i class="fas fa-plus"></i></button>';
					echo '</div>';
                    echo '</div>';
					if($liczbasztuk > 0)
                    	//echo '<a class="mt-auto btn btn-secondary" style="text-decoration:none; href="koszyk.php?tytul='.$tytul.'&cena='.$cena.'&id='.$id.'">Dodaj do koszyka</a>';
						echo '<button type="submit" class="btn btn-secondary form-control">Dodaj do koszyka</button>';
					else
						echo '<button class="btn btn-secondary btn-block mb-3" type="submit" disabled>Dodaj do koszyka</button>';
					echo '</form>';
                    echo '</div>';

                    echo '<span style="font-size:15pt; font-weight:bold;">Autor: '.$autorzy.'</span><br/>';
                    echo '<span style="font-size:15pt;">Rok wydania: '.$rokwydania.'</span><br/>';
                    echo '<span style="font-size:15pt;">Wydawnictwo: '.$wydawnictwo.'</span><br/>';
					echo '<span style="font-size:15pt;">Kategoria: '.$kategoria.'</span><br/>';
                    echo '<br/><br/><br/><br/><br/><br/><br/>';
                
                    echo '<h5> Opis:</h5>';
                    echo '<p>';
					$opis = implode('', file('../opisyksiazek/'.$tytul.'-opis.txt'));
					echo $opis;
                    echo '</p>';
                    echo '<br/><br/>';
                    echo '<div class="text-danger" style="font-size:14pt;"><i class="fa fa-file-pdf" aria-hidden="true"></i><a class="mb-2 text-danger" href="fragmenty.php?tytul='.$tytul.'"> Pobierz fragment książki PDF</a></div>';
					echo '<div><a href="ksiazki.php?page=1" class="btn btn-dark mt-3" role="button"><i class="fas fa-arrow-left mr-2"></i></i>Powrót</a></div>';
                ?>
                </div>
            </article>
            
		</main>

		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="../js/bootstrap.min.js"></script>
	</body>
	
</html>