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
		<style>
			#upbtn 
			{
				display: none;
				bottom: 0px;
				font-size: 18px;
				border-radius: 6px;
				z-index: 100;
				box-shadow: 0px 0px 10px black;
			}
		</style>
	</head>

	<body>

		<div class="d-flex justify-content-center">
            <button class="btn btn-primary position-fixed btn-block w-25" id="upbtn" type="button" title="W górę" onclick="goUp()"><i class="fas fa-angle-up"></i></button>
        </div>

        <script>
            function dispBtn()
            {
                var go_up = document.getElementById("upbtn");

                if(document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) 
                {
                    go_up.style.display = "block";
                } 
                
                else 
                {
                    go_up.style.display = "none";
                }
            }

            window.onscroll = function()
            {
                dispBtn()
            };

            function goUp() 
            {
                document.body.scrollTop = 0;
                document.documentElement.scrollTop = 0;
            }
        </script>

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
							<a class="nav-link active" href="historia.php"><i class="fas fa-shopping-bag mr-2"></i>Historia zamówień</a>
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

				<a class="btn btn-primary mb-3" href="../ksiegarnia1.php"><i class="fas fa-arrow-left mr-2"></i>Strona główna</a>

                <?php
					require_once "connect.php";
					mysqli_report(MYSQLI_REPORT_STRICT);
					try{

						$user = $_SESSION['user1'];
						$poloczenie = new mysqli($host, $db_user, $db_pass, $db_name);
						if($poloczenie->connect_errno != 0){
							throw new Exception(mysqli_connect_errno());
						}else{
							$id_kl = $poloczenie->query("SELECT ID_klienta FROM klienci WHERE Nazwa_użytkownika = '$user'");
							$r = mysqli_fetch_row($id_kl);
							$idk = $r[0];

							$zap = $poloczenie->query("SELECT zamówienia.ID_zamowienia, zamówienia.Rabat, zamówienia.Data_złożenia FROM zamówienia WHERE zamówienia.ID_klienta = $idk ORDER BY zamówienia.ID_zamowienia DESC");
							echo '<table class="table table-secondary">';
								echo '<thead class="thead-dark"><tr><th scope="col">#</th><th scope="col">Rabat %</th><th scope="col">Data złożenia</th><th scope="col">Szczegóły</th><th scope="col">Faktura</th></tr></thead>';
								while($row = mysqli_fetch_row($zap)){
									echo '<tr><th scope="col">'.$row[0].'</th><td>'.$row[1].'</td><td>'.$row[2].'</td>';
									echo  "<td><a href='szczegoly.php?id=".$row[0]."' class='btn btn-secondary'><i class='fas fa-info mr-2'></i>Szczegóły</a></td>";
									echo  "<td><a href='faktury.php?id=".$row[0]."' class='btn btn-secondary'><i class='fas fa-file-invoice-dollar mr-2'></i>Faktura</a></td></tr>";
								}
							echo '</table>';
							$poloczenie->close();
						}
					}catch(Exception $e){
						echo '<span style="color:red;"> Błąd serwera. Przepraszamy.</span>';
					}
				?>
            </div>

		</main>

		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="../js/bootstrap.min.js"></script>

	</body>
</html>