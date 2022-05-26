<?php

    session_start();

    if (!isset($_SESSION['log_in']))
    {
        header("Location: ../../index.php");
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
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="icon" href="../images/favikon.png" type="image/png">
		<link href="../glyphicons/_glyphicons.css" rel="stylesheet">
        <link rel="stylesheet" href="css/edycja.css">
        <link href="https://fonts.googleapis.com/css?family=Orbitron" rel="stylesheet" type="text/css">
    </head>

    <body>

        <div id="content">

            <div class="container login-form col-md-4">

                <h2 class="mb-4"><i class="fas fa-pencil mr-2"></i>Edycja</h2>

                <form action="" method="post">

                    <div class="form-group">
                        <label>Imię</label>
                        <input type="text" id="username" name="user" class="form-control bg-dark text-light mr-2" placeholder="Nazwa użytkownika" autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label>Nazwisko</label>
                        <input type="text" id="username" name="user" class="form-control bg-dark text-light mr-2" placeholder="Nazwa użytkownika" autocomplete="off">
                    </div>

                </form>

            </div>

        </div>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	    <script src="../js/bootstrap.min.js"></script>
        
    </body>

</html>