<?php

	session_start();

	if(isset($_POST['imie'])){
		$ok = true;

		$imie = $_POST['imie'];
		$nazwisko = $_POST['nazwisko'];
		$ulica = $_POST['ulica'];
		$miasto = $_POST['miasto'];
		$kod_pocztowy = $_POST['kodpocztowy'];

		if ( !preg_match('/^[0-9]{2}-?[0-9]{3}$/Du', $kod_pocztowy) ) {
			$ok = false;
			$_SESSION['err_kod'] = "<script> document.getElementById('postcode').innerHTML = 'Nieprawidłowy kod pocztowy'; </script>";
		}

		$mail = $_POST['mail'];
		$mailB = filter_var($mail, FILTER_SANITIZE_EMAIL);

		if((filter_var($mailB, FILTER_VALIDATE_EMAIL) == false) || ($mailB != $mail)){
			$ok = false;
			$_SESSION['err_mail'] = "<script> document.getElementById('e_mail').innerHTML = 'Nieprawidłowy adres e-mail'; </script>";
		}

		$numer_tel = $_POST['nrtel'];

		if((strlen($numer_tel)!=9) && !is_int($numer_tel))
		{
			$ok = false;
			$_SESSION['err_tel'] = "<script> document.getElementById('phone').innerHTML = 'Nieprawidłowy numer telefonu'; </script>";
		}

		$nazwa_uzytkownika = $_POST['nazwauz'];

		if((strlen($nazwa_uzytkownika)<5) || (strlen($nazwa_uzytkownika)>15)){
			$ok = false;
			$_SESSION['err_nick'] = "<script> document.getElementById('username').innerHTML = 'Nazwa użytkownika musi zawierać od 5 znaków do 15 znaków'; </script>";
		}

		if(ctype_alnum($nazwa_uzytkownika) == false){
			$ok = false;
			$_SESSION['err_nick1'] = "<script> document.getElementById('username').innerHTML = 'Nazwa użytkownika musi składać się tylko z liter i cyfr (bez polskich znaków)'; </script>";
		}

		$haslo = $_POST['haslo'];
		$haslo1 = $_POST['haslo1'];

		if((strlen($haslo)<8) || (strlen($haslo))>20){
			$ok = false;
			$_SESSION['err_haslo'] = "<script> document.getElementById('password').innerHTML = 'Hasło musi zawierać od 8 do 20 znaków'; </script>";
		}

		if($haslo != $haslo1){
			$ok = false;
			$_SESSION['err_haslo1'] = "<script> document.getElementById('repeat').innerHTML = 'Hasła muszą być takie same'; </script>";
		}

		$haslo_hash = password_hash($haslo, PASSWORD_DEFAULT);

		$skey = "6LdppZUaAAAAAEaIXHE5uWDbDiPepvEjokTDM_Eh";

		$sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$skey.'&response='.
		$_POST['g-recaptcha-response']);

		$odpowiedz = json_decode($sprawdz);

		if($odpowiedz->success == false){
			$ok = false;
			$_SESSION['err_bot'] = "<script> document.getElementById('captcha').innerHTML = 'Potwierdź, że nie jesteś botem'; </script>";
		}

		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);

		try{
			$poloczenie = new mysqli($host, $db_user, $db_pass, $db_name);
			if($poloczenie->connect_errno != 0){
				throw new Exception(mysqli_connect_errno());
			}else{

				$rezultat = $poloczenie->query("SELECT ID_klienta FROM klienci WHERE Adres_email='$mail'");

				if(!$rezultat) throw new Exception($poloczenie->error);

				$ile_maili = $rezultat->num_rows;
				if($ile_maili > 0){
					$ok = false;
					$_SESSION['err_mail'] = "Istnieje już konto o takim adresie e-mail.";
				}

				$rezultat = $poloczenie->query("SELECT ID_klienta FROM klienci WHERE Nazwa_użytkownika='$nazwa_uzytkownika'");

				if(!$rezultat) throw new Exception($poloczenie->error);

				$ile_nazw = $rezultat->num_rows;
				if($ile_nazw > 0){
					$ok = false;
					$_SESSION['err_nick'] = "Istnieje już konto o takiej nazwie.";
				}

				if($ok == true){
					
					if($poloczenie->query(
					"INSERT INTO klienci VALUES (NULL, '$imie', '$nazwisko', '$ulica $miasto $kod_pocztowy', '$numer_tel', '$mail', '$nazwa_uzytkownika', '$haslo_hash')"
					)){
						$_SESSION['udanarejestracja']=true;
						header('Location: zarejestruj.php');
					}else{
						throw new Exception($poloczenie->error);
					}

				}

				$poloczenie->close();
			}

		}catch (Exception $e){
			echo '<span style="color:red;"> Błąd serwera. Przepraszamy.</span>';
			echo '<br/>Info o błędzie:'.$e;
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="icon" href="./images/favikon.png" type="image/png">
		<title>Rejestracja</title>
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css1/rejestracja.css">
		<link href="glyphicons/_glyphicons.css" rel="stylesheet">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
		<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	</head>

	<body>
		<div class="container">

				<h1 class="ml-auto mr-auto mt-4 mb-4">Utwórz konto</h1>

				<form action="rejestracja.php" method="post" autocomplete="off">
					<div class="form-row">
						<div class="col-md-6 mb-3">
							<label class="labels" for="imiee">Imię</label>
							<input type="text" class="form-control bg-dark text-light" name="imie" id="imiee" placeholder="Imię">
				  		</div>
					  
				  		<div class="col-md-6 mb-3">
							<label class="labels" for="nazwiskoo">Nazwisko</label>
							<input type="text" class="form-control bg-dark text-light" name="nazwisko" id="nazwiskoo" placeholder="Nazwisko">
				  		</div>
					</div>

					<div class="form-row">
				  		<div class="col-md-6 mb-3">
							<label class="labels" for="ulicaa">Ulica i numer lokalu</label>
							<input type="text" class="form-control bg-dark text-light" name="ulica" id="ulicaa" placeholder="Ulica i numer lokalu">
				 		</div>

				   		<div class="col-md-3 mb-3">
							<label class="labels" for="kod_pocztowy">Kod pocztowy</label>
							<input type="text" class="form-control bg-dark text-light" name="kodpocztowy" id="kod_pocztowy" placeholder="Kod pocztowy">
							<span id="postcode"></span>
				  		</div>

				  		<div class="col-md-3 mb-3">
							<label class="labels" for="miastoo">Miasto</label>
							<input type="text" class="form-control bg-dark text-light" name="miasto" id="miastoo" placeholder="Miasto">
				  		</div>
					</div>

					<?php
						if(isset($_SESSION['err_kod'])){
							echo $_SESSION['err_kod'];
							unset($_SESSION['err_kod']);
						}
					?>

					<div class="form-row">
						<div class="col-md-6 mb-3">
					    	<label class="labels" for="email">Adres e-mail</label>
					    	<input type="text" class="form-control bg-dark text-light" name="mail" id="email" placeholder="E-mail">
							<span id="e_mail"></span>
						</div>

                    	<div class="col-md-6 mb-3">
							<label class="labels" for="ntel">Numer telefonu</label>
							<input type="text" class="form-control bg-dark text-light" name="nrtel" id="ntel" placeholder="Numer telefonu">
							<span id="phone"></span>
				    	</div>
			  		</div>

					<?php
						if(isset($_SESSION['err_mail'])){
							echo $_SESSION['err_mail'];
							unset($_SESSION['err_mail']);
						}						
					?>

					<?php
						if(isset($_SESSION['err_tel'])){
							echo $_SESSION['err_tel'];
							unset($_SESSION['err_tel']);
						}
					?>

					<div class="form-row">
						<div class="col-md-6 mb-3">	
							<label class="labels" for="nazwau">Nazwa użytkownika</label>
							<input type="text" class="form-control bg-dark text-light" name="nazwauz" id="nazwau" placeholder="Nazwa użytkownika">
							<span id="username"></span>
						</div>

						<div class="col-md-6 mb-3">
	  						<label class="labels" for="hasloo">Hasło</label>
	  						<input type="password" class="form-control bg-dark text-light" name="haslo" id="hasloo" placeholder="Hasło">
							<span id="password"></span> 
						</div>
					</div>

					<?php
						if(isset($_SESSION['err_nick'])){
							echo $_SESSION['err_nick'];
							unset($_SESSION['err_nick']);
						}
					?>

					<?php
						if(isset($_SESSION['err_nick1'])){
							echo $_SESSION['err_nick1'];
							unset($_SESSION['err_nick1']);
						}
					?>

					<?php
						if(isset($_SESSION['err_haslo'])){
							echo $_SESSION['err_haslo'];
							unset($_SESSION['err_haslo']);
						}
					?>

					<div class="form-row">
						<div class="col-md-6 mb-3">
	  						<label class="labels" for="hasloo">Powtórz hasło</label>
	  						<input type="password" class="form-control bg-dark text-light" name="haslo1" id="haslooo" placeholder="Powtórz hasło">
							<span id="repeat"></span>
						</div>

					</div>

					<?php
						if(isset($_SESSION['err_haslo1'])){
							echo $_SESSION['err_haslo1']; 
							unset($_SESSION['err_haslo1']);
						}
					?>

					<div class="form-group">
						<label id="reg">						
							<input id="regulamin" type="checkbox" name="reg"> Akceptuję <a id="link" href="regulamin.pdf" target="_blank">regulamin</a> księgarni internetowej
						</label>
					</div>

					<div class="form-group g-recaptcha" id="re" data-sitekey="6LdppZUaAAAAAPXDnTZVPhNEWu-pZrSmvLOE9KWU"></div>
					<span id="captcha"></span>

					<?php
						if(isset($_SESSION['err_bot'])){
							echo $_SESSION['err_bot'];
							unset($_SESSION['err_bot']);
						}
					?>

					<div class="form-group">
						<button id="submit" class="btn btn-warning d-block ml-auto mr-auto col-sm-12 mt-2" type="submit">Zarejestruj</button>
					</div>

				</form>
				
				<script>
				function wyslij(){
					var sub = document.getElementById("submit");

					var imiee = document.getElementById("imiee");
					var nazwiskoo = document.getElementById("nazwiskoo");
					var ulicaa = document.getElementById("ulicaa");
					var miastoo = document.getElementById("miastoo");
					var kod_pocztowy = document.getElementById("kod_pocztowy");
					var email = document.getElementById("email");
					var numer = document.getElementById("ntel");
					var nazwau = document.getElementById("nazwau");
					var hasloo = document.getElementById("hasloo");
					var haslooo = document.getElementById("haslooo");
					var regg = document.getElementById("regulamin");

					if(
						imiee.value != "" && nazwiskoo.value != "" && ulicaa.value != "" 
						&& miastoo.value != "" && kod_pocztowy.value != ""&& email.value != "" && numer.value != ""
						&& nazwau.value != "" && hasloo.value != "" && haslooo.value != "" && regg.checked == true					
					){
						sub.disabled = false;
						sub.style.cursor = "pointer";
					}else{
						sub.disabled = true;
					}
				}
				setInterval(wyslij,1);
				</script>
			</div>


		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="js/bootstrap.min.js"></script>

	</body>	
</html>