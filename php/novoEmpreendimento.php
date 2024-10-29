<?php
include "conn.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_empreendimento = $_POST['nome_empreendimento'];
    $descricao_empreendimento = $_POST['descricao_empreendimento'];
    $telefone_empreendimento = $_POST['telefone_empreendimento'];
    $nome_arquivo = null; // Definindo como nulo para o caso de nenhum arquivo ser enviado

    // Obtendo o id_usuario baseado no email da sessão
    $email = $_SESSION['email'];
    $sqlUsuario = "SELECT id_usuario FROM usuario WHERE email = '$email'";
    $resultadoUsuario = mysqli_query($conn, $sqlUsuario);

    if ($resultadoUsuario && mysqli_num_rows($resultadoUsuario) > 0) {
        $rowUsuario = mysqli_fetch_assoc($resultadoUsuario);
        $id_usuario = $rowUsuario['id_usuario'];
    }

    // Verificação se um arquivo foi enviado
    if (!empty($_FILES['foto_empreendimento']['tmp_name'])) {
        $arquivo_tmp = $_FILES['foto_empreendimento']['tmp_name'];
        $tipo_arquivo = mime_content_type($arquivo_tmp);

        // Verificação do tipo de arquivo para aceitar apenas imagens
        if (in_array($tipo_arquivo, ['image/jpeg', 'image/png', 'image/gif'])) {
            $nome_arquivo = 'uploads/' . uniqid() . '_' . $_FILES['foto_empreendimento']['name'];
            move_uploaded_file($arquivo_tmp, $nome_arquivo);
        } else {
            echo "<script>
                    alert('Apenas arquivos de imagem (JPEG, PNG, GIF) são permitidos.');
                    window.location.href = 'formulario.html';
                  </script>";
            exit();
        }
    }

    // Inserindo o empreendimento no banco de dados
    $sql = "INSERT INTO empreendimento (nome_empreendimento, descricao_empreendimento, telefone_empreendimento, foto_empreendimento, avaliacao, id_usuario) 
            VALUES ('$nome_empreendimento', '$descricao_empreendimento', '$telefone_empreendimento', '$nome_arquivo', '0', $id_usuario)";
    
    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Cadastro de empreendimento realizado com sucesso!');
                window.location.href = 'home.php';
              </script>";
    } else {
        echo "<script>
                alert('Erro ao cadastrar empreendimento.');
                window.location.href = 'novoEmpreendimento.html';
              </script>";
    }
}
?>