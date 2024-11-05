<?php
    session_start();
    include "conn.php";
    include "formatadorTelefone.php";

    $sql = "SELECT nome, email, telefone FROM usuario WHERE email = '" . $_SESSION['email'] . "' ";
    $resultadoConsulta = mysqli_query($conn, $sql);

    if ($resultadoConsulta->num_rows > 0) {
        $row = $resultadoConsulta->fetch_assoc();
        $nome = $row["nome"];
        $email = $row["email"];
        $telefone = $row["telefone"];
        $telefone = formatadorTelefone::formatarParaDisplay($telefone);
    } else {
        echo "Nenhuma informação encontrada para este usuário.";
        exit();
    }
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Minha Conta</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="../html-css/style.css" rel="stylesheet">
        <link rel="stylesheet" href="../html-css/home.css">
        <link rel="stylesheet" href="../html-css/formularios.css">
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
                <h2>Minha Conta</h2>
                <form action="editaUsuario.php" method="POST">
                <div class="mb-3 input-group">
                        <label for="email"><?php echo $email; ?></label>
                    </div>
                    <div class="mb-3 input-group">
                        <input type="text" name="nome" class="form-control" placeholder="<?php echo $nome; ?>" required>
                    </div>
                    <div class="mb-3 input-group">
                        <input type="tel" name="telefone" class="form-control" placeholder="<?php echo $telefone; ?>" required>
                    </div>
                    <div class="form-group">
                        <input type="password" name="senha" class="form-control" placeholder="Confirma Senha" required>
                    </div>
                    <div class="form-group">
                        <input type="password" name="repetir_senha" class="form-control" placeholder="Repetir Senha" required>
                    </div>
                    <button type="button" class="btn-back mb-3" onclick="window.location.href='home.php'">Voltar</button>
                    <button type="submit" class="btn-submit mb-3">Salvar</button>
                </form>
            </div>
        </div>
        <footer class="footer">
            <div class="container d-flex align-items-left justify-content-between">
                <img src="../html-css/img/logo-faculdade-dom-bosco.png" alt="Logo Institucional" class="footer-logo">
            </div>
        </footer>
    </body>
</html>
<?php
mysqli_close($conn);
?>
