<?php
session_start();
include "conn.php";

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_empreendimento = intval($_GET['id']);

    $email = $_SESSION['email'];
    $sqlUsuario = "SELECT id_usuario FROM usuario WHERE email = '$email'";
    $resultadoUsuario = mysqli_query($conn, $sqlUsuario);
    
    if ($resultadoUsuario && mysqli_num_rows($resultadoUsuario) > 0) {
        $rowUsuario = mysqli_fetch_assoc($resultadoUsuario);
        $id_usuario = $rowUsuario['id_usuario'];
        
        $sqlDelete = "DELETE FROM empreendimento WHERE id_empreendimento = $id_empreendimento AND id_usuario = $id_usuario";
        if (mysqli_query($conn, $sqlDelete)) {
            echo "<script>
                    alert('Empreendimento excluido com sucesso!');
                    window.location.href = 'home.php';
                </script>";
        } else {
            echo "Erro ao excluir o empreendimento.";
        }
    } else {
        echo "Usuário não autorizado ou empreendimento não encontrado.";
    }
} else {
    echo "ID de empreendimento inválido.";
}
mysqli_close($conn);
?>