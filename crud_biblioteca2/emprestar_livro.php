<?php
  session_start();

  $livro_emprestado = $_POST['livro_emprestado'];
  $id_livro_emprestado = $_POST['id_livro_emprestado'];

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $con_string = "host=localhost dbname=biblioteca user=postgres password=postgres";
    $dbcon = pg_connect($con_string);

    if (!$dbcon) {
      die("Erro ao conectar ao banco de dados: " . pg_last_error());
    }

    $livro_emprestado = $_POST['livro_emprestado'];
    $id_livro_emprestado = $_POST['id_livro_emprestado'];

    $_SESSION['livro_emprestado'] = $livro_emprestado;
    $_SESSION['id_livro_emprestado'] = $id_livro_emprestado;
    $id_usuario = $_SESSION['id_usuario'];

    // Verificar se há livros disponíveis
    $query_disponibilidade = "SELECT qtd_disponivel_emprestimo FROM livros WHERE id_livro = $id_livro_emprestado";
    $result_disponibilidade = pg_query($dbcon, $query_disponibilidade);

    if ($result_disponibilidade) {
      $livro = pg_fetch_assoc($result_disponibilidade);
      $qtd_disponivel = $livro['qtd_disponivel_emprestimo'];

      if ($qtd_disponivel > 0) {
        // Atualizar a tabela de livros
        $query_emprestimo = "INSERT INTO emprestimos (id_usuario, id_livro, data_emprestimo) VALUES ($id_usuario, $id_livro_emprestado, CURRENT_TIMESTAMP)";
        $result_emprestimo = pg_query($dbcon, $query_emprestimo);

        if ($result_emprestimo) {
          $query_atualizar = "UPDATE livros SET qtd_disponivel_emprestimo = qtd_disponivel_emprestimo - 1 WHERE id_livro = $id_livro_emprestado";
          $result_atualizar = pg_query($dbcon, $query_atualizar);
          header("Location: usuario.php");

          if ($result_atualizar) {
            // livro emprestado com sucesso
            echo "Livro emprestado com sucesso!";
          } else {
            // Lidar com erro na atualização da quantidade disponível
            echo "<p>Erro ao atualizar quantidade disponível.</p>";
          }
        } else {
          // L erro na inserção do empréstimo
          echo "Erro ao registrar empréstimo.";
        }
      }
    } else {
      // erro na obtenção da quantidade disponível
      echo "Erro ao verificar disponibilidade do livro.";
    }
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
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f8f8f8;
    }

    nav {
      background-color: #6E6BBA;
      color: #fff;
      padding: 15px;
      text-align: center;
    }

    nav ul {
      list-style: none;
      margin: 0;
      padding: 0;
    }

    nav ul li {
      display: inline;
      margin-right: 20px;
    }

    nav a {
      text-decoration: none;
      color: #fff;
      font-weight: bold;
      font-size: 16px;
    }

    .error-message {
      text-align: center;
      background-color: #fff;
      padding: 20px;
      border-radius: 20px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      max-width: 400px;
      margin: 300px auto;
    }

    .error-message p {
      color: purple;
      font-size: 20px;
    }
  </style>
</head>
<body>
  <nav>
    <input type="checkbox" id="res-menu">
    <label for="res-menu">
      <i class="fa fa-bars" id="sign-one"></i>
      <i class="fa fa-times" id="sign-two"></i>
    </label>
    <ul>
      <li><a href="usuario.php">Voltar</a></li>
    </ul>
  </nav>

  <?php
    echo "<div class='error-message'><p>Não há livros disponíveis para empréstimo.</p></div>";
  ?>
</body>
</html>
