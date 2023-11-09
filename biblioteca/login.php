
   <?php
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $con_string = "host=localhost dbname=biblioteca user=postgres password=postgres";
            $dbcon = pg_connect($con_string);

            if (!$dbcon) {
                die("Erro ao conectar ao banco de dados: " . pg_last_error());
            }

 
                
        if (isset($_GET["email_usuario"])) {

     
                $email_usuario = pg_escape_string($_GET["email_usuario"]); 
                $select_senha = pg_query($dbcon,"SELECT password_usuario from usuarios  where email_usuario = '$email_usuario'");
               $valor_senha = pg_fetch_result($select_senha ,0,0);
                $verificar_senha = password_verify(($_GET["password_usuario"]), $valor_senha);

                if($verificar_senha == true) {
                    echo 'usuário autenticado ';
                    header("Location: home.html");
                }
   
                

               
                
         
                  
              
            }
            

            pg_close($dbcon);
        }

      
        ?>