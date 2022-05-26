<?php

    session_start();

    if (!isset($_SESSION['log_in']))
    {
        header("Location: ../index.php");
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
		<link href="../glyphicons/_glyphicons.css" rel="stylesheet">
        <link rel="icon" href="../images/favikon.png" type="image/png">
        <link rel="stylesheet" href="css/klienci.css">
        <link href="https://fonts.googleapis.com/css?family=Orbitron" rel="stylesheet" type="text/css">
        <script>
            function clearSearch()
            {
                location.reload();
            }
        </script>
    </head>

    <body>

        <div class="d-flex justify-content-center">
            <button class="btn btn-warning position-fixed btn-block w-25" id="upbtn" type="button" title="W górę" onclick="goUp()"><i class="fas fa-angle-up"></i></button>
        </div>

        <script>
            function dispBtn()
            {
                var go_up = document.getElementById("upbtn");

                if(document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) 
                {
                    go_up.style.display = "block";
                } 
                
                else 
                {
                    go_up.style.display = "none";
                }
            }

            window.onscroll = function()
            {
                dispBtn()
            };

            function goUp() 
            {
                document.body.scrollTop = 0;
                document.documentElement.scrollTop = 0;
            }
        </script>

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

                    <li class="nav-item mr-4 active">
                        <a class="nav-link" href="zamowienia.php"><i class="fas fa-shopping-cart mr-2"></i>Zamówienia</a>
                    </li>

                    <li class="nav-item">
                        <a id="logout" class="nav-link" href="../wyloguj.php"><i class="fas fa-power-off mr-2"></i>Wyloguj</a>
                    </li>                    

                </ul>
          
            </div>
          </nav>

        <main>

            <div class="container text-center mb-3">

                <div class="mb-3 text-light font-weight-bold">Wyszukuj według:</div>

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="radiobtn" id="radio1" value=0 checked>
                    <label class="form-check-label text-warning font-weight-bold" for="radio1">Nr zamówienia</label>
                </div>

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="radiobtn" id="radio2" value=1>
                    <label class="form-check-label text-warning font-weight-bold" for="radio2">Klient</label>
                </div>

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="radiobtn" id="radio3" value=3>
                    <label class="form-check-label text-warning font-weight-bold" for="radio3">Data złożenia</label>
                </div>

            </div>

            <nav class="navbar navbar-light navbar-expand-lg">

				<button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#nav">
					<span class="fas fa-search text-light"></span>
				</button>

				<div class="collapse navbar-collapse" id="nav">

					<form class="form-inline ml-auto mr-auto">
                    
						<div class="input-group">
                            
                            <div class="input-group-prepend">
								<div class="input-group-text border-0"><i class="fas fa-search"></i></div>
							</div>
                            <input id="search" class="form-control border-0" type="search" placeholder="Szukaj" oninput="searchFunction()" autocomplete="off">
                            <button type="button" id="clear" class="btn bg-transparent border-0" style="margin-left: -40px; z-index: 100;" onclick="clearSearch()" hidden>
                                <i class="fa fa-times"></i>
                            </button>

						</div>
					</form>

				</div>
			</nav>

            <div class="container col-sm-12">

                <div class="table-responsive">
                    <table class="table table-primary table-striped" id="table">
                        <thead>
                            <tr>
                              <th scope="col">Nr zamówienia</th>
                              <th scope="col">Klient</th>
                              <th scope="col">Rabat %</th>
                              <th scope="col">Data złożenia</th>
                              <th scope="col">Szczegóły</th>
                              <th scope="col">Faktura</th>
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
                                        $query = "SELECT * FROM zamówienia INNER JOIN klienci ON klienci.ID_klienta=zamówienia.ID_klienta ORDER BY zamówienia.ID_zamowienia DESC";

                                        $result = $conn->query($query);

                                        if (!$result)
                                        {
                                            throw new Exception($conn->error); 
                                        }

                                        else
                                        {
                                            while ($row = $result->fetch_assoc())
                                            {
                                                $id = $row['ID_zamowienia'];

                                                echo "<tr id='row$id'><td><b>".$row['ID_zamowienia']."</b></td><td>".$row['Imię'].' '.$row['Nazwisko'].' - '.$row['ID_klienta']."</td><td>".$row['Rabat']."</td><td>".$row['Data_złożenia']."</td>";
                                                
                                                echo "<td><a href='szczegoly.php?id=$id' class='btn btn-secondary'><i class='fas fa-info mr-2'></i>Szczegóły</a></td>";
                                                echo "<td><a href='faktury.php?id=$id' class='btn btn-secondary'><i class='fas fa-file-invoice mr-2'></i>Faktura</a></td>";
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
                    </table>

                    <script>
                        function searchFunction() 
                        {
                            var input = document.getElementById("search");
                            var filter = input.value.toUpperCase();
                            var table = document.getElementById("table");
                            var rows = table.getElementsByTagName("tr");
                            var radios = document.getElementsByName("radiobtn");
                            var td, txtValue, el;

                            if(input.value != "")
                            {
                                document.getElementById("clear").hidden = false;
                            }

                            else
                            {
                                document.getElementById("clear").hidden = true;
                            }

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
                    url: "usuwanie/zamowienia_usuwanie.php",
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