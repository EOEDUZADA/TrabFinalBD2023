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
</head>
<body>
    <div class="container">
        <h2>Inserção de produtos</h2>
        <form action="adminpage.php" method="post">
            <p>Autor livros <input type="text" name="autores_livro" /></p>
            <p>Titulo Livro <input type="text" name="titulo_livro" /></p>
            <p>Ano  <input type="text" name="ano" /></p>
            <p>Editora  <input type="text" name="editora" /></p>
           <form action="adminpage.php" method="post" enctype="multipart/form-data">
      <input type="file" name="fileUpload">
            <p class="enviar"><input type="submit" value="Inserir"></p>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $con_string = "host=localhost dbname=biblioteca user=postgres password=postgres";
            $dbcon = pg_connect($con_string);

            if (!$dbcon) {
                die("Erro ao conectar ao banco de dados: " . pg_last_error());
            }

 
                
            if (isset($_POST["autores_livro"]) && isset($_POST["titulo_livro"]) && isset($_POST["ano"]) && isset($_POST["editora"]) & isset($_POST["fileUpload"])) {

                $nome = pg_escape_string($_POST["autores_livro"]);
    $titulo = pg_escape_string($_POST["titulo_livro"]);
    $ano = pg_escape_string($_POST["ano"]);
    $editora = pg_escape_string($_POST["editora"]);

    $ext = strtolower(substr($_FILES['fileUpload']['name'],-4)); //Pegando extensão do arquivo
    $new_name = date("Y.m.d-H.i.s") . $ext; //Definindo um novo nome para o arquivo
    $dir = 'uploads/'; //Diretório para uploads
    move_uploaded_file($_FILES['fileUpload']['tmp_name'], $dir.$new_name); //Fazer upload do arquivo




    $sql_code = "INSERT into livros (autores_livro, titulo_livro,ano_livro,editora_livro,imagem_livro) VALUES ('$autor','$titulo','$ano','$editora','$new_name')";


                
                if (pg_query($dbcon, $sql_code)) {



                    echo "<h2>Dados inseridos com sucesso!</h2>";

                    // Agora, crie um novo cartão com as informações inseridas
                    echo '<div class="box">';
                    echo '<div class="image">';
                    echo '<img src="uploads/' . $new_name . '" alt="' . $titulo . '">';
                    echo '</div>';
                    echo '<div class="info">';
                    echo '<h3>' . $titulo . '</h3>';
                    echo '<div class="subInfo">';
                    echo '<strong class="price"> R$59.99 </strong>';
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="overlay">';
                    echo '<a href="#" style="--i:2;" class="fas fa-shopping-cart"></a>';
                    echo '</div>';
                    echo '</div>';


                    echo "<h2>Dados inseridos com sucesso!</h2>";
                } else {
                    echo "Erro na consulta de inserção: " . pg_last_error();
                }
            }
            


            pg_close($dbcon);
        }
        ?>
 
     
 