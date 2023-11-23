
<?php




if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $con_string = "host=localhost dbname=biblioteca user=postgres password=postgres";
    $dbcon = pg_connect($con_string);
   
    if (!$dbcon) {
        die("Erro ao conectar ao banco de dados: " . pg_last_error());
    }
    else {
       echo "conectadinho nego";
    }
   
   
        

    
   
   
    pg_close($dbcon);
}

?>