<?php
include "conn.php";
include "formatadorTelefone.php";
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
                window.location.href = '../html-css/novoUsuario.html';
              </script>";
    } 
    elseif (!preg_match('/^(1[5-9]|[2-9][0-9])\d{6}/', $email)) {
        echo "<script>
                alert('O e-mail deve conter sua matrícula para realizar o cadastro.');
                window.location.href = '../html-css/novoUsuario.html';
              </script>";
    } 
    elseif ($senha !== $repetir_senha) {
        echo "<script>
                alert('As senhas não coincidem. Por favor, verifique.');
                window.location.href = '../html-css/novoUsuario.html';
              </script>";
    } 
    else {
        $sqlCheckEmail = "SELECT id_usuario FROM usuario WHERE email = '$email'";
        $resultadoCheckEmail = mysqli_query($conn, $sqlCheckEmail);

        if (mysqli_num_rows($resultadoCheckEmail) > 0) {
            echo "<script>
                    alert('Número de matrícula já está cadastrada!');
                    window.location.href = '../html-css/novoUsuario.html';
                  </script>";
        } 
        else {
            $senhaCriptografada = criptografarSenha($senha);
            $telefone = formatadorTelefone::formatarParaBanco($telefone);
            $sql = "INSERT INTO usuario (nome, email, telefone, hashs, tipo)
                    VALUES ('$nome', '$email', '$telefone', '$senhaCriptografada', '0')";
            
            if (mysqli_query($conn, $sql)) {
                echo "<script>
                        alert('Cadastro realizado com sucesso!');
                        window.location.href = '../html-css/areaAluno.html';
                      </script>";
            } else {
                echo "<script>
                        alert('Erro ao cadastrar. Por favor, tente novamente.');
                        window.location.href = '../html-css/novoUsuario.html';
                      </script>";
            }
        }
    }
}
?>
