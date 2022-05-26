<?php

	session_start();

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
			$login = $_POST['log'];
			$password = $_POST['pass'];

			$login = htmlentities($login, ENT_QUOTES, "UTF-8");

			$result = $conn->query(sprintf("SELECT * FROM klienci WHERE Nazwa_użytkownika = '%s' OR Adres_email = '%s'",
			mysqli_real_escape_string($conn, $login), mysqli_real_escape_string($conn, $login)));
			
			if (!$result)
			{
				throw new Exception($conn->error);
			}

			else
			{
				$count = $result->num_rows;

				if ($count > 0)
				{
					$row = $result->fetch_assoc();

					if (password_verify($password, $row['Hasło']))
					{
						$_SESSION['log_in1'] = true;
				
						$_SESSION['user1'] = $row['Nazwa_użytkownika'];

						unset($_SESSION['error']);

						if(isset($_POST['remember']))
						{
							setcookie('login1', $login, time()+168*3600);
						}

						$result -> close();

						header("Location: ksiegarnia1.php");
					}

					else
					{
						$_SESSION['error1'] = '<span style="color: #ff7b5a; font-weight: bold; display: block; margin: auto; text-align: center">Nieprawidłowy login lub hasło</span>';
						header("Location: index.php");
					}
				}

				else
				{
					$_SESSION['error1'] = '<span style="color: #ff7b5a; font-weight: bold; display: block; margin: auto; text-align: center">Nieprawidłowy login lub hasło</span>';
					header("Location: index.php");
				}
			}

			$conn -> close();
		}

		}

		catch(Exception $error) 
		{
			echo "Problemy techniczne. Przepraszamy";
			echo $error;
		}

?>