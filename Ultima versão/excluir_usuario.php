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

    // Excluir registros relacionados na tabela "emprestimos"
    $delete_emprestimos_query = "DELETE FROM emprestimos WHERE id_usuario = $id_usuario";
    $result_emprestimos = pg_query($dbcon, $delete_emprestimos_query);

    if (!$result_emprestimos) {
        echo "Erro ao excluir registros relacionados: " . pg_last_error($dbcon);

    }

    $delete_usuario_query = "DELETE FROM usuarios WHERE id_usuario = $id_usuario";
    $result_usuario = pg_query($dbcon, $delete_usuario_query);

    if ($result_usuario) {
        echo "Usuário excluído com sucesso!";
    } else {
        echo "Erro ao excluir usuário: " . pg_last_error($dbcon);
    }

    // Fechar a conexão
    pg_close($dbcon);
}
?>
