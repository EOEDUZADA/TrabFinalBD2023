<?php

session_start(); // Inicializa a sessão


$_SESSION = array(); // Limpa os dados da sessão


session_destroy();


header("Location: login.php");
exit();



?>