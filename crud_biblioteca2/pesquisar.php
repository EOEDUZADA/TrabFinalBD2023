<!DOCTYPE html>
<html lang="pt-br">
  <head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Claken's Commerce</title><meta charset="utf-8"> 
    <link rel="stylesheet" href="css/styles.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@1,700&display=swap" rel="stylesheet">   
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@1,900&display=swap" rel="stylesheet"> 
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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
          <h1>Books and Magics</h1>
          <ul>
      
      <li><a href="home.html">Home</a></li>
      <li><a href="livros.php">Livros</a></li>
      <li><a href="livros.php">Voltar</a></li>
      <li><a href="#">Você</a></li>
      
      
          </ul>
      
         </nav>

  </body>

</html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $con_string = "host=localhost dbname=biblioteca user=postgres password=postgres";
    $dbcon = pg_connect($con_string);
   
    if (!$dbcon) {
        die("Erro ao conectar ao banco de dados: " . pg_last_error());
    }

    $post_pesquisa = pg_escape_string($_POST["pesquisa"]);
    
    $query_pesquisa = "SELECT * FROM livros WHERE lower(unaccent(titulo_livro)) ILIKE lower(unaccent('$post_pesquisa%'))";

    $result_pesquisa = pg_query($dbcon, $query_pesquisa);

   
    if (pg_num_rows($result_pesquisa) > 0) {



        echo '<div class="row">'; // Inicia uma linha de cartões

        $count = 0; // Contador para controlar o número de cartões por linha

        while ($cartao = pg_fetch_assoc($result_pesquisa)) {
            // ... 


            echo '<div class="col-md-4 col-sm-6 mt-4 mb-2">';
            echo '
                <div class="card">
                    <img src="uploads/' . $cartao["imagem_livro"] . '" class="card-img-top" alt="' . $cartao["titulo_livro"] . '" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">' . $cartao["titulo_livro"] . '</h5>
                        <p class="card-text">' . $cartao["autores_livro"] . '</p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <i class="fa fa-star star"></i>
                            <i class="fa fa-star star"></i>
                            <i class="fa fa-star star"></i>
                            <i class="fa fa-star star"></i>
                        </li>
                        <li class="list-group-item">' . $cartao["qtd_disponivel_emprestimo"] . ' Disponíveis</li>
                    </ul>
                    <div class="card-body">
                        <form method="post" action="emprestar_livro.php">
                            <input type="hidden" name="livro_emprestado" value="' . $cartao['titulo_livro'] . '">
                            <input type="hidden" name="id_livro_emprestado" value="' . $cartao["id_livro"] . '">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-cart-plus mr-2"></i>Pegar emprestado
                            </button>
                        </form>
                    </div>
                </div>
            ';
        
            echo '</div>';
        
            $count++;
        
            if ($count % 3 == 0) {
                echo '</div><div class="row">'; // Fecha a linha e inicia uma nova a cada 3 cartões
            }
        }

        echo '</div>'; // Fecha a última linha de cartões
    } else {
        echo '<p>Livro não encontrado.</p>';
    }

    pg_close($dbcon);
}
?>
