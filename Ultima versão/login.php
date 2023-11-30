<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $con_string = "host=localhost dbname=biblioteca user=postgres password=postgres";
    $dbcon = pg_connect($con_string);

    if (!$dbcon) {
        die("Erro ao conectar ao banco de dados: " . pg_last_error());
    }

    if (isset($_GET["email_usuario"]) && isset($_GET["password_usuario"])) {
        $email_usuario = pg_escape_string($_GET["email_usuario"]);
        $senha_usuario = pg_escape_string($_GET["password_usuario"]);

        $select_senha = pg_query($dbcon, "SELECT password_usuario, nome_usuario, id_usuario FROM usuarios WHERE email_usuario = '$email_usuario'");
        $result = pg_fetch_assoc($select_senha);

        if ($result) {
            $hash_senha = $result["password_usuario"];
            $verificar_senha = password_verify($senha_usuario, $hash_senha);

            if ($verificar_senha) {
                // Autenticação bem-sucedida
                $_SESSION['email'] = $email_usuario;
                $_SESSION['nome'] = $result["nome_usuario"];
                $_SESSION['id_usuario'] = $result["id_usuario"];

                if ($email_usuario == 'eduardo@admin') {
                    header("Location: adminpage.php?id=" . $_SESSION['id_usuario']);
                } else {
                    header("Location: usuario.php?id=" . $_SESSION['id_usuario']);
                }
                exit;
            } else {
                $erro = "Senha incorreta. Tente novamente.";
            }
        } else {
            $erro = "Usuário não encontrado. Verifique o email e tente novamente.";
        }
    }

    pg_close($dbcon);
}
?>





<?php
if (isset($erro)) {
    echo '<div class="erro">' . $erro . '</div>';
}
?>



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


<li><a href="#">Books and Magic's</a></li>


    </ul>

   </nav>


<main>

    
    <div class="formulario">
        <div class="form-toggle"></div>
        <div class="form-panel one">
            <div class="form-header">
                <h1>Entrar</h1>
            </div>
            <div class="form-content">
                <form action="login.php" method="get">
                    <div class="form-group">
                        <label for="username">Email</label>
                        <input type="text" id="email_usuario" name="email_usuario" required="required" />
                    </div>
                    <div class="form-group">
                        <label for="password">Senha</label>
                        <input type="password" id="password" name="password_usuario" required="required" />
                    </div>
                    <div class="form-group">
                        <a class="form-recovery" href="#">Esqueceu a sua senha?</a>
                    </div>
                    <div class="form-group">
                        <a class="form-recovery" href="registro.html">Registre-se</a>
                    </div>
                    <div class="form-group">
                        <button type="login":hover>Log In</button>
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
        <p>&copy; Books and Magic's 2022</p>
        </div>
        
        
        
        </footer>
    

   </main>

   
   
<script></script>
  </body>
</html>   
   
   
   
   
