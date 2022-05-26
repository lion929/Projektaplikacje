<?php

    session_start();

	$idka = $_SESSION['idka'];

    if (!isset($_SESSION['log_in']))
    {
        header("Location: ../../index.php");
        exit();
    }

    if(isset($_SESSION['user']) == true){
		$login = $_SESSION['user'];
	}

    if(isset($_POST['autor'])){

		$ok = true;
		$autor = $_POST['autor'];
		$idka = $_SESSION['idka'];

		if($autor == 'wybierz')
		{
			$ok = false;
			$_SESSION['err_author'] = "<script> document.getElementById('author').innerHTML = 'Nie wybrano autora'; </script>";
		}

        require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);

		try {
			$conn = new mysqli($host, $db_user, $db_pass, $db_name);
			if($conn->connect_errno != 0){
				throw new Exception(mysqli_connect_errno());
			}

			else {

				if($ok == true){
				
					$check = $conn->query("SELECT * FROM książki_autorzy WHERE ID_książki=$idka AND ID_autora=$autor");
					if(!$check) 
						throw new Exception($conn->error);

					$count = $check->num_rows;
					if($count > 0) {
						$ok = false;
						$_SESSION['err_author'] = "<script> document.getElementById('author').innerHTML = 'Ten autor jest już przypisany do tej książki'; </script>";
					}
				}

				if($ok == true)
				{
					if($conn->query("INSERT INTO książki_autorzy VALUES ($idka, $autor)")) {

						echo "<span style='color:orange; text-align:center; display:block; font-size: 20px; font-weight:bold;'>Pomyślnie dodano rekord</span>";
	
					} 
					else {
						throw new Exception($conn->error);
					}
	
				}

				$conn->close();
			}

		}
		catch (Exception $error){
			echo 'Błąd serwera. Przepraszamy';
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
        <link rel="stylesheet" href="../../css/bootstrap.min.css">
        <link rel="icon" href="../../images/favikon.png" type="image/png">
		<link href="../../glyphicons/_glyphicons.css" rel="stylesheet">
        <link rel="stylesheet" href="css/dodawanie.css">
    </head>

    <body>

        <div id="content">

            <div class="container col-md-4">

                <h2 class="mb-4"><i class="fas fa-pencil mr-2"></i>Dodawanie rekordu</h2>

                <form action="" method="post" autocomplete="off">

					<label for="aut">Autor</label>
					<select class="form-control bg-dark text-light" id="aut" name="autor" required>
						<optgroup label="Wybierz">
							<option hidden selected value="wybierz">Wybierz</option>
							<?php
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
										$query = "SELECT * FROM autorzy";

										$result = $conn->query($query);

										if (!$result)
										{
											throw new Exception($conn->error);
										}

										else
										{
											while ($row = $result->fetch_assoc())
											{
												echo "<option value=".$row['ID_autora'].">".$row['Imie']." ".$row['Nazwisko']."</option>";
											}

											$result->close();

											$conn->close();
										}
									}

								}

								catch(Exception $error) 
								{
									echo "Problemy z odczytem danych";
								}
							?>
						</optgroup>
					</select>
					<span style="font-weight: bold; text-shadow: 0 0 15px white;" class="text-danger form-group" id="author"></span>

					<?php
						if(isset($_SESSION['err_author'])){
							echo $_SESSION['err_author'];
							unset($_SESSION['err_author']);
						}
					?>

					<button id="submit" class="btn btn-success btn-block mt-5 mb-4" type="submit"><i class="fas fa-plus mr-2"></i>Dodaj rekord</button>
					<a href="../ksiazki_autorzy.php?id=<?php echo $idka; ?>" class="btn btn-outline-warning btn-block"><i class="fas fa-arrow-left mr-2"></i>Powrót</a>

                </form>

            </div>

        </div>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	    <script src="../../js/bootstrap.min.js"></script>
        
    </body>

</html>