<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $senha = $_POST['senha'];

    // Criptografar a senha usando password_hash
    $senhaCriptografada = password_hash($senha, PASSWORD_BCRYPT);
}
?>
