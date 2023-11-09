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


     
if (isset($_GET["email_usuario"]) && isset($_GET["password_usuario"]) && isset($_GET["nome_usuario"]) ) {

     $nome_usuario = pg_escape_string($_GET["nome_usuario"]);
     $email_usuario = pg_escape_string($_GET["email_usuario"]);
     $hash = password_hash(($_GET["password_usuario"]), PASSWORD_DEFAULT);
     

     echo $nome_usuario;
     

     $query_insert = "INSERT into usuarios (nome_usuario, email_usuario, password_usuario) VALUES ('$nome_usuario','$email_usuario','$hash')";
     
     if (pg_query($dbcon, $query_insert)) {
         echo "<h2>Dados inseridos com sucesso!</h2>";
     } else {
         echo "Erro na consulta de inserção: " . pg_last_error();
     }
 }
 

 pg_close($dbcon);
}


?>
