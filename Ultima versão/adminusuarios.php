<?php
session_start();


$con_string = "host=localhost dbname=biblioteca user=postgres password=postgres";
$dbcon = pg_connect($con_string);

if (!$dbcon) {
    die("Erro ao conectar ao banco de dados: " . pg_last_error());
}



$query_usuarios = "SELECT * from usuarios";

// Fecha a conexão
pg_close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Usuário</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>



<nav>

      <input type="checkbox" id="res-menu">
      <label for="res-menu">
          <i class="fa fa-bars" id="sign-one"></i>
          <i class="fa fa-times" id="sign-two"></i>
          </label>
          <h1>Books and Magic's</h1>
          <ul>
      
      <li><a href="home.php">Home</a></li>
      <li><a href="livros.php">Livros</a></li>
      <li><a href="sair.php">Sair</a></li>
      
      
          </ul>
      
         </nav>


    <header>
        <h1>Perfil de <?php echo $_SESSION['nome']; ?></h1>
    </header>

    <section class="borrowed-books">
        <h2>Usuários cadastrados</h2>

        <?php
    $result_emprestimos = pg_query($dbcon, $query_usuarios);


    if ($result_emprestimos) {
        $num_rows = pg_num_rows($result_emprestimos);
        
        if ($num_rows > 0) {
            while ($row = pg_fetch_assoc($result_emprestimos)) {
                echo "<div class='book'>";
                echo "<h3> Nome:" . $row["nome_usuario"] . "</h3>";
                echo "<p>Email: " . $row["email_usuario"] . "</p>";
    
             
                echo "<form action='excluir_usuario.php' method='post'>";
                echo "<input type='hidden' name='id_usuario' value='" . $row["id_usuario"] . "'>";
                echo "<input type='submit' value='Excluir'></form>";
    
                echo "<form action='atualizar_usuario.php' method='post'>";
                echo "<input type='hidden' name='id_usuario' value='" . $row["id_usuario"] . "'>";
                echo "<input type='submit' value='Atualizar'></form>";
    

                echo "<form action='livros_emprestados_usuario.php' method='post'>";
                echo "<input type='hidden' name='id_usuario' value='" . $row["id_usuario"] . "'>";
                echo "<input type='submit' value='Ver livros emprestados'></form>";

                
    

                echo "</div>";
            }
        } else {
            echo "<p>Nenhum livro emprestado no momento.</p>";
        }
    
    }
        ?>
    </section>



</body>
</html>
