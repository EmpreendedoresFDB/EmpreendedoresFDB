<?php
include "conn.php";
function criptografarSenha($senha) {
    return password_hash($senha, PASSWORD_BCRYPT);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $senha = $_POST['senha'];
    $repetir_senha = $_POST['repetir_senha'];
    $tipo = 0;

    if (!preg_match('/@faculdadedombosco\.edu\.br$/', $email)) {
        echo "<script>
                alert('O e-mail deve ser do domínio @faculdadedombosco.edu.br para realizar o cadastro.');
                window.location.href = 'novoUsuario.html';
              </script>";
    }
    elseif ($senha !== $repetir_senha) {
        echo "<script>
                alert('As senhas não coincidem. Por favor, verifique.');
                window.location.href = 'novoUsuario.html';
              </script>";
    }
    else {
        $senhaCriptografada = criptografarSenha($senha);
        $sql = "INSERT INTO usuario (nome, email, telefone, hashs, tipo)
                VALUES ('$nome', '$email', '$telefone', '$senhaCriptografada', '0')";
        
        mysqli_query($conn,$sql);

        echo "<script>
                alert('Cadastro realizado com sucesso!');
                window.location.href = '../html-css/areaAluno.html';
              </script>";
    }
}
?>
