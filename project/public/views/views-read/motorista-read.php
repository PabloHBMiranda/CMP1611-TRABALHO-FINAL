<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Listar Motoristas</title>
    <link rel="stylesheet" href="../../styles/read.css">
</head>
<body>
<h1>Listar Motoristas</h1>
<table class="read">
	<thead>
	<tr>
		<th>CPF</th>
		<th>Nome</th>
		<th>Endereço</th>
		<th>Telefone</th>
		<th>Email</th>
		<th>Sexo</th>
		<th>Ações</th>
	</tr>
	</thead>
	<tbody>
	<?php
	require_once '../../model/CMP1611_Motorista.php';

	$motorista = new CMP1611_Motorista();
	$motoristas = $motorista->getQuery()->select_all_motoristas();

	foreach ($motoristas as $motorista) {
		echo "<tr>";
		echo "<td>{$motorista['cpf_motorista']}</td>";
		echo "<td>{$motorista['nome']}</td>";
		echo "<td>{$motorista['endereco']}</td>";
		echo "<td>{$motorista['telefone']}</td>";
		echo "<td>{$motorista['email']}</td>";
		echo "<td>{$motorista['sexo']}</td>";
		echo "<td><a href='../views-updates/motorista-update.php?cpf={$motorista['cpf_motorista']}'>Editar</a></td>";
		echo "</tr>";
	}
	?>
	</tbody>
</table>
</body>
</html>
