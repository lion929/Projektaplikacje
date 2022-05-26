<?php

    session_start();
	require_once "connect.php";
	mysqli_report(MYSQLI_REPORT_STRICT);

	if(!isset($_SESSION['koszyk'])) 
    {
        $_SESSION['koszyk']=array();   
    }

	if(isset($_GET['id']))
	{
		$ks = $_GET['id'];
		$conn1 = new mysqli($host, $db_user, $db_pass, $db_name);
		$query1 = $conn1->query("SELECT Liczba_sztuk FROM książki WHERE ID_ksiązki = $ks");
		$row1 = mysqli_fetch_assoc($query1);
		$id_ks = $row1['Liczba_sztuk'];

		if(isset($_POST['iloscsztuk'])) 
		{
			$tmp=array('idk'=>$_GET['id'], 'tytul'=>$_GET['tytul'],'ilosc'=>$_POST['iloscsztuk'], 'cena'=>$_GET['cena'], 'liczba'=>$id_ks);
			if(!(array_key_exists($_GET['id'], $_SESSION['koszyk']))) {

				$_SESSION['koszyk'][$_GET['id']]=$tmp;
			}
		}

		else
		{
			$tmp=array('idk'=>$_GET['id'], 'tytul'=>$_GET['tytul'],'ilosc'=>$_GET['ilosc'],'cena'=>$_GET['cena'], 'liczba'=>$id_ks);
			if(!(array_key_exists($_GET['id'], $_SESSION['koszyk']))) {

				$_SESSION['koszyk'][$_GET['id']]=$tmp;
			}
		}
	}

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Księgarnia <?php if(count($_SESSION['koszyk']) != 0) echo "(".count($_SESSION['koszyk']).")";?></title>
		<link rel="stylesheet" href="../css/bootstrap.min.css">
		<link rel="icon" href="../images/favikon.png" type="image/png">
		<link rel="stylesheet" href="css/koszyk.css">
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
		<script>
			function numRows()
			{
				var rl = document.getElementById("tabl").rows.length;
				if(rl < 2)
				{
					document.getElementById("sorder").disabled = true;
				}
				else
					document.getElementById("sorder").disabled = false;
			}
		</script>
	</head>

	<body onload="numRows()">
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

						<li class="nav-item">
							<a class="nav-link active" href="koszyk.php"><i class="fas fa-shopping-cart mr-2"></i>Koszyk</a>
						</li>

						<li class="nav-item">
							<div class="bg-danger text-center text-white rounded-circle" style="width:20px"><?php if(count($_SESSION['koszyk']) != 0) echo count($_SESSION['koszyk']);?></div>
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
			<form action="podsumowanie.php" method="post">
            <div class="container">
                <div class="d-block ml-auto col-12 col-sm-12 col-md-12 col-lg-12 container-group">
			        <h2 class="mb-4"><i class="fas fa-shopping-basket mr-3"></i>Przedmioty w koszyku:</h2>
                        <table id="tabl" class="mt-3 table">
                            <thead class="thead-dark"><tr><th></th><th>Nazwa produktu</th><th>Ilość</th><th>Cena za 1 szt.</th><th>Akcja</th></tr></thead>
							<tbody>
								<?php
									$suma = 0;
									$j = 0;
									foreach ($_SESSION['koszyk'] as $sub => $key)
									{
										$id = $key['idk'];
										echo '<tr id="row"'.$key['idk'].'"><td><img src="../images/ksiazki/'.$key['tytul'].'.jpg" class="mb-2 d-block ml-auto mr-auto ksiazki1"></td><td><b>'.$key['tytul'].'</b></td>
										<td><input type="number" name="liczbaszt'.$j.'" value="'.$key['ilosc'].'" max="'.$key['liczba'].'" min="1" style="text-align: center; border-radius: 5px;" required></td><td>'.$key['cena'].' zł</td>';
										echo "<td><a name='usun' class='btn btn-danger' title='Usuń z koszyka' href='koszyk_usuwanie.php?id=$id'><i class='fas fa-trash'></i></a></td></tr>";
										$suma += $key['cena'];
										$j++;
									}	
									
									$_SESSION['licznik'] = $j;
								?>
							</tbody>
                        </table>
						<a href="ksiazki.php?page=1" class="btn btn-light mt-3 mr-6" role="button">Wróć do sklepu</a>
						<a href="wyczysc.php" style="text-decoration:none;"><button class="btn btn-dark mt-3 ml-2" id="sorder1" data-target="wyczysc.php" type="button"><i class="fas fa-times mr-2"></i>Wyczyść koszyk</button></a>
						<button class="btn btn-dark mt-3 float-right" id="sorder" type="submit" disabled><i class="fa fa-check mr-2"></i>Przejdź dalej</button>
                </div>
            </div></form>
		</main>

		<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="../js/bootstrap.min.js"></script>
		<script>
			/*function delete_row(id)
            {
                $.ajax({
                    url: "koszyk_usuwanie.php",
                    type: "get",
                    data: "id="+id,
                    success: function()
                    {
						$("#row" + id).remove();
                    }
                });
            }*/
		</script>
	</body>
	
</html>