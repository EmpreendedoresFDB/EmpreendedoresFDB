<?php
session_start();
include "conn.php";

function verificarSenha($senha, $hash) {
    return password_verify($senha, $hash);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $senha = $_POST['senha'];

    $sql = "SELECT hashs FROM usuario WHERE email = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die("Erro na preparação da consulta: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hash);
        $stmt->fetch();
        
        if (verificarSenha($senha, $hash)) {
            $_SESSION['email'] = $email;
            echo "<script>
                    window.location.href = 'home.php';
                </script>";
        } else {
            echo "<script>
                    alert('Senha incorreta. Tente novamente.');
                    window.location.href = '../html-css/areaAluno.html';
                </script>";
        }
    } else {
        echo "<script>
                alert('Usuário não encontrado.');
                window.location.href = '../html-css/areaAluno.html';
            </script>";
    }

    $stmt->close();
}
?>