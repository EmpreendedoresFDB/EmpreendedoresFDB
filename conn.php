<?php
    $server = "localhost";
    $user = "root";
    $pass = "engenhariaB2024#";
    $bd = "EmpreendedoresFDB";

    if ($conn = mysqli_connect($server, $user, $pass, $bd)) {
        echo "Conectado com sucesso";
    }else
        echo "Erro ao conectar";
?>