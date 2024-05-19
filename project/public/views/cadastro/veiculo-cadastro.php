<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserir Veículo</title>
</head>
<body>
<h1>Inserir Veículo</h1>
<form action="veiculo-cadastro.php" method="post">
    <label for="plate">Placa:</label>
    <input type="text" id="plate" name="plate" required><br><br>

    <label for="brand">Marca:</label>
    <input type="text" id="brand" name="brand" required><br><br>

    <label for="model">Modelo:</label>
    <input type="text" id="model" name="model" required><br><br>

    <label for="year_of_manufacture">Ano de Fabricação:</label>
    <input type="number" id="year_of_manufacture" name="year_of_manufacture" required><br><br>

    <label for="capacity">Capacidade:</label>
    <input type="number" id="capacity" name="capacity" required><br><br>

    <label for="color">Cor:</label>
    <input type="text" id="color" name="color" required><br><br>

    <label for="fuel_type">Tipo de Combustível:</label>
    <input type="text" id="fuel_type" name="fuel_type" required><br><br>

    <label for="engine_power">Potência do Motor:</label>
    <input type="number" id="engine_power" name="engine_power" required><br><br>

    <input type="submit" value="Inserir Veículo">
</form>

<?php

// Verifica se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Função para validar o tipo de combustível
    function validarTipoCombustivel($tipo_combustivel) {
        // Lista de valores permitidos
        $valores_permitidos = array('G', 'A', 'D', 'F');
        // Verifica se o tipo de combustível está na lista de valores permitidos
        return in_array($tipo_combustivel, $valores_permitidos);
    }

    // Obtém os dados do formulário
    $vehicleData = [
        'placa' => $_POST['plate'],
        'marca' => $_POST['brand'],
        'modelo' => $_POST['model'],
        'ano_fabric' => $_POST['year_of_manufacture'],
        'capacidade_pass' => $_POST['capacity'],
        'cor' => $_POST['color'],
        'tipo_combust' => $_POST['fuel_type'],
        'potencia_motor' => $_POST['engine_power']
    ];

    // Verifica se o tipo de combustível é válido
    if (validarTipoCombustivel($vehicleData['tipo_combust'])) {
        // Uso da classe Singleton
        require_once '../../model/CMP1611_Query.php';
        $query = CMP1611_Query::getInstance();

        if($query->checkIfIdExists('veiculo', 'placa', $vehicleData['placa'])) {
            // Inserindo o veículo
            $inserted = $query->insert('veiculo', $vehicleData);
            if ($inserted) {
                $veiculo = $query->select_from_id('veiculo', 'placa', $_POST['plate']);
                echo "\n";
                print_r($veiculo);
                echo "\n";
                exit();
                echo "Veículo inserido com sucesso!";
            } else {
                echo "Falha ao inserir veículo.<br>";
            }
        } else{
            echo "Placa já cadastrada!";
        }

    } else {
        echo "Tipo de combustível inválido. Por favor, insira um tipo de combustível válido (G, A, D ou F).";
    }
}

?>
</body>
</html>
