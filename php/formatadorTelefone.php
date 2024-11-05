<?php
class formatadorTelefone {

// Formata o número de telefone para exibição
public static function formatarParaDisplay($telefone) {
    // Remove qualquer coisa que não seja número (espacos, hífens, etc.)
    $telefoneLimpo = preg_replace('/\D/', '', $telefone);

    // Verifica se o telefone tem 11 dígitos
    if (strlen($telefoneLimpo) == 11) {
        // Retorna o formato "xx 9xxxx-xxxx"
        return substr($telefoneLimpo, 0, 2) . ' ' . substr($telefoneLimpo, 2, 5) . '-' . substr($telefoneLimpo, 7, 4);
    }
    
    return $telefone; // Retorna o valor original caso não tenha 11 dígitos
}

// Formata o número de telefone para inserção no banco
public static function formatarParaBanco($telefone) {
    // Remove tudo o que não for número (como espaços e hífens)
    return preg_replace('/\D/', '', $telefone);
}
}
?>