<?php
session_start();


$email =  $_SESSION['email'];


$con_string = "host=localhost dbname=biblioteca user=postgres password=postgres";
$dbcon = pg_connect($con_string);

if (!$dbcon) {
    die("Erro ao conectar ao banco de dados: " . pg_last_error());
}

$id_usuario = $_POST['id_usuario'];


$query_emprestimos = "SELECT l.titulo_livro, l.autores_livro, e.data_emprestimo
FROM livros l
JOIN emprestimos e ON l.id_livro = e.id_livro
WHERE e.id_usuario = '$id_usuario'";




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
      <li><a href="usuario.php">Voltar</a></li>
      <li><a href="sair.php">Sair</a></li>


      <?php 
      if ($_SESSION['email'] == 'eduardo@admin') {
     echo ' <li><a href="adminusuarios.php">Usuários</a></li> ';
      }
      ?>
          </ul>
      
         </nav>


    <header>
        <h1>Livros emprestados de: <?php 
        
        $query_usuario = "SELECT nome_usuario from usuarios where id_usuario = $id_usuario ";
$result_query_usuario = pg_query($dbcon,$query_usuario);
$row = pg_fetch_assoc($result_query_usuario);

if ($row) {
    echo $row['nome_usuario'];
} else {
    echo "Nenhum resultado encontrado.";
} ?></h1>
    </header>

    <section class="borrowed-books">
        <h2>Livros Emprestados</h2>

        <?php
    $result_emprestimos = pg_query($dbcon, $query_emprestimos);

    // Verifique se há linhas retornadas
    if ($result_emprestimos) {
        $num_rows = pg_num_rows($result_emprestimos);
    
        if ($num_rows > 0) {

            // Exibir os livros emprestados
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
