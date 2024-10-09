<?php

// Função para gerar um codigo aleatório de confirmaçao
function gerarCodigoConfirmacao($tamanho = 5) {
    return substr(str_shuffle("0123456789ABCD"), 0, $tamanho);
}

// Função para enviar email de confirmaçao
function enviarEmailConfirmacao($email, $codigo) {
    $assunto = "Confirmação de Cadastro Conecta FDB";
    $mensagem = "Seu código de confirmação é: $codigo\n";

    // Enviar email
    mail($email, $assunto, $mensagem);
}


// Verificar se o email termina com "@faculdadedombosco.edu.br"

if (preg_match("/@faculdadedombosco\.edu\.br$/", $email)) {
    // Gerar um código de confirmação
    $codigo = gerarCodigoConfirmacao();

    // Enviar o email de confirmação
    enviarEmailConfirmacao($email, $codigo);
} else {
    echo "Email inválido. Use um email da Faculdade Dom Bosco.";
}
?>
