<?php

    session_start();

    if (!isset($_SESSION['log_in']))
    {
        header("Location: index.php");
        exit();
    }

    if(isset($_SESSION['user']) == true){
		$login = $_SESSION['user'];
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
			$query = "SELECT * FROM administratorzy WHERE Nazwa_użytkownika='$login'";

			$result = $conn->query($query);

			if (!$result)
			{
				throw new Exception($conn->error);
			}

			else
			{
				$row = $result->fetch_assoc();
				$uzytkownik = $row['Nazwa_użytkownika'];
                $mail = $row['Adres_email'];
			}
		
			$result->close();

			$conn->close();
		}

	}

	catch(Exception $error) 
	{
		echo "Błąd serwera. Przepraszamy";
	}

    if(isset($_POST['nazwauz']))
    {
        $ok1 = true;
        $ok2 = true;
        $user = $_POST['nazwauz'];

        if((strlen($user)<5) || (strlen($user)>15)){
			$ok1 = false;
			$_SESSION['err_nick'] = "<script> document.getElementById('un').innerHTML = 'Nazwa użytkownika musi zawierać od 5 znaków do 15 znaków'; </script>";
            $uzytkownik = $user;
        }

		if(ctype_alnum($user) == false){
			$ok1 = false;
			$_SESSION['err_nick'] = "<script> document.getElementById('un').innerHTML = 'Nazwa użytkownika musi składać się tylko z liter i cyfr (bez polskich znaków)'; </script>";
            $uzytkownik = $user;
        }

        $email = $_POST['email'];

        $mailB = filter_var($email, FILTER_SANITIZE_EMAIL);

		if((filter_var($mailB, FILTER_VALIDATE_EMAIL) == false) || ($mailB != $email)){
			$ok2 = false;
			$_SESSION['err_mail'] = "<script> document.getElementById('emr').innerHTML = 'Nieprawidłowy adres e-mail'; </script>";
            $mail = $email;
        }

        require_once "connect.php";
        mysqli_report(MYSQLI_REPORT_STRICT);

        try{
            $poloczenie = new mysqli($host, $db_user, $db_pass, $db_name);
            if($poloczenie->connect_errno != 0){
                throw new Exception(mysqli_connect_errno());
            }else{

                $rez = $poloczenie->query("SELECT ID_administratora FROM administratorzy WHERE Adres_email='$email'");

				if(!$rez) throw new Exception($poloczenie->error);

				$ile_maili = $rez->num_rows;
				if(($mail!=$email) && ($ile_maili > 0)){
					$ok2 = false;
					$_SESSION['err_mail'] = "<script> document.getElementById('emr').innerHTML = 'Istnieje już konto o takim adresie e-mail'; </script>";
                    $mail = $email;
				}

                $rez1 = $poloczenie->query("SELECT ID_administratora FROM administratorzy WHERE Nazwa_użytkownika='$user'");

				if(!$rez1) throw new Exception($poloczenie->error);

				$ilu_us= $rez1->num_rows;
				if(($user!=$uzytkownik) && ($ilu_us > 0)){
					$ok1 = false;
					$_SESSION['err_nick'] = "<script> document.getElementById('un').innerHTML = 'Istnieje już konto o takiej nazwie użytkownika'; </script>";
                    $uzytkownik = $user;
				}

                $rezultat = $poloczenie->query("SELECT * FROM administratorzy WHERE Nazwa_użytkownika='$login'");

                $row = $rezultat->fetch_assoc();

                $id = $row['ID_administratora'];

                if(!$rezultat) throw new Exception($poloczenie->error);

                if($ok1 == true && $ok2 == true){

                    if($poloczenie->query(
                    "UPDATE administratorzy SET Nazwa_użytkownika='$user', Adres_email='$email' WHERE ID_administratora='$id'"
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
        <link rel="stylesheet" href="css/ustawienia.css">
        <script src="js/ustawienia.js"></script>
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

                <h2 class="mb-4"><i class="fas fa-cogs mr-2"></i>Ustawienia</h2>

                <div class="d-flex justify-content-center">
                    <a href="../ksiegarnia.php" class="btn btn-primary d-block mb-4" role="button"><i class="fas fa-arrow-left mr-2"></i>Powrót</a>
                </div>

                <form action="" method="post" autocomplete="off">

                    <div class="form-check text-center mb-4">
						<label id="en"><input class="form-check-input" type="checkbox" id="enable" onchange="enble()"> Zmień ustawienia</label>
					</div>

                    <div class="form-group">
                        <label>Nazwa użytkownika</label>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><span class="fas fa-user"></span></div>
                            </div>

                            <input type="text" id="username" name="nazwauz" class="form-control bg-dark text-light mr-2" placeholder="Nazwa użytkownika" value="<?php echo $uzytkownik ?>" disabled>

                        </div>
                        <span style="font-weight: bold; text-shadow: 0 0 15px white;" class="text-danger form-group" id="un"></span>
                    </div>

                    <?php
                    if(isset($_SESSION['err_nick'])){
                        echo $_SESSION['err_nick'];
                        unset($_SESSION['err_nick']);
                    }
                    ?>

                    <div class="form-group">
                        <label>Adres e-mail</label>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><span class="fas fa-at"></span></div>
                            </div>

                            <input type="text" id="email_address" name="email" class="form-control bg-dark text-light mr-2" placeholder="Adres e-mail" value="<?php echo $mail
                             ?>" disabled>

                        </div>
                        <span style="font-weight: bold; text-shadow: 0 0 15px white;" class="text-danger form-group" id="emr"></span>
                    </div>

                    <?php
                    if(isset($_SESSION['err_mail'])){
                        echo $_SESSION['err_mail'];
                        unset($_SESSION['err_mail']);
                    }
                    ?>     

                    <span style="font-weight: bold; text-shadow: 0 0 15px white;" class="d-block text-center text-danger">Po zatwierdzeniu zmian nastąpi automatyczne wylogowanie</span>   

                    <button id="submit" class="btn btn-warning btn-block mt-4 mb-4" type="submit" disabled><i class="fas fa-pen mr-2"></i>Zapisz zmiany</button>
                    <span class="form-group" style="color:#FF9900; text-shadow: 0px 0px 10px black;" id="zapiszzmiany"></span>

                    <?php
						if(isset($_SESSION['udanyupdate'])){
							echo $_SESSION['udanyupdate'];
							unset($_SESSION['udanyupdate']);
						}
					?>

                    <div class="form-group">
                        <label>Hasło</label> 
                        <div><a href="zmiana_hasla.php" class="btn btn-info" role="button"><i class="fas fa-key mr-2"></i>Zmień</a></div>
                    </div>

                </form>

            </div>

        </main>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	    <script src="../js/bootstrap.min.js"></script>
        
    </body>

</html>