<?php
session_start();


$email =  $_SESSION['email'];




$con_string = "host=localhost dbname=biblioteca user=postgres password=postgres";
$dbcon = pg_connect($con_string);

if (!$dbcon) {
    die("Erro ao conectar ao banco de dados: " . pg_last_error());
}

$select_id_usuario = "SELECT id_usuario from usuarios where email_usuario = '$email'";  

$result = pg_query($dbcon, $select_id_usuario);

if ($result) {

    $valor_id_usuario = pg_fetch_result($result, 0, 0);

} else {
    echo "Erro na consulta de seleção: " . pg_last_error();
}

$query_emprestimos = "SELECT l.titulo_livro, l.autores_livro, e.data_emprestimo
FROM livros l
JOIN emprestimos e ON l.id_livro = e.id_livro
WHERE e.id_usuario = '$valor_id_usuario'";

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
   


      <?php 
      if ($_SESSION['email'] == 'eduardo@admin') {

    echo ' <li><a href="adminpage.php">Inserir livro</a></li> ';
     echo ' <li><a href="adminusuarios.php">Usuários</a></li> ';
      }
      ?>  
       <li><a href="sair.php">Sair</a></li>
          </ul>
      
         </nav>


    <header>
        <h1>Perfil de <?php echo $_SESSION['nome']; ?></h1>
    </header>

    <section class="borrowed-books">
        <h2>Seus Livros Emprestados</h2>

        <?php
    $result_emprestimos = pg_query($dbcon, $query_emprestimos);


    if ($result_emprestimos) {
        $num_rows = pg_num_rows($result_emprestimos);
    
        if ($num_rows > 0) {
        
            while ($row = pg_fetch_assoc($result_emprestimos)) {
                echo "<div class='book'>";
                echo "<h3>" . $row["titulo_livro"] . "</h3>";
                echo "<p>Autor: " . $row["autores_livro"] . "</p>";
                echo "<p>Data de Empréstimo: " . $row["data_emprestimo"] . "</p>";
                echo "</div>";
            }
        } else {
            // Nenhum livro emprestado no momento
            echo "<p>Nenhum livro emprestado no momento.</p>";
        }
    } else {
        // Erro na consulta
        echo "Erro na consulta: " . pg_last_error($dbcon);
    }
        ?>
    </section>



</body>
</html>
