<?php
session_start();
include "conn.php";

if (isset($_GET['id_empreendimento']) && is_numeric($_GET['id_empreendimento'])) {
    $id_empreendimento = intval($_GET['id_empreendimento']);

    if (isset($_SESSION['email'])) {
        $email = $_SESSION['email'];
        $sqlUsuario = "SELECT id_usuario FROM usuario WHERE email = '$email'";
        $resultadoUsuario = mysqli_query($conn, $sqlUsuario);

        if ($resultadoUsuario && mysqli_num_rows($resultadoUsuario) > 0) {
            $rowUsuario = mysqli_fetch_assoc($resultadoUsuario);
            $id_usuario = $rowUsuario['id_usuario'];

            $sql = "SELECT nome_empreendimento, descricao_empreendimento, telefone_empreendimento, foto_empreendimento
                    FROM empreendimento
                    WHERE id_empreendimento = $id_empreendimento AND id_usuario = $id_usuario";
            $resultado = mysqli_query($conn, $sql);

        } else {
            die("Usuário não autorizado.");
        }
    } else {
        die("Usuário não autenticado.");
    }
} else {
    die("ID de empreendimento inválido." . $id_empreendimento);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Empreendimentos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../html-css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <?php
                if ($resultado && mysqli_num_rows($resultado) > 0) {
                    $row = mysqli_fetch_assoc($resultado);
                    $nome = htmlspecialchars($row['nome_empreendimento']);
                    $descricao = htmlspecialchars($row['descricao_empreendimento']);
                    $telefone = htmlspecialchars($row['telefone_empreendimento']);
                    $foto = "../php/" . $row['foto_empreendimento'];
                    $whatsappLink = "https://api.whatsapp.com/send?phone=55" . $telefone;
                    ?>

<div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $nome; ?></h5>
                                <?php if ($foto): ?>
                                    <img src="<?php echo htmlspecialchars($foto); ?>" alt="<?php echo $nome; ?>" class="card-img-top">
                                <?php endif; ?>
                                <p class="card-text"><?php echo $descricao; ?></p>
                                <p class="card-text">
                                    <a href="<?php echo $whatsappLink; ?>" target="_blank">
                                        <img src="../html-css/img/whatsapp-icon.png" alt="WhatsApp" width="180" height="59">
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
            <?php
                }
            ?>
        </div>
    </div>
</body>
</html>
<?php
mysqli_close($conn);
?>
