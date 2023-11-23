<!DOCTYPE html>
<html>
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
          <h1>Claken</h1>
          <ul>
      
      <li><a href="home.html">Home</a></li>
      <li><a href="mouses.html">Mouse</a></li>
      <li><a href="livros.php">Livros</a></li>
      
      
          </ul>
      
         </nav>
   
    <div class="container">
        <h2>Inserção de produtos</h2>
           <form action="adminpage.php" method="post" enctype="multipart/form-data">
           <p>Autor livros <input type="text" name="autores_livro" /></p>
            <p>Titulo Livro <input type="text" name="titulo_livro" /></p>
            <p>Ano  <input type="text" name="ano" /></p>
            <p>Editora  <input type="text" name="editora" /></p>
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


        
    if (!isset($_POST["fileUpload"])) {




$autor = pg_escape_string($_POST["autores_livro"]);
$titulo = pg_escape_string($_POST["titulo_livro"]);
$ano = pg_escape_string($_POST["ano"]);
$editora = pg_escape_string($_POST["editora"]);


$ext = $_FILES['fileUpload']['type']; //Pegando extensão do arquivo
$nome = $_FILES['fileUpload']['name'];
$new_name = date("Y.m.d-H.i.s") . $ext; //Definindo um novo nome para o arquivo
$dir = 'uploads/'; //Diretório para uploads
move_uploaded_file($_FILES['fileUpload']['tmp_name'], $dir.$nome); //Fazer upload do arquivo


$sql_code = "INSERT into livros (autores_livro, titulo_livro,ano_livro,editora_livro,imagem_livro) VALUES ('$autor','$titulo','$ano','$editora','$nome')";


// ...

// ...

if (pg_query($dbcon, $sql_code)) {
   echo "Dados inseridos com sucesso";
} else {
    echo "Erro na consulta de inserção: " . pg_last_error();
}

// ...


// ...
 



    
    
    


    pg_close($dbcon);
}
}
?>
     
 