<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conectar ao banco de dados
    $con_string = "host=localhost dbname=biblioteca user=postgres password=postgres";
    $dbcon = pg_connect($con_string);

    if (!$dbcon) {
        die("Erro ao conectar ao banco de dados: " . pg_last_error());
    }

    // Obter o ID do usuário a ser excluído
    $id_usuario = $_POST['id_usuario'];

    // Preparar e executar a consulta de exclusão
    $delete_query = "DELETE FROM usuarios WHERE id_usuario = $id_usuario";
    $result = pg_query($dbcon, $delete_query);

    if ($result) {
        echo "Usuário excluído com sucesso!";
    } else {
        echo "Erro ao excluir usuário: " . pg_last_error($dbcon);
    }

    // Fechar a conexão
    pg_close($dbcon);
}
?>
