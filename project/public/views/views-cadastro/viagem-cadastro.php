<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Inserir Viagem</title>
</head>
<body>
<h1>Inserir Viagem</h1>
<form action="viagem-cadastro.php" method="post">
	<label for="cpf_pass_viag">CPF do Passageiro:</label>
	<input type="number" id="cpf_pass_viag" name="cpf_pass_viag" required><br><br>

	<label for="cpf_mot_viag">CPF do Motorista:</label>
	<input type="number" id="cpf_mot_viag" name="cpf_mot_viag" required><br><br>

	<label for="placa_veic_viag">Placa do Veículo:</label>
	<input type="text" id="placa_veic_viag" name="placa_veic_viag" required><br><br>

	<label for="local_orig_viag">Local de Origem:</label>
	<input type="text" id="local_orig_viag" name="local_orig_viag" required><br><br>

	<label for="local_dest_viag">Local de Destino:</label>
	<input type="text" id="local_dest_viag" name="local_dest_viag" required><br><br>

	<label for="dt_hora_inicio">Data e Hora de Início:</label>
	<input type="datetime-local" id="dt_hora_inicio" name="dt_hora_inicio" required><br><br>

	<label for="dt_hora_fim">Data e Hora de Fim:</label>
	<input type="datetime-local" id="dt_hora_fim" name="dt_hora_fim" required><br><br>

	<label for="qtde_pass">Quantidade de Passageiros:</label>
	<input type="number" id="qtde_pass" name="qtde_pass" required><br><br>

	<label for="forma_pagto">Forma de Pagamento:</label>
	<input type="text" id="forma_pagto" name="forma_pagto" required><br><br>

	<label for="valor_pagto">Valor do Pagamento:</label>
	<input type="number" id="valor_pagto" name="valor_pagto" required><br><br>

	<label for="cancelam_mot">Viagem Cancelada pelo Motorista:</label>
	<input type="text" id="cancelam_mot" name="cancelam_mot" required><br><br>

	<label for="cancelam_pass">Viagem Cancelada pelo Passageiro:</label>
	<input type="text" id="cancelam_pass" name="cancelam_pass" required><br><br>

	<input type="submit" value="Inserir Viagem">
</form>

<?php

// Uso da classe Singleton
require_once '../../model/CMP1611_Viagem.php';

// Verifica se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	// Obtém os dados do formulário
	$viagemData = [
		'cpf_pass_viag' => $_POST['cpf_pass_viag'],
		'cpf_mot_viag' => $_POST['cpf_mot_viag'],
		'placa_veic_viag' => $_POST['placa_veic_viag'],
		'local_orig_viag' => $_POST['local_orig_viag'],
		'local_dest_viag' => $_POST['local_dest_viag'],
		'dt_hora_inicio' => date('Y-m-d H:i:s', strtotime($_POST['dt_hora_inicio'])),
		'dt_hora_fim' => date('Y-m-d H:i:s', strtotime($_POST['dt_hora_fim'])),
		'qtde_pass' => $_POST['qtde_pass'],
		'forma_pagto' => $_POST['forma_pagto'],
		'valor_pagto' => $_POST['valor_pagto'],
		'cancelam_mot' => $_POST['cancelam_mot'],
		'cancelam_pass' => $_POST['cancelam_pass']
	];

	$viagem = new CMP1611_Viagem(
		$viagemData['cpf_pass_viag'],
		$viagemData['cpf_mot_viag'],
		$viagemData['placa_veic_viag'],
		$viagemData['local_orig_viag'],
		$viagemData['local_dest_viag'],
		$viagemData['dt_hora_inicio'],
		$viagemData['dt_hora_fim'],
		$viagemData['qtde_pass'],
		$viagemData['forma_pagto'],
		$viagemData['valor_pagto'],
		$viagemData['cancelam_mot'],
		$viagemData['cancelam_pass']
	);

    $message = '';

	// Verifica se os dados da viagem são válidos
	if ($viagem->validate_settings($message, $viagemData)) {
		// Insere a viagem no banco de dados
		$viagem->getQuery()->insert('viagem', $viagemData);
		echo "Viagem inserida com sucesso!";
	} else {
		echo $message;
	}
}

?>
</body>
</html>
