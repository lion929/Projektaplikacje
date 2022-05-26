<?php

    session_start();

    if (!isset($_SESSION['log_in']))
    {
        header("Location: index.php");
        exit();
    }

?>

<div class="container">

    <div class="row mb-3">
        <div class="col-sm-6">
            <a class="text-light"  href="#" data-target="ustawienia"><i class="fas fa-cog mr-2"></i>Ustawienia</a>
        </div>
        <div class="col-sm-6">
            <span id="clock" class="float-right"></span>
            <script>
                time();
            </script>
        </div>
    </div>

    <div class="mb-3">
        <h2 id="welcome">Witaj!</h2>
    </div>

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

<script>
    $(document).ready(function() {

        $(".container div div a").on("click", function() { 

            var target = $(this).data("target");       
    
            $("#content").load("subpages/" + target + ".php");

            return false;
        });
    });
</script>