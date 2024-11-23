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

        $sqlEmpreendimento = "SELECT nome_empreendimento, descricao_empreendimento, telefone_empreendimento 
                              FROM empreendimento 
                              WHERE id_empreendimento = $id_empreendimento AND id_usuario = $id_usuario";
        $resultadoEmpreendimento = mysqli_query($conn, $sqlEmpreendimento);

        if ($resultadoEmpreendimento && mysqli_num_rows($resultadoEmpreendimento) > 0) {
            $rowEmpreendimento = mysqli_fetch_assoc($resultadoEmpreendimento);
            $nome_empreendimento = $rowEmpreendimento['nome_empreendimento'];
            $descricao_empreendimento = $rowEmpreendimento['descricao_empreendimento'];
            $telefone_empreendimento = $rowEmpreendimento['telefone_empreendimento'];
        } else {
            echo "Empreendimento não encontrado ou não autorizado.";
            exit();
        }
    } else {
        echo "Usuário não autorizado.";
        exit();
    }
} else {
    echo "ID de empreendimento inválido.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Empreendimento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../html-css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../html-css/home.css">
    <link rel="stylesheet" href="../html-css/formularios.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
</head>
<body>
    <header class="header">
        <div class="container d-flex align-items-center justify-content-between">
            <img src="../html-css/img/logo-faculdade-dom-bosco.png" alt="Logo Institucional" class="header-logo">
            <div class="header-title">Empreendedores Faculdade Dom Bosco</div>
        </div>
    </header>
    <div class="container d-flex justify-content-center vh-100">
        <div class="formulario-cadastro">
            <h2>Editar Empreendimento</h2>
            <form action="salvaEmpreendimento.php" method="POST">
                <input type="hidden" name="id_empreendimento" value="<?php echo $id_empreendimento; ?>">
                <div class="mb-3 input-group">
                    <input type="text" name="nome_empreendimento" class="form-control" placeholder="Nome do Empreendimento" value="<?php echo $nome_empreendimento; ?>" required>
                </div>
                <div class="mb-3 input-group">
                    <textarea name="descricao_empreendimento" class="form-control" placeholder="Descrição do Empreendimento" required><?php echo $descricao_empreendimento; ?></textarea>
                </div>
                <div class="mb-3 input-group">
                    <input type="tel" id="telefone_empreendimento" name="telefone_empreendimento" class="form-control" placeholder="Telefone do Empreendimento" value="<?php echo $telefone_empreendimento; ?>" required>
                </div>
                <button type="button" class="btn-back mb-3" onclick="window.location.href='home.php'">Voltar</button>
                <button type="submit" class="btn-submit mb-3">Salvar Alterações</button>
            </form>
        </div>
    </div>
    <footer class="footer">
        <div class="container d-flex align-items-left justify-content-between">
            <img src="../html-css/img/logo-faculdade-dom-bosco.png" alt="Logo Institucional" class="footer-logo">
        </div>
    </footer>
</body>
<script>    
    $(document).ready(function () {
        $('#telefone_empreendimento').mask('(00) 00000-0000');
    });
 </script>
</html>
<?php
mysqli_close($conn);
?>
