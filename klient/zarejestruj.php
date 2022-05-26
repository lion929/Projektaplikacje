<?php

	session_start();
    if(!isset($_SESSION['udanarejestracja'])){
        header('Location: index.php');
        exit();
    }else{
        unset($_SESSION['udanarejestracja']);
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
		<script src="js1/funkcje.js"></script>
	</head>

	<body>
		<div class="container">

			<div class="row">
				<div class="col-sm-12">
					<h1 class="ml-auto mr-auto mt-4 mb-4">Konto zostało utworzone</h1>
				</div>
			</div>

			<div id="form" class="login-form col-md-4 ml-auto mr-auto">

				<a href="index.php"><button class="btn btn-warning d-block ml-auto mr-auto col-12" type="button">Przejdź do strony logowania</button></a>
				
			</div>

		</div>

		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="js/bootstrap.min.js"></script>

	</body>
</html>