<?php

    session_start();

    if (!isset($_SESSION['log_in']))
    {
        header("Location: ../index.php");
        exit();
    }

    $idz = $_GET['id'];
    $_SESSION['idz'] = $_GET['id'];

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Księgarnia internetowa</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <link rel="stylesheet" href="../css/bootstrap.min.css">
		<link href="../glyphicons/_glyphicons.css" rel="stylesheet">
        <link rel="icon" href="../images/favikon.png" type="image/png">
        <link rel="stylesheet" href="css/klienci.css">
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
                        <a class="nav-link" href="../ksiegarnia.php" target=""><i class="fas fa-home mr-2"></i>Strona główna</a>
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

            <nav class="navbar navbar-light navbar-expand-lg">

				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#nav">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse" id="nav">

					<form class="form-inline ml-auto mr-auto">

                        <a href="zamowienia.php" class="btn text-light bg-warning mr-5" type="button"><i class="fas fa-arrow-left"></i></a>

					</form>

				</div>
			</nav>

            <div class="container col-sm-6">

                <div class="table-responsive">
                    <table class="table table-primary table-striped" id="table">
                        <thead>
                            <tr>
                              <th scope="col">Nr faktury</th>
                              <th scope="col">Data wystawienia</th>
                              <th scope="col">Usuń</th>
                            </tr>
                          </thead>

                          <tbody>
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
                                            $query = "SELECT faktury.ID_faktury, faktury.Nr_faktury, faktury.Data_wystawienia FROM zamówienia INNER JOIN faktury ON zamówienia.ID_faktury = faktury.ID_faktury WHERE zamówienia.ID_zamowienia = $idz";
                                            $result = $conn->query($query);

                                            if (!$result)
                                            {
                                                echo throw new Exception($conn->error);
                                            }

                                            else
                                            {
                                                while ($row = $result->fetch_assoc())
                                                {
                                                    $id = $row['ID_faktury'];

                                                    echo "<tr id='row$id'><td><a class='text-dark' href='generatorfaktur.php?numer=".$row['Nr_faktury']."&data=".$row['Data_wystawienia']."&id=".$idz."'>".$row['Nr_faktury']."</a></td><td>".$row['Data_wystawienia']."</td>";
                                                    echo "<td><button class='btn btn-danger' title='Usuń' onclick='delete_row($id)'><i class='fas fa-trash-alt'></i></button></td></tr>";
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
                            </tbody>

                            <script>
                                function searchFunction() 
                                {
                                    var input = document.getElementById("search");
                                    var filter = input.value.toUpperCase();
                                    var table = document.getElementById("table");
                                    var rows = table.getElementsByTagName("tr");
                                    var radios = document.getElementsByName("radiobtn");
                                    var td, txtValue, el;

                                    for(var i=0; i<radios.length; i++)
                                    {
                                        if(radios[i].checked==true)
                                            el=radios[i].value;
                                    }
                                    
                                    for(var j=0; j<rows.length; j++) 
                                    {
                                        td = rows[j].getElementsByTagName("td")[el];

                                        if(td) 
                                        {   
                                            txtValue = td.textContent || td.innerText;
                                            if (txtValue.toUpperCase().indexOf(filter) > -1) 
                                            {
                                                rows[j].style.display = "";
                                            } 
                                            
                                            else 
                                            {
                                                rows[j].style.display = "none";
                                            }
                                        }
                                    }    
                                }
                            </script>
                            
                    </table>
                </div>

            </div>

        </main>

        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	    <script src="../js/bootstrap.min.js"></script>

        <script>
            function sleep()
            {
                alert("Pomyślnie usunięto rekord");
            }
        
            function delete_row(id)
            {
                $.ajax({
                    url: "usuwanie/faktury_usuwanie.php",
                    type: "get",
                    data: "id="+id,
                    success: function(data)
                    { 
                       if(data==1)
                       {
                            $("#row" + id).remove();
                            setTimeout(() => {
                                sleep()
                            }, 100);
                       }

                       else
                       {
                           alert("Błąd serwera. Przepraszamy");
                       }
                    }
                });
            }
        </script>
        
    </body>

</html>