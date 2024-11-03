<?php
session_start();
include "conn.php";

$email = $_SESSION['email'];
$sqlUsuario = "SELECT id_usuario, nome, email, telefone FROM usuario WHERE email = '$email'";
$resultadoUsuario = mysqli_query($conn, $sqlUsuario);

if ($resultadoUsuario && mysqli_num_rows($resultadoUsuario) > 0) {
    $rowUsuario = mysqli_fetch_assoc($resultadoUsuario);
    $id_usuario = $rowUsuario['id_usuario'];
    $nome = $rowUsuario["nome"];
    $telefone = $rowUsuario["telefone"];
} else {
    echo "Nenhuma informação encontrada para este usuário.";
    exit();
}

$sqlEmpreendimentos = "SELECT id_empreendimento, nome_empreendimento, descricao_empreendimento, telefone_empreendimento FROM empreendimento WHERE id_usuario = $id_usuario";
$resultadoEmpreendimentos = mysqli_query($conn, $sqlEmpreendimentos);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Empreendimentos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../html-css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../html-css/home.css">
    <link rel="stylesheet" href="../html-css/formularios.css">
</head>
<body style="background-color: var(--cor-background-hf); color: white; font-family: Arial, sans-serif;">
<header class="header">
        <div class="container d-flex align-items-center justify-content-between">
            <img src="../html-css/img/logo-faculdade-dom-bosco.png" alt="Logo Institucional" class="header-logo">
            <div class="header-title">Empreendedores Faculdade Dom Bosco</div>
            <div class="d-flex align-items-center">
                <button class="btn btn-primary mx-2" onclick="window.location.href='../php/minhaConta.php'">Minha Conta</button>
                <button class="btn btn-primary mx-2" onclick="window.location.href='../html-css/novoEmpreendimento.html'">Novo Empreendimento</button>
                <button class="btn btn-primary mx-2" onclick="window.location.href='../html-css/areaAluno.html'">Sair</button>
            </div>
        </div>
    </header>
    <main>
        <div class="container mt-4">
            <div class="formulario-cadastro">
                <h3 class="mt-4">Meus Empreendimentos</h3>
                <?php if ($resultadoEmpreendimentos && mysqli_num_rows($resultadoEmpreendimentos) > 0): ?>
                    <table class="table table-bordered mt-3 text-center" style="color: white;">
                        <thead class="thead-dark">
                            <tr>
                                <th>Nome do Empreendimento</th>
                                <th>Descrição</th>
                                <th>Telefone</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($rowEmpreendimento = mysqli_fetch_assoc($resultadoEmpreendimentos)): ?>
                                <tr>
                                    <td><?php echo $rowEmpreendimento['nome_empreendimento']; ?></td>
                                    <td><?php echo $rowEmpreendimento['descricao_empreendimento']; ?></td>
                                    <td><?php echo $rowEmpreendimento['telefone_empreendimento']; ?></td>
                                    <td>
                                        <div class="d-flex justify-content-center align-items-center">
                                            <a href="editaEmpreendimento.php?id=<?php echo $rowEmpreendimento['id_empreendimento']; ?>" class="mx-2">
                                                <img src="../html-css/img/editar.png" alt="Editar" width="24" height="24">
                                            </a>
                                            <a href="excluiEmpreendimento.php?id=<?php echo $rowEmpreendimento['id_empreendimento']; ?>" onclick="return confirm('Tem certeza que deseja excluir este empreendimento?');" class="mx-2">
                                                <img src="../html-css/img/excluir.png" alt="Excluir" width="24" height="24">
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="text-center mt-3">Você não tem empreendimentos cadastrados.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="container d-flex align-items-left justify-content-between">
            <img src="../html-css/img/logo-faculdade-dom-bosco.png" alt="Logo Institucional" class="footer-logo">
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
mysqli_close($conn);
?>