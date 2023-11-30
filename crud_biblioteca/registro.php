<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Responsive Navbar</title>
    <link rel="stylesheet" href="css/styles.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"
    />
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@1,700&display=swap" rel="stylesheet">   
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@1,900&display=swap" rel="stylesheet"> 
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Maven+Pro:wght@500&display=swap" rel="stylesheet">
<link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
    />

  </head>
  <body>
   <nav>

<input type="checkbox" id="res-menu">
<label for="res-menu">
    <i class="fa fa-bars" id="sign-one"></i>
    <i class="fa fa-times" id="sign-two"></i>
    </label>
    <ul>

<li><a href="#s">Books and Magic's</a></li>

    </ul>

   </nav>


<main>


    <div class="formulario">
        <div class="form-toggle"></div>
        <div class="form-panel one">
            <div class="form-header">
                <h1>Registre-se</h1>
            </div>
            <div class="form-content">
                <form action="registro.php" method="GET">
                    <div class="form-group">
                        <label for="nome_usuario">Nome de Usuário</label>
                        <input type="text" id="nome_usuario" name="nome_usuario" required="required" />
                    </div>
                    <div class="form-group">
                        <label for="password">Senha</label>
                        <input type="password" id="password" name="password_usuario" required="required" />
                    </div>
                    <div class="form-group">
                    <label>
                        Email: <input type="email" name="email_usuario">
                    </label>
                </div>

            
                    <div class="form-group">
                        <button type="submit">Log In</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>

      
    <!-- FOOTER -->

    <footer>

        <!--The main area of the footer -->
        <div class="footer-content">
        
           <h3>Siga nossas redes sociais</h3>
          
        <!--Footer's social icon-->
           <ul class="socials">
              <li><a href="#"><i class="fab fa-facebook"></i></a></li>
              <li><a href="#"><i class="fab fa-twitter"></i></a></li>
              <li><a href="#"><i class="fab fa-instagram"></i></a></li>
              <li><a href="#"><i class="fab fa-youtube"></i></a></li>
              
            </ul>
        
        

<p>by Pros</p><br>
        <p>&copy; claken imports 2022</p>
        </div>
        
        
        
        </footer>

   </main>


  </body>
</html>


<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
 $con_string = "host=localhost dbname=biblioteca user=postgres password=postgres";
 $dbcon = pg_connect($con_string);

 if (!$dbcon) {
     die("Erro ao conectar ao banco de dados: " . pg_last_error());
 }
 else {
    echo "Conectado ao banco de dados";
 }


     
if (isset($_GET["email_usuario"]) && isset($_GET["password_usuario"]) && isset($_GET["nome_usuario"]) ) {

     $nome_usuario = pg_escape_string($_GET["nome_usuario"]);
     $email_usuario = pg_escape_string($_GET["email_usuario"]);
     $hash = password_hash(($_GET["password_usuario"]), PASSWORD_DEFAULT);
     

     if($email_usuario == 'eduardo@admin') {

        $query_admin = "INSERT into usuarios (nome_usuario, email_usuario, password_usuario, level_usuario) VALUES ('$nome_usuario','$email_usuario','$hash','admin')";

        if (pg_query($dbcon, $query_admin)) {
            echo "<h2>Admin Registrado!</h2>";
            header("Location: adminpage.php");
        }

     }

     else {


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

 }
}

 pg_close($dbcon);
}


?>
