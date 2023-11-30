<?php

$con_string = "host=localhost dbname=biblioteca user=postgres password=postgres";
 $dbcon = pg_connect($con_string);

 if (!$dbcon) {
     die("Erro ao conectar ao banco de dados: " . pg_last_error());
 }
 else {
    echo "Conectado ao banco de dados";
 }

$email_usuario = 'dsadsadsacxz@admin';



        





 


   $verifica_usuario_existente = "SELECT email_usuario from usuarios where email_usuario = '$email_usuario'";  
   $result = pg_query($dbcon, $verifica_usuario_existente);
   if ($result){ 


$num_rows = pg_num_rows($result);


if($num_rows > 0) {
   echo 'Usuário já existe';
   $valor_verifica_usuario = pg_fetch_result($result, 0, 0);
    echo "ID do usuário: " . $valor_verifica_usuario;
}

else {

    $query_insert = "INSERT into usuarios (nome_usuario, email_usuario, password_usuario,level_usuario) VALUES ('$nome_usuario','$email_usuario','$hash','user')";
     
    if (pg_query($dbcon, $query_insert)) {
       header("Location: login.php");
    } else {
        echo "Erro na consulta de inserção: " . pg_last_error();
    }

}
   }
  

  



?>