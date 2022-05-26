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
		<link rel="stylesheet" href="css/ksiazki.css">
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

					<form class="form-inline mr-auto" action="ksiazki2.php" method="post">
						<div class="input-group">
        					<div class="input-group-prepend">
								<div class="input-group-text"><span class="glyphicon glyphicon-search"></span></div>
							</div>
							<input class="form-control" type="search" name="szukaj" placeholder="Wpisz tytuł książki" autocomplete="off">
						</div>
						<button style="background-color: #66CCFF;" class="ml-2 btn btn-light" type="submit">Szukaj</button>
					</form>

					<div id="buttons">
						<a class="btn btn-dark glyphicon glyphicon-home" href="../ksiegarnia1.php" role="button" title="Strona główna"></a>
						<a class="btn btn-dark glyphicon glyphicon-log-out" href="../wyloguj.php" role="button" title="Wyloguj"></a>
					</div>
				</div>
			</nav>
		</header>

		<main>

			<div class="container-fluid">
                <div class="container-group col-4 col-md-3 col-lg-2" id="div1">

                   <form action="ksiazki1.php" method="post" autocomplete="off">
					<div class="h2 container-group border-top"> Autor </div>	
						<div class="form-group">
						<?php
						require_once "connect.php";
						mysqli_report(MYSQLI_REPORT_STRICT);
						try{
							$poloczenie = new mysqli($host, $db_user, $db_pass, $db_name);
							if($poloczenie->connect_errno != 0){
								throw new Exception(mysqli_connect_errno());
							}else{
								$query = $poloczenie->query("SELECT * FROM autorzy");
								while($row = mysqli_fetch_row($query)){
									echo '<label><input type="checkbox" name="autor[]" value="'.$row[2].'"> '.$row[1].' '.$row[2].'</label><br/>';
								}
								$poloczenie->close();
							}
						}catch(Exception $e){
							echo '<span style="color:red;"> Błąd serwera. Przepraszamy.</span>';
							echo '<br/>Info o błędzie:'.$e;
						}
						?>
						</div>
					<div class="h2 container-group border-top"> Wydawnictwo </div>
						<div class="form-group">
						<?php
						require_once "connect.php";
						mysqli_report(MYSQLI_REPORT_STRICT);
						try{
							$poloczenie = new mysqli($host, $db_user, $db_pass, $db_name);
							if($poloczenie->connect_errno != 0){
								throw new Exception(mysqli_connect_errno());
							}else{
								$query = $poloczenie->query("SELECT * FROM wydawnictwa");
								while($row = mysqli_fetch_row($query)){
									echo '<label><input type="checkbox" name="wydawnictwo[]" value="'.$row[1].'"> '.$row[1].'</label><br/>';
								}
								$poloczenie->close();
							}
						}catch(Exception $e){
							echo '<span style="color:red;"> Błąd serwera. Przepraszamy.</span>';
							echo '<br/>Info o błędzie:'.$e;
						}
						?>
						</div>
					<div class="h2 container-group border-top"> Rok wydania </div>
						<div class="form-group">
						<input class="form-control" typ="text" name="rokwydania" placeholder="Wprowadź..">
						</div>
					<div class="h2 container-group border-top"> Cena </div>
						<div class="form-group">
							<input class="form-control mb-2" typ="text" name="mincena" id="odcena" placeholder="Od-zł">
							<input class="form-control" typ="text" name="maxcena" id="docena" placeholder="Do-zł">
						</div>
						<button id="submit" class="btn btn-dark btn-block mt-4 mb-2" type="submit">Filtruj</button>
						<button id="cl" class="btn btn-danger btn-block mb-3" type="reset">Wyczyść</button>
				   </form>
                </div>
				<div class="d-block ml-auto col-8 col-sm-8 col-md-9 col-lg-10 container-group border-left">
					
					<?php

						require_once "connect.php";
						mysqli_report(MYSQLI_REPORT_STRICT);
						try{
							$poloczenie = new mysqli($host, $db_user, $db_pass, $db_name);
							if($poloczenie->connect_errno != 0){
								throw new Exception(mysqli_connect_errno());
							}else{

								$page = isset($_GET['page']) ? intval($_GET['page'] - 1) : 1;

								$limit = 10;
                    			$from = $page * $limit;
								$query = $poloczenie->query(
									"SELECT książki.Tytuł, książki.Rok_wydania, książki.Cena, książki.Liczba_sztuk, wydawnictwa.Nazwa, kategorie.Nazwa, książki.ID_ksiązki
									FROM 
									(SELECT * FROM książki LIMIT $from, $limit) książki 
									INNER JOIN wydawnictwa ON wydawnictwa.ID_wydawnictwa=książki.ID_wydawnictwa 
									
									INNER JOIN kategorie ON kategorie.ID_kategorii=książki.ID_kategorii"
								);

								$query1 = $poloczenie->query("SELECT ID_ksiązki FROM książki");

								$ile_rekordow = $query1->num_rows;
								$count = $ile_rekordow;
                    			$allpage = ceil($count / $limit);

								if(!$query) throw new Exception($poloczenie->error);
								if(!$query1) throw new Exception($poloczenie->error);

								if($ile_rekordow != 0){
									echo '<div class="container-group row border-top">';
									while($row = mysqli_fetch_row($query)){

										$zap1 = $conn->query("SELECT autorzy.Imie, autorzy.Nazwisko FROM książki_autorzy INNER JOIN autorzy ON książki_autorzy.ID_autora = autorzy.ID_autora WHERE książki_autorzy.ID_książki = ".$row[6]."");
												$autorzy = "";
												while($row1 = mysqli_fetch_assoc($zap1))
                                                {
                                                    $autorzy .= " ".$row1['Imie'];	
                                                    $autorzy .= " ".$row1['Nazwisko'].",";
								                }
											
											echo '<div class="thumbnail col-10 mt-3 mb-3 col-md-4 col-sm-4 col-lg-2 border-bottom d-flex flex-column" style="text-align:center;"><a href="book.php?tytul='.$row[0].'&rokwydania='.$row[1].'&cena='.$row[2].'&liczbasztuk='.$row[3].'&wydawnictwo='.$row[4].'&kategoria='.$row[5].'&id='.$row[6].'&autor='.$autorzy.'" style="text-decoration:none; color:black;">'; 
												echo '<img src="../images/ksiazki/'.$row[0].'.jpg" class="mb-2 d-block ml-auto mr-auto ksiazki" alt="Brak miniaturki">';
												echo '<div class="caption"><h5> '.$row[0].' </h5>';
												
													echo '<span>Autor: '.$autorzy.'</span><br/>';
													echo '<span>Wydawnictwo: '.$row[4].' </span><br/>';
													echo '<b><span>Cena: '.$row[2].' zł</span></b><br/>';
													if($row[3] >0 ){
														echo '<span class="text-success" style="font-weight:bold;"><i class="fa fa-check-circle" aria-hidden="true"></i> Dostępne w liczbie: '.$row[3].' szt.</span>';
													}
													else
														echo '<span class="text-danger" style="font-weight:bold;"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Chwilowo niedostępne</span>';
												echo '</div></a>';
												
												if($row[3] >0)
													echo '<a class="mt-auto" href="koszyk.php?tytul='.$row[0].'&ilosc=1&cena='.$row[2].'&id='.$row[6].'" style="text-decoration:none;"><button class="btn btn-secondary btn-block mb-2 mt-auto" type="submit">Dodaj do koszyka</button></a>';
												else
													echo '<button class="btn btn-secondary btn-block mb-2 disabled mt-auto" type="submit">Dodaj do koszyka</button>';
												
											echo '</div>';	
									}
									echo '</div>';
								}else{
									echo '<h2>Brak danych do wyświetlenia.</h2>';
									echo "<a href='ksiazki.php?page=1' class='btn btn-primary mt-2'><i class='fas fa-arrow-left mr-2'></i>Powrót</a>";
								}
								$poloczenie->close();
								$przelaczwstecz = ($allpage != 1) ? (($page+1)-1) : 1;
								$przelaczwprzod = ($allpage != 1) ? (($page+1)+1) : 1;
								echo '<ul class="pagination">';
								echo '<li class="page-item"><a class="page-link bg-secondary text-light" href="ksiazki.php?page='.$przelaczwstecz.'">&laquo;</a></li>';

								for($i = 1; $i <= $allpage; $i++){
									
									$bold = ($i == ($page + 1)) ? 'class="page-item active"' : 'class="page-item"';
									$bold1 = ($i == ($page + 1)) ? 'class="page-link bg-dark"' : 'class="page-link bg-light text-dark"';
									echo '<li '.$bold.'><a '.$bold1.' href="ksiazki.php?page='.$i.'">'.$i.'</a></li> ';
								}
								echo '<li class="page-item"><a class="page-link bg-secondary text-light" href="ksiazki.php?page='.$przelaczwprzod.'">&raquo;</a></li>';
								echo '</ul>';
							}
						}catch(Exception $e){
							echo '<span style="color:red;"> Błąd serwera. Przepraszamy.</span>';
							echo '<br/>Info o błędzie:'.$e;
						}
					?>
				</div>
			</div>

		</main>

		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="../js/bootstrap.min.js"></script>
	</body>
	
</html>