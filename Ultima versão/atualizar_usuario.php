<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Usuário</title>
 <style>
body {
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
}

nav {
    
    background-color: #6E6BBA;
    color: white;
    padding: 1em;
    text-align: center;
}

nav ul {
    list-style-type: none;
    padding: 0;
    display: flex;
    justify-content: space-around;
}

nav a {
    text-decoration: none;
    color: white;
}

.formulario {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: #f0f0f0;
}

.form-panel {
    background-color: #fff;
    padding: 2em;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.form-group {
    margin-bottom: 1em;
}

label {
    display: block;
    margin-bottom: 0.5em;
}

input[type="text"] {
    width: 100%;
    padding: 0.5em;
    border: 1px solid #ccc;
    border-radius: 4px;
}

button {
    background-color: #333;
    color: white;
    padding: 0.5em 1em;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

button:hover {
    background-color: #555;
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
        <h1>Books and Magic's</h1>
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="livros.php">Livros</a></li>
            <li><a href="usuario.php">Você</a></li>
            <li><a href="adminusuarios.php">Usuários</a></li>
        </ul>
    </nav>


    

    <div class="formulario">
        <div class="form-toggle"></div>
        <div class="form-panel one">
            <div class="form-header">
                <h1>Atualizar dados do usuário</h1>
            </div>
            <div class="form-content">
                <form action="#" method="post">
                  
                    <input type="hidden" name="id_usuario" value="<?php echo isset($_POST['id_usuario']) ? $_POST['id_usuario'] : ''; ?>">

                    <div class="form-group">
                        <label for="novo_nome">Novo nome</label>
                        <input type="text" id="novo_nome" name="novo_nome" />
                    </div>

                    <div class="form-group">
                        <label for="novo_email">Novo e-mail</label>
                        <input type="text" id="novo_email" name="novo_email" />
                    </div>

                    <div class="form-group">
                        <button type="submit">Atualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>

<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conectar ao banco de dados
    $con_string = "host=localhost dbname=biblioteca user=postgres password=postgres";
    $dbcon = pg_connect($con_string);

    if (!$dbcon) {
        die("Erro ao conectar ao banco de dados: " . pg_last_error());
    }

    // Obter o ID do usuário a ser atualizado
    $id_usuario = isset($_POST['id_usuario']) ? (int)$_POST['id_usuario'] : 0;

    echo $id_usuario;


    $novo_nome = isset($_POST['novo_nome']) ? pg_escape_string($_POST['novo_nome']) : '';
    $novo_email = isset($_POST['novo_email']) ? pg_escape_string($_POST['novo_email']) : '';


    if (!empty($novo_nome)) {
 
        $update_query = "UPDATE usuarios SET nome_usuario = '$novo_nome' WHERE id_usuario = $id_usuario";
        $result = pg_query($dbcon, $update_query);

        if ($result) {
            echo "Usuário atualizado com sucesso!";
            header("Location: adminusuarios.php");
        } else {
            echo "Erro ao atualizar usuário: " . pg_last_error($dbcon);
        }
    } 

    if (!empty($novo_email)) {

        $update_query = "UPDATE usuarios SET email_usuario = '$novo_email' WHERE id_usuario = $id_usuario";
        $result = pg_query($dbcon, $update_query);

        if ($result) {
            echo "Usuário atualizado com sucesso!";
            header("Location: adminusuarios.php");
        } else {
            echo "Erro ao atualizar usuário: " . pg_last_error($dbcon);
        }
    }


    pg_close($dbcon);
}
?>


