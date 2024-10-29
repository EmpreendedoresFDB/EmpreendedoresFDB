<?php
session_start();
include "conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id_empreendimento'], $_POST['nome_empreendimento'], $_POST['descricao_empreendimento'], $_POST['telefone_empreendimento'])) {
        $id_empreendimento = intval($_POST['id_empreendimento']);
        $nome_empreendimento = mysqli_real_escape_string($conn, $_POST['nome_empreendimento']);
        $descricao_empreendimento = mysqli_real_escape_string($conn, $_POST['descricao_empreendimento']);
        $telefone_empreendimento = mysqli_real_escape_string($conn, $_POST['telefone_empreendimento']);

        $email = $_SESSION['email'];
        $sqlUsuario = "SELECT id_usuario FROM usuario WHERE email = '$email'";
        $resultadoUsuario = mysqli_query($conn, $sqlUsuario);

        if ($resultadoUsuario && mysqli_num_rows($resultadoUsuario) > 0) {
            $rowUsuario = mysqli_fetch_assoc($resultadoUsuario);
            $id_usuario = $rowUsuario['id_usuario'];

            $sqlEmpreendimento = "SELECT id_empreendimento FROM empreendimento WHERE id_empreendimento = $id_empreendimento AND id_usuario = $id_usuario";
            $resultadoEmpreendimento = mysqli_query($conn, $sqlEmpreendimento);

            if ($resultadoEmpreendimento && mysqli_num_rows($resultadoEmpreendimento) > 0) {
                $sqlUpdate = "UPDATE empreendimento 
                              SET nome_empreendimento = '$nome_empreendimento', descricao_empreendimento = '$descricao_empreendimento', telefone_empreendimento = '$telefone_empreendimento' 
                              WHERE id_empreendimento = $id_empreendimento AND id_usuario = $id_usuario";

                if (mysqli_query($conn, $sqlUpdate)) {
                    echo "<script>alert('Empreendimento atualizado com sucesso!'); window.location.href='home.php';</script>";
                } else {
                    echo "Erro ao atualizar o empreendimento: " . mysqli_error($conn);
                }
            } else {
                echo "Empreendimento não encontrado ou não autorizado.";
            }
        } else {
            echo "Usuário não autorizado.";
        }
    } else {
        echo "Todos os campos são obrigatórios.";
    }
} else {
    echo "Método de requisição inválido.";
}
mysqli_close($conn);
?>
