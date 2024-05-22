<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Motorista</title>
</head>
<body>
<h1>Cadastro de Motorista</h1>

<?php
// Exibir mensagem de sucesso ou erro
if (isset($_GET['message'])) {
    echo "<p style='font-weight: bold'>{$_GET['message']}</p>";
}
?>

<form action="motorista-cadastro.php" method="post">
    <label for="cpf">CPF:</label>
    <input type="text" id="cpf" name="cpf" required><br><br>

    <label for="name">Nome:</label>
    <input type="text" id="name" name="name" required><br><br>

    <label for="sex">Sexo:</label>
    <input type="text" id="sex" name="sex" required><br><br>

    <label for="address">Endereço:</label>
    <input type="text" id="address" name="address" required><br><br>

    <label for="phone">Telefone:</label>
    <input type="number" id="phone" name="phone" required><br><br>

    <label for="email">E-mail:</label>
    <input type="text" id="email" name="email" required><br><br>

    <label for="cnh">CNH:</label>
    <input type="text" id="cnh" name="cnh" required><br><br>

    <h2>Conta Bancária</h2>
    <label for="bank">Banco:</label>
    <input type="text" id="bank" name="bank" required><br><br>

    <label for="agency">Agência:</label>
    <input type="text" id="agency" name="agency" required><br><br>

    <label for="account">Conta:</label>
    <input type="text" id="account" name="account" required><br><br>

    <input type="submit" value="Cadastrar Motorista">
</form>
</body>
</html>

<?php

require_once '../../model/CMP1611_Motorista.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtém os dados do formulário
    $motoristaData = [
        'cpf_motorista' => $_POST['cpf'],
        'cnh' => $_POST['cnh'],
        'banco_mot' => $_POST['bank'],
        'agencia_mot' => $_POST['agency'],
        'conta_mot' => $_POST['account']
    ];

    $pessoaData = [
        'cpf_pessoa' => $_POST['cpf'],
        'nome' => $_POST['name'],
        'email' => $_POST['email'],
        'sexo' => $_POST['sex'],
        'endereco' => $_POST['address'],
        'telefone' => $_POST['phone'],
    ];

    $message = '';
    if (CMP1611_Motorista::validate_settings($message, $motoristaData, $pessoaData)) {

        $motorista = new CMP1611_Motorista();

        if (!$motorista->checkMotoristaExistence($motoristaData['cpf_motorista'])
            && !$motorista->checkPessoaExistence($pessoaData['cpf_pessoa'])) {
            if ($motorista->insertMotorista($motoristaData) && $motorista->insertPessoa($pessoaData)) {
                $message = "Motorista {$motoristaData['nome']} com CPF {$motoristaData['cpf_motorista']} cadastrado com sucesso!";
            } else {
                $message = "Falha ao inserir motorista.<br>";
            }
        } else {
            $message = "Motorista com CPF {$motoristaData['cpf_motorista']} já cadastrado!";
        }
    }

    if ($message) {
        header("Location: motorista-cadastro.php?message=" . urlencode($message));
        exit();
    }
} ?>

<script>
    // Remove o parâmetro da URL após a mensagem ser exibida
    if (window.location.search.includes('message=')) {
        const url = new URL(window.location);
        url.searchParams.delete('message');
        window.history.replaceState({}, document.title, url);
    }
</script>
