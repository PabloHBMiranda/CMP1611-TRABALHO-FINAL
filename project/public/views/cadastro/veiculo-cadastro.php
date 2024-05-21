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

    <label for="proprietary">CPF do Proprietário:</label>
    <input type="number" id="proprietary" name="proprietary" required><br><br>

    <input type="submit" value="Inserir Veículo">
</form>

<?php

require_once '../../model/CMP1611_Veiculo.php';

// Verifica se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Obtém os dados do formulário
    $vehicleData = [
        'placa' => $_POST['plate'],
        'marca' => $_POST['brand'],
        'modelo' => $_POST['model'],
        'ano_fabric' => $_POST['year_of_manufacture'],
        'capacidade_pass' => $_POST['capacity'],
        'cor' => $_POST['color'],
        'tipo_combust' => $_POST['fuel_type'],
        'potencia_motor' => $_POST['engine_power'],
        'proprietario_veiculo_fk' => $_POST['proprietary']
    ];

    // Verifica se o tipo de combustível é válido
    if (CMP1611_Veiculo::validate_settings($message, $vehicleData)) {

        $veiculo = new CMP1611_Veiculo();

        if (!$veiculo->checkOwner($vehicleData['proprietario_veiculo_fk'])) {
            if (!$veiculo->checkPlateExistence($vehicleData['placa'])) {
                if ($veiculo->insertVehicle($vehicleData)) {
                    $veiculo_dados = $veiculo->selectVehicle($vehicleData['placa']);
                    echo "Veículo inserido com sucesso!";
                } else {
                    echo "Falha ao inserir veículo.<br>";
                }
            } else {
                echo "Placa {$vehicleData['placa']} já cadastrada!";
            }
        } else{
            echo "Proprietário com CPF {$vehicleData['proprietario_veiculo_fk']} não cadastrado!";
        }

    } else {
        echo $message;
    }
}

?>
</body>
</html>
