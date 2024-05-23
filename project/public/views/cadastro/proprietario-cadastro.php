<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proprietário Cadastro</title>
</head>
<body>
<h1>Cadastro de Proprietário</h1>

<?php
// Exibir mensagem de sucesso ou erro
if (isset($_GET['message'])) {
    echo "<p style='font-weight: bold'>{$_GET['message']}</p>";
}
?>

<form action="proprietario-cadastro.php" method="post">
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
    <input type="submit" value="Cadastrar Proprietário">
</form>

<?php

require_once '../../model/CMP1611_Proprietario.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtém os dados do formulário
    $proprietarioData = [
        'cpf_prop' => $_POST['cpf'],
        'cnh_prop' => $_POST['cnh'],
        'banco_prop' => $_POST['bank'],
        'agencia_prop' => $_POST['agency'],
        'conta_prop' => $_POST['account']
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
    if (CMP1611_Proprietario::validate_settings($message, $proprietarioData, $pessoaData)) {

        $proprietario = new CMP1611_Proprietario();

        if (!$proprietario->checkProprietarioExistence($proprietarioData['cpf_prop'], $proprietarioData['cnh_prop'])
            && !$proprietario->checkPessoaExistence($pessoaData['cpf_pessoa'])) {
            if ($proprietario->insertProprietario($proprietarioData) && $proprietario->insertPessoa($pessoaData)) {
                $message = "Proprietário {$proprietarioData['nome']} com CPF {$proprietarioData['cpf_prop']} cadastrado com sucesso!";
            } else {
                $message = "Falha ao inserir proprietário.<br>";
            }
        } else {
            $message = "Proprietário já cadastrado!";
        }
    }

    if ($message) {
        header("Location: proprietario-cadastro.php?message=" . urlencode($message));
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

</body>
</html>