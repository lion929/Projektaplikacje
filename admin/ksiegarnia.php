<?php

    session_start();

    if (!isset($_SESSION['log_in']))
    {
        header("Location: index.php");
        exit();
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Księgarnia internetowa</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="icon" href="./images/favikon.png" type="image/png">
		<link href="glyphicons/_glyphicons.css" rel="stylesheet">
        <link rel="stylesheet" href="css1/ksiegarnia.css">
        <link rel="stylesheet" href="subpages/css/ustawienia.css">
        <link href="https://fonts.googleapis.com/css?family=Orbitron" rel="stylesheet" type="text/css">
        <script src="js1/funkcje.js"></script>
        <script src="subpages/js/ustawienia.js"></script>
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

                    <li class="nav-item mr-4 active">
                        <a class="nav-link"href="ksiegarnia.php"><i class="fas fa-home mr-2"></i>Strona główna</a>
                    </li>

                    <li class="nav-item mr-4">
                        <a class="nav-link" href="subpages/klienci.php"><i class="fas fa-users mr-2"></i>Klienci</a>
                    </li>

                    <li class="nav-item mr-4">
                        <a class="nav-link" href="subpages/ksiazki.php"><i class="fas fa-book mr-2"></i>Książki</a>
                    </li>

                    <li class="nav-item mr-4">
                        <a class="nav-link" href="subpages/autorzy.php"><i class="fas fa-users mr-2"></i>Autorzy</a>
                    </li>

                    <li class="nav-item mr-4">
                        <a class="nav-link" href="subpages/wydawnictwa.php"><i class="fas fa-book-open mr-2"></i>Wydawnictwa</a>
                    </li>

                    <li class="nav-item mr-4">
                        <a class="nav-link" href="subpages/kategorie.php"><i class="fas fa-clipboard-list mr-2"></i>Kategorie</a>
                    </li>

                    <li class="nav-item mr-4">
                        <a class="nav-link" href="subpages/zamowienia.php"><i class="fas fa-shopping-cart mr-2"></i>Zamówienia</a>
                    </li>
                   
                    <li class="nav-item mr-4">
                        <a id="logout" class="nav-link" href="wyloguj.php"><i class="fas fa-power-off mr-2"></i>Wyloguj</a>                   
                    </li>

                </ul>
          
            </div>

        </nav>

        <main>

            <div class="container">

                <div class="row mb-3">
					<div class="col-sm-6">
                        <a class="text-light" href="subpages/ustawienia.php"><i class="fas fa-cog mr-2"></i>Ustawienia</a>
                    </div>
                    <div class="col-sm-6">
                        <span id="clock" class="float-right"></span>
                        <script>
                            time();
                        </script>
					</div>
				</div>

					<h2 id="welcome" class="mb-3">Witaj <?php echo $_SESSION['user']; ?>!</h2>

                <div>
					<img src="images/admin1.png" class="d-block ml-auto mr-auto img-fluid">
				</div>

                <div class="mt-4">
					<span id="date" class="d-block ml-auto mr-auto"></span>
                    <script>
                        date();
                    </script>
				</div>

            </div>

        </main>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	    <script src="js/bootstrap.min.js"></script>
        
    </body>

</html>