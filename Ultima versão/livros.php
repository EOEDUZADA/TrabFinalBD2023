<!DOCTYPE html>
<html>
<head>
<style>
         body {
background-color: #0c0c0c;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            
            width: 600px;
            margin: 0 auto;

     background-color: #fff;
           
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        h2 {
            text-align: center;
            color: black;
        }

        form {
            text-align: center;
        }

        input[type="text"] {
            width: 100%;
            padding-bottom: 11px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            
        }

        input[type="submit"] {
            background-color: black;
            color: #fff;
            border: none;
            padding: 10px 20px;
            
            cursor: pointer;
            border-radius: 5px;
        }

        button {
            
    
            display: inline-block;
                outline: 0;
                cursor: pointer;
                border-radius: 6px;
                border: 2px solid #ff4742;
                color: #ff4742;
                background: 0 0;
                padding: 8px;
                box-shadow: rgba(0, 0, 0, 0.07) 0px 2px 4px 0px, rgba(0, 0, 0, 0.05) 0px 1px 1.5px 0px;
                font-weight: 800;
                font-size: 16px;
                height: 42px;
               
                
          
        
            border: none;
            padding: 10px 20px;
            
            cursor: pointer;
            border-radius: 5px;
        }

        input[type="submit"]:hover {
            background-color: greenyellow;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: black;
            color: #fff;
        }
    </style>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Claken's Commerce</title><meta charset="utf-8"> 
    <link href="./css/styles.css" rel="stylesheet">
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
<form method="POST" action="pesquisar.php">
    Pesquisar:<input type="text" name="pesquisa" placeholder="PESQUISAR">
    <input type="submit" value="ENVIAR">
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
     echo '<div class="col-sm-4 mt-4 mb-2">';
     echo '
         <div class="card">
             <div class="card-body">
                 <div class="card-img-actions">
                     <img src="uploads/' . $cartao["imagem_livro"] . '" class="card-img img-fluid" alt="'. $cartao["titulo_livro"] . '">
                 </div>
             </div>

             <div class="card-body bg-light text-center">
                 <div class="mb-2">
                     <h6 class="font-weight-semibold mb-2">
                         <strong>' . $cartao["titulo_livro"] . '
                     </h6>
                 </div>

                 <h3 class="mb-0 font-weight-semibold">R$152.92</h3>

                 <div>
                    <i class="fa fa-star star"></i>
                    <i class="fa fa-star star"></i>
                    <i class="fa fa-star star"></i>
                    <i class="fa fa-star star"></i>
                 </div>

                 <div class="text-muted mb-3">4 Avaliações</div>

                 <a class="btn bg-cart bg-primary" href="#">
                     <i class="fa fa-cart-plus mr-2"></i>Adicione ao Carrinho
                 </a>
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


?>
