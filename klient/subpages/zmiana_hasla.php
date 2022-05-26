<?php

    session_start();

    if (!isset($_SESSION['log_in1']))
    {
        header("Location: ../index.php");
        exit();
    }

	if(isset($_POST['pass'])){
        $ok = true;
        $nowehaslo1 = $_POST['pass'];
        $nowehaslo2 = $_POST['repeat'];

        if(isset($_SESSION['user1']) == true){
            $login = $_SESSION['user1'];
        }

        if((strlen($nowehaslo1)<8) || (strlen($nowehaslo1))>20){
			$ok = false;
			$_SESSION['err_haslo'] = "<script> document.getElementById('h1').innerHTML = 'Hasło musi zawierać od 8 do 20 znaków'; </script>";
		}

        if($nowehaslo1 != $nowehaslo2){
            $ok = false;
            $_SESSION['err_haslo1'] = "<script> document.getElementById('h2').innerHTML = 'Hasła muszą być takie same'; </script>";
        }

        $haslo_hash = password_hash($nowehaslo1, PASSWORD_DEFAULT);

        require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);

		try{
			$poloczenie = new mysqli($host, $db_user, $db_pass, $db_name);
			if($poloczenie->connect_errno != 0){
				throw new Exception(mysqli_connect_errno());
			}else{

                $rezultat = $poloczenie->query("SELECT * FROM klienci WHERE Nazwa_użytkownika='$login'");

                $row = $rezultat->fetch_assoc();

                $id = $row['ID_klienta'];

                if(!$rezultat) throw new Exception($poloczenie->error);

				if($ok == true){
					
					if($poloczenie->query(
					"UPDATE klienci SET Hasło='$haslo_hash' WHERE ID_klienta='$id'"
					)){
						header("Location: ../wyloguj.php");
					}else{
						throw new Exception($poloczenie->error);
					}

				}
				$poloczenie->close();
			}

		}catch (Exception $e){
			echo '<span style="color:red;"> Błąd serwera. Przepraszamy</span>';
			echo '<br/>Info o błędzie:'.$e;
		}
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

            <div class="container col-md-4">

                <h2 class="mb-4"><i class="fas fa-user-shield mr-2"></i>Zmiana hasła</h2>

                <form action="" method="post">
                    <div class="form-group">
                        <label>Nowe hasło</label>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text" name="change_data"><span class="fas fa-key"></span></div>
                            </div>

                            <input type="password" id="password" name="pass" class="form-control bg-dark text-light" placeholder="Nowe hasło">
                        </div>
						<span class="form-group" id="h1"></span>
                    </div>

					<?php
                        if(isset($_SESSION['err_haslo'])){
                            echo $_SESSION['err_haslo'];
                            unset($_SESSION['err_haslo']);
                        }
                    ?>

                    <div class="form-group">
                        <label>Powtórz hasło</label>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text" name="change_data"><span class="fas fa-key"></span></div>
                            </div>

                            <input type="password" id="repat_pass" name="repeat" class="form-control bg-dark text-light" placeholder="Powtórz hasło">
                        </div>
						<span class="form-group" id="h2"></span>
                    </div>

					<?php
						if(isset($_SESSION['err_haslo1'])){
							echo $_SESSION['err_haslo1'];
							unset($_SESSION['err_haslo1']);
						}
                    ?>

					<span id="warning" style="color: red; font-weight: bold; font-size: 14px;">Uwaga! Po zatwierdzeniu zmian nastąpi automatyczne wylogowanie</span>

                    <button id="submit" class="btn btn-primary btn-block mt-4 mb-4" type="submit"><i class="fas fa-check mr-2"></i>Zatwierdź</button>
					<span class="form-group" style="font-weight: bold; color: green;" id="zapiszzmiany"></span>

					<?php
						if(isset($_SESSION['nowehaslo'])){
							echo $_SESSION['nowehaslo'];
							unset($_SESSION['nowehaslo']);
						}
                	?>

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