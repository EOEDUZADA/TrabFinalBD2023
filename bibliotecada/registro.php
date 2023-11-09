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
     

     if($email_usuario == 'admin@admin') {

        $query_admin = "INSERT into usuarios (nome_usuario, email_usuario, password_usuario, level_usuario) VALUES ('$nome_usuario','$email_usuario','$hash','admin')";

        if (pg_query($dbcon, $query_admin)) {
            echo "<h2>Admin Registrado!</h2>";
        }

     }

     else {

     $query_insert = "INSERT into usuarios (nome_usuario, email_usuario, password_usuario,level_usuario) VALUES ('$nome_usuario','$email_usuario','$hash','user')";
     
     if (pg_query($dbcon, $query_insert)) {
        header("Location: home.html");
     } else {
         echo "Erro na consulta de inserção: " . pg_last_error();
     }
 }
}

 pg_close($dbcon);
}


?>
