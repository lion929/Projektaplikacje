<?php

    session_start();

    if (!isset($_SESSION['log_in']))
    {
        header("Location: index.php");
        exit();
    }

    if(isset($_POST['pass'])){
        $ok = true;
        $nowehaslo1 = $_POST['pass'];
        $nowehaslo2 = $_POST['repeat'];

        if(isset($_SESSION['user']) == true){
            $login = $_SESSION['user'];
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

                $rezultat = $poloczenie->query("SELECT * FROM administratorzy WHERE Nazwa_użytkownika='$login'");

                $row = $rezultat->fetch_assoc();

                $id = $row['ID_administratora'];

                if(!$rezultat) throw new Exception($poloczenie->error);

				if($ok == true){
					
					if($poloczenie->query(
					"UPDATE administratorzy SET Hasło='$haslo_hash' WHERE ID_administratora='$id'"
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
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="icon" href="../images/favikon.png" type="image/png">
		<link href="../glyphicons/_glyphicons.css" rel="stylesheet">
        <link rel="stylesheet" href="css/zmiana_hasla.css">
        <link href="https://fonts.googleapis.com/css?family=Orbitron" rel="stylesheet" type="text/css">
    </head>

    <body>

        <header>
            <h1>Admin</h1>
        </header>

        <nav class="navbar navbar-dark bg-dark navbar-expand-lg">
            
            <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#list">
                <span class="navbar-toggler-icon"></span>&nbsp;&nbsp;Menu
            </button>
          
            <div class="collapse navbar-collapse" id="list">
        
                <ul class="navbar-nav ml-auto mr-auto">	

                    <li class="nav-item mr-4">
                        <a class="nav-link" href="../ksiegarnia.php"><i class="fas fa-home mr-2"></i>Strona główna</a>
                    </li>

                    <li class="nav-item mr-4">
                        <a class="nav-link" href="klienci.php"><i class="fas fa-users mr-2"></i>Klienci</a>
                    </li>

                    <li class="nav-item mr-4">
                        <a class="nav-link" href="ksiazki.php"><i class="fas fa-book mr-2"></i>Książki</a>
                    </li>

                    <li class="nav-item mr-4">
                        <a class="nav-link" href="autorzy.php"><i class="fas fa-users mr-2"></i>Autorzy</a>
                    </li>

                    <li class="nav-item mr-4">
                        <a class="nav-link" href="wydawnictwa.php"><i class="fas fa-book-open mr-2"></i>Wydawnictwa</a>
                    </li>

                    <li class="nav-item mr-4">
                        <a class="nav-link" href="kategorie.php"><i class="fas fa-clipboard-list mr-2"></i>Kategorie</a>
                    </li>

                    <li class="nav-item mr-4">
                        <a class="nav-link" href="zamowienia.php"><i class="fas fa-shopping-cart mr-2"></i>Zamówienia</a>
                    </li>

                    <li class="nav-item">
                        <a id="logout" class="nav-link" href="../wyloguj.php"><i class="fas fa-power-off mr-2"></i>Wyloguj</a>
                    </li>                    

                </ul>
          
            </div>
        </nav>

        <main>

            <div class="container col-md-4">

                <h2 class="mb-4"><i class="fas fa-user-lock mr-2"></i>Zmiana hasła</h2>
                <div class="d-flex justify-content-center">
                    <a href="ustawienia.php" class="btn btn-primary d-block mb-4" role="button"><i class="fas fa-arrow-left mr-2"></i>Powrót</a>
                </div>

                <form action="" method="post">
                    <div class="form-group">
                        <label for="password">Nowe hasło</label>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><span class="fas fa-key"></span></div>
                            </div>

                            <input type="password" id="password" name="pass" class="form-control bg-dark text-light" placeholder="Nowe hasło">
                        </div>
                        <span style="font-weight: bold; text-shadow: 0 0 15px white;" class="text-danger form-group" id="h1"></span>
                    </div>

                    <?php
                        if(isset($_SESSION['err_haslo'])){
                            echo $_SESSION['err_haslo'];
                            unset($_SESSION['err_haslo']);
                        }
                    ?>

                    <div class="form-group">
                        <label for="repeat_pass">Powtórz hasło</label>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><span class="fas fa-key"></span></div>
                            </div>

                            <input type="password" id="repeat_pass" name="repeat" class="form-control bg-dark text-light" placeholder="Powtórz hasło">
                        </div>
                        <span style="font-weight: bold; text-shadow: 0 0 15px white;" class="form-group text-danger" id="h2"></span>
                    </div>

                    <?php
                        if(isset($_SESSION['err_haslo1'])){
                            echo $_SESSION['err_haslo1'];
                            unset($_SESSION['err_haslo1']);
                        }
                    ?>

                    <span style="font-weight: bold; text-shadow: 0 0 15px white;" class="d-block text-center text-danger">Po zatwierdzeniu zmian nastąpi automatyczne wylogowanie</span>

                    <button id="submit" class="btn btn-warning btn-block mt-4" type="submit"><i class="fas fa-check mr-2"></i>Zatwierdź</button>
                    <span class="form-group" style="color:#FF9900; text-shadow: 0px 0px 10px black;" id="zapiszzmiany"></span>
                </form>

                <?php
                    if(isset($_SESSION['nowehaslo'])){
                        echo $_SESSION['nowehaslo'];
                        unset($_SESSION['nowehaslo']);
                    }
                ?>

            </div>

        </main>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	    <script src="../js/bootstrap.min.js"></script>
        
    </body>

</html>