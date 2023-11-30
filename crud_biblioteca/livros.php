<?php

session_start();


?>

<!DOCTYPE html>
<html>
<head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Claken's Commerce</title><meta charset="utf-8"> 
    <link rel="stylesheet" href="css/styles.css" />
    
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

     <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@200&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>

<style>

form {
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 20px;
}

input[type="text"] {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    margin-right: 5px;
}

input[type="submit"] {
    padding: 10px 15px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #0056b3;
}

    </style>

<body> 
    

<nav>

<input type="checkbox" id="res-menu">
<label for="res-menu">
    <i class="fa fa-bars" id="sign-one"></i>
    <i class="fa fa-times" id="sign-two"></i>
    </label>
    <h1 class="agaum">Books and Magics</h1>
    <ul>

<li><a href="home.php">Home</a></li>
<li><a href="livros.php">Livros</a></li>
<li><a href="usuario.php">Você</a></li>


    </ul>

   </nav>
   
<form method="POST" action="pesquisar.php">
    Pesquisar:<input type="text" name="pesquisa" placeholder="PESQUISAR">
    <input type="submit" value="ENVIAR" >
</form>



</body>




<?php





 $con_string = "host=localhost dbname=biblioteca user=postgres password=postgres";
 $dbcon = pg_connect($con_string);

 if (!$dbcon) {
     die("Erro ao conectar ao banco de dados: " . pg_last_error());
 }
 
 $query_cartoes = "SELECT * FROM livros";
 $result_cartoes = pg_query($dbcon, $query_cartoes);

 echo '<div class="row">'; // Inicia uma linha de cartões

$count = 0; // Contador para controlar o número de cartões por linha

while ($cartao = pg_fetch_assoc($result_cartoes)) {
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

echo '</div>';

 

?>