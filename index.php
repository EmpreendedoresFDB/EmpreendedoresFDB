<?php
session_start();
include "php/conn.php";

$sql = "SELECT nome_empreendimento, descricao_empreendimento, telefone_empreendimento, foto_empreendimento FROM empreendimento";
$resultado = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Empreendimentos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="html-css/style.css" rel="stylesheet">
</head>
<body>
    <header class="header">
        <div class="container d-flex align-items-center justify-content-between">
            <img src="html-css/img/logo-faculdade-dom-bosco.png" alt="Logo Institucional" class="header-logo">
            <div class="header-title">Empreendedores Faculdade Dom Bosco</div>
            <button class="btn btn-primary btn-area-aluno" onclick="window.location.href='html-css/areaAluno.html'">Área do Aluno</button>
        </div>
    </header>
    
    <div class="container mt-5">        
        <div class="row">
            <?php
            if ($resultado && mysqli_num_rows($resultado) > 0) {
                while ($row = mysqli_fetch_assoc($resultado)) {
                    $nome = htmlspecialchars($row['nome_empreendimento']);
                    $descricao = htmlspecialchars($row['descricao_empreendimento']);
                    $telefone = htmlspecialchars($row['telefone_empreendimento']);
                    $foto = "php/" . $row['foto_empreendimento'];
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
                                        <img src="html-css/img/whatsapp-icon.png" alt="WhatsApp" width="300" height="68">
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                    
            <?php
                }
            } else {
                echo "<p class='text-center'>Nenhum empreendimento encontrado.</p>";
            }
            ?>
        </div>
    </div>

    <footer class="footer mt-auto py-3 bg-light">
        <div class="container d-flex align-items-center justify-content-between">
            <img src="html-css/img/logo-faculdade-dom-bosco.png" alt="Logo Institucional" class="footer-logo">
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
mysqli_close($conn);
?>
