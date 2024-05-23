<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserir Passageiro</title>
</head>
<body>
<h1>Inserir Passageiro</h1>
<form action="passageiro-cadastro.php" method="post">
    <label for="cpf_passag">CPF do Passageiro:</label>
    <input type="number" id="cpf_passag" name="cpf_passag" required><br><br>

    <label for="nome_passag">Nome do Passageiro:</label>
    <input type="text" id="nome_passag" name="nome_passag" required><br><br>

    <label for="endereco_passag">Endereço do Passageiro:</label>
    <input type="text" id="endereco_passag" name="endereco_passag" required><br><br>

    <label for="telefone_passag">Telefone do Passageiro:</label>
    <input type="number" id="telefone_passag" name="telefone_passag" required><br><br>

    <label for="email_passag">Email do Passageiro:</label>
    <input type="email" id="email_passag" name="email_passag" required><br><br>

    <label for="sexo_passag">Sexo do Passageiro:</label>
    <input type="text" id="sexo_passag" name="sexo_passag" required><br><br>

    <label for="cartao_cred">Cartão de Crédito:</label>
    <input type="text" id="cartao_cred" name="cartao_cred" maxlength="20" required><br><br>

    <label for="bandeira_cartao">Bandeira do Cartão:</label>
    <input type="text" id="bandeira_cartao" name="bandeira_cartao" maxlength="20" required><br><br>

    <label for="cidade_orig">Cidade de Origem:</label>
    <input type="text" id="cidade_orig" maxlength="30" name="cidade_orig" required><br><br>

    <input type="submit" value="Inserir Passageiro">
</form>

<?php

// Uso da classe Singleton
require_once '../../model/CMP1611_Passageiro.php';

// Verifica se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Obtém os dados do formulário
    $passageiroData = [
        'cpf_passag' => $_POST['cpf_passag'],
        'nome_passag' => $_POST['nome_passag'],
        'endereco_passag' => $_POST['endereco_passag'],
        'telefone_passag' => $_POST['telefone_passag'],
        'email_passag' => $_POST['email_passag'],
        'sexo_passag' => $_POST['sexo_passag'],
        'cartao_cred' => (int)$_POST['cartao_cred'],
        'bandeira_cartao' => $_POST['bandeira_cartao'],
        'cidade_orig' => $_POST['cidade_orig']
    ];

    $passageiro = new CMP1611_Passageiro(
        $passageiroData['cpf_passag'],
        $passageiroData['cartao_cred'],
        $passageiroData['bandeira_cartao'],
        $passageiroData['cidade_orig'],
        $passageiroData['nome_passag'],
        $passageiroData['endereco_passag'],
        $passageiroData['telefone_passag'],
        $passageiroData['email_passag'],
        $passageiroData['sexo_passag'],
    );

    $message = '';

    // Verifica se os dados do passageiro são válidos
    if ($passageiro->validate_settings($message)) {
        // Insere o passageiro no banco de dados
        if ($passageiro->insertPassageiro()) {
            echo "Passageiro {$passageiroData['nome_passag']} com CPF {$passageiroData['cpf_passag']} cadastrado com sucesso!";
        } else {
            echo "Erro ao inserir passageiro!";
        }
    } else {
        echo $message;
    }
}

?>
</body>
</html>
