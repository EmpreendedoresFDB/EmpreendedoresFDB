<?php
    session_start();
    include "conn.php";
    function criptografarSenha($senha) {
        return password_hash($senha, PASSWORD_BCRYPT);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = $_POST['nome'];
        $telefone = $_POST['telefone'];
        $senha = $_POST['senha'];
        $repetir_senha = $_POST['repetir_senha'];

        if ($senha !== $repetir_senha) {
            echo "<script>
                    alert('As senhas não coincidem. Por favor, verifique');
                    window.location.href = 'minhaConta.php';
                </script>";
        }
        else {
            $senhaCriptografada = criptografarSenha($senha);
            $sql = "UPDATE usuario SET nome = '$nome', telefone = '$telefone', hashs = '$senhaCriptografada' WHERE email = '" . $_SESSION['email'] . "' ";

            mysqli_query($conn,$sql);
            echo "<script>
                    alert('Conta atualizada com sucesso!');
                    window.location.href = 'home.php';
                </script>";
        }
    }
?>
