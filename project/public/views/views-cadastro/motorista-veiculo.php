<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autorizar Motorista</title>
</head>
<body>
<h1>Autorizar Motorista</h1>

<?php
// Exibir mensagem de sucesso ou erro
if (isset($_GET['message'])) {
    echo "<p style='font-weight: bold'>{$_GET['message']}</p>";
}
?>

<form action="motorista-veiculo.php" method="post">
    <label for="cpf">CPF:</label>
    <input type="text" id="cpf" name="cpf" required><br><br>

    <label for="plate">Placa:</label>
    <input type="text" id="plate" name="plate" required><br><br>

    <input type="submit" value="Autorizar Motorista">
</form>


<?php

require_once '../../model/CMP1611_Motorista_Veiculo.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Obtém os dados do formulário
    $motoristaVeiculoData = [
        'cpf_motorista' => $_POST['cpf'],
        'placa_veiculo' => $_POST['plate'],
    ];

    $motorista_veiculo = new CMP1611_Motorista_Veiculo(
        $motoristaVeiculoData['cpf_motorista'],
        $motoristaVeiculoData['placa_veiculo']
    );

    $message = '';
    if ($motorista_veiculo->validate_settings($message)) {
        if ($motorista_veiculo->getQuery()->insert('motorista_veiculo', $motoristaVeiculoData)) {
            $message = 'Motorista autorizado com sucesso!';
        } else {
            $message = 'Erro ao autorizar motorista!';
        }
    }

    if ($message) {
        header("Location: motorista-veiculo.php?message=" . urlencode($message));
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