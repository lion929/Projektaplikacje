<?php

	session_start();

	if (isset($_SESSION['log_in']) && $_SESSION['log_in'] == true)
	{
		header("Location: ksiegarnia.php");
		exit();
	}

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Logowanie</title>
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css1/logowanie.css">
		<link href="glyphicons/_glyphicons.css" rel="stylesheet">
		<link rel="icon" href="./images/favikon.png" type="image/png">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
		<script src="js1/funkcje.js"></script>
	</head>

	<body>

		<div class="container">

			<div class="mt-3 mb-3">
				<h1 class="ml-auto mr-auto">Panel administratora</h1>
			</div>
			
			<div class="d-flex justify-content-center mb-2">
				<img src="images/book.png" alt="book">
				<img src="images/book.png" alt="book">
				<img src="images/book.png" alt="book">
				<img src="images/book.png" alt="book">
			</div>

			<div id="form" class="login-form col-md-4 bg-dark pt-5 pb-5 pl-4 pr-4 ml-auto mr-auto">

				<h2 class="mb-5">Logowanie</h2>

				<form action="zaloguj.php" method="post" autocomplete="off">
					<div class="form-group">
						<label>Login</label>
						<div id="info" class="text-warning"><label>Nazwa użytkownika lub adres e-mail</label></div>

						<div class="input-group">
							<div class="input-group-prepend">
								<div class="input-group-text"><span class="fas fa-user"></span></div>
							</div>

							<input type="text" id="login" name="log" class="form-control" placeholder="Login" required value="<?php if(isset($_COOKIE['login'])) { echo $_COOKIE['login']; }; ?>">
						</div>
					</div>

					<div class="form-group">
						<div class="input-group">
							<div class="input-group-prepend">
								<div class="input-group-text"><span class="fas fa-lock"></span></div>
							</div>

							<input type="password" name="pass" class="form-control" placeholder="Hasło">
						</div>
					</div>

					<div class="form-group">
						<label><input type="checkbox" id="check" name="remember">&nbsp;&nbsp;Zapamiętaj login</label>
					</div>

					<button id="submit" class="btn btn-warning btn-block" type="submit">Zaloguj</button>

				</form>

				<?php

					if(isset($_SESSION['error']))
					{
						echo $_SESSION['error'];
					}

				?>

			</div>

			<div class="d-flex justify-content-center mt-2">
				<img src="images/book.png" alt="book">
				<img src="images/book.png" alt="book">
				<img src="images/book.png" alt="book">
				<img src="images/book.png" alt="book">
			</div>

		</div>

		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="js/bootstrap.min.js"></script>

	</body>

</html>