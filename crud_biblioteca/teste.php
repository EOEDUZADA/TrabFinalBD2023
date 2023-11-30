<?php

session_start();

echo "DEBUG: Session ID: " . session_id() . "<br>";

// Resto do código...

echo "olá " .  $_SESSION['nome'];


echo "Seu email é " .  $_SESSION['email'];




?>