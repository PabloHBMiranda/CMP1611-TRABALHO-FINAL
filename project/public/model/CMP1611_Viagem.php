<?php

require_once 'CMP1611_Query.php';

class CMP1611_Viagem {

	private int $cpf_pass_viag;
	private int $cpf_mot_viag;
	private string $placa_veic_viag;
	private string $local_orig_viag;
	private string $local_dest_viag;
	private string $dt_hora_inicio;
	private string $dt_hora_fim;
	private int $qtde_pass;
	private string $forma_pagto;
	private int $valor_pagto;
	private string $cancelam_mot;
	private string $cancelam_pass;
	private CMP1611_Query $query;

	/**
	 * @param int $cpf_pass_viag
	 * @param int $cpf_mot_viag
	 * @param string $placa_veic_viag
	 * @param string $local_orig_viag
	 * @param string $local_dest_viag
	 * @param string $dt_hora_inicio
	 * @param string $dt_hora_fim
	 * @param int $qtde_pass
	 * @param string $forma_pagto
	 * @param int $valor_pagto
	 * @param string $cancelam_mot
	 * @param string $cancelam_pass
	 */
	public function __construct(
		int $cpf_pass_viag,
		int $cpf_mot_viag,
		string $placa_veic_viag,
		string $local_orig_viag,
		string $local_dest_viag,
		string $dt_hora_inicio,
		string $dt_hora_fim,
		int $qtde_pass,
		string $forma_pagto,
		int $valor_pagto,
		string $cancelam_mot,
		string $cancelam_pass
	) {
		$this->cpf_pass_viag   = $cpf_pass_viag;
		$this->cpf_mot_viag    = $cpf_mot_viag;
		$this->placa_veic_viag = $placa_veic_viag;
		$this->local_orig_viag = $local_orig_viag;
		$this->local_dest_viag = $local_dest_viag;
		$this->dt_hora_inicio  = $dt_hora_inicio;
		$this->dt_hora_fim     = $dt_hora_fim;
		$this->qtde_pass       = $qtde_pass;
		$this->forma_pagto     = $forma_pagto;
		$this->valor_pagto     = $valor_pagto;
		$this->cancelam_mot    = $cancelam_mot;
		$this->cancelam_pass   = $cancelam_pass;

		$this->query = CMP1611_Query::getInstance();
	}

	public function getCpfPassViag(): int {
		return $this->cpf_pass_viag;
	}

	public function setCpfPassViag( int $cpf_pass_viag ): void {
		$this->cpf_pass_viag = $cpf_pass_viag;
	}

	public function getCpfMotViag(): int {
		return $this->cpf_mot_viag;
	}

	public function setCpfMotViag( int $cpf_mot_viag ): void {
		$this->cpf_mot_viag = $cpf_mot_viag;
	}

	public function getPlacaVeicViag(): string {
		return $this->placa_veic_viag;
	}

	public function setPlacaVeicViag( string $placa_veic_viag ): void {
		$this->placa_veic_viag = $placa_veic_viag;
	}

	public function getLocalOrigViag(): string {
		return $this->local_orig_viag;
	}

	public function setLocalOrigViag( string $local_orig_viag ): void {
		$this->local_orig_viag = $local_orig_viag;
	}

	public function getLocalDestViag(): string {
		return $this->local_dest_viag;
	}

	public function setLocalDestViag( string $local_dest_viag ): void {
		$this->local_dest_viag = $local_dest_viag;
	}

	public function getDtHoraInicio(): string {
		return $this->dt_hora_inicio;
	}

	public function setDtHoraInicio( string $dt_hora_inicio ): void {
		$this->dt_hora_inicio = $dt_hora_inicio;
	}

	public function getDtHoraFim(): string {
		return $this->dt_hora_fim;
	}

	public function setDtHoraFim( string $dt_hora_fim ): void {
		$this->dt_hora_fim = $dt_hora_fim;
	}

	public function getQtdePass(): int {
		return $this->qtde_pass;
	}

	public function setQtdePass( int $qtde_pass ): void {
		$this->qtde_pass = $qtde_pass;
	}

	public function getFormaPagto(): string {
		return $this->forma_pagto;
	}

	public function setFormaPagto( string $forma_pagto ): void {
		$this->forma_pagto = $forma_pagto;
	}

	public function getValorPagto(): int {
		return $this->valor_pagto;
	}

	public function setValorPagto( int $valor_pagto ): void {
		$this->valor_pagto = $valor_pagto;
	}

	public function getCancelamMot(): string {
		return $this->cancelam_mot;
	}

	public function setCancelamMot( string $cancelam_mot ): void {
		$this->cancelam_mot = $cancelam_mot;
	}

	public function getCancelamPass(): string {
		return $this->cancelam_pass;
	}

	public function setCancelamPass( string $cancelam_pass ): void {
		$this->cancelam_pass = $cancelam_pass;
	}


	public function getQuery(): CMP1611_Query {
		return $this->query;
	}

	public function setQuery( CMP1611_Query $query ): void {
		$this->query = $query;
	}

	public function validateCpfPassViag(): bool
	{
		// Verificar se o CPF é válido
		if (!preg_match("/^[0-9]{11}$/", $this->cpf_pass_viag)) {
			return false;
		}

		// Verificar se o passageiro está cadastrado no sistema
		$passageiro = $this->query->selectPassageiro($this->cpf_pass_viag);
		if ($passageiro === null) {
			return false;
		}

		return true;
	}

	public function validateCpfMotViag(): bool
	{
		// Verificar se o CPF é válido
		if (!preg_match("/^[0-9]{11}$/", $this->cpf_mot_viag)) {
			return false;
		}

		// Verificar se o motorista está cadastrado no sistema
		$motorista = $this->query->selectMotorista($this->cpf_mot_viag);
		if ($motorista === null) {
			return false;
		}

		return true;
	}

	public function validatePlacaVeicViag(): bool
	{
		// Verificar se o veículo está cadastrado no sistema
		$veiculo = $this->query->selectVeiculo($this->placa_veic_viag);
		if ($veiculo === null) {
			return false;
		}

		return true;
	}

	public function validateLocalOrigViag(): bool
	{
		// Verificar se o local de origem é válido
		// A validação específica depende do formato dos locais no seu sistema
		return !empty($this->local_orig_viag);
	}

	public function validateLocalDestViag(): bool
	{
		// Verificar se o local de destino é válido
		// A validação específica depende do formato dos locais no seu sistema
		return !empty($this->local_dest_viag);
	}

	public function validateDtHoraInicio(): bool
	{
		// Verificar se a data e hora de início são válidas
		$date = DateTime::createFromFormat('Y-m-d H:i:s', $this->dt_hora_inicio);
		return $date && $date->format('Y-m-d H:i:s') === $this->dt_hora_inicio;
	}

	public function validateDtHoraFim(): bool
	{
		// Verificar se a data e hora de fim são válidas
		$date = DateTime::createFromFormat('Y-m-d H:i:s', $this->dt_hora_fim);
		return $date && $date->format('Y-m-d H:i:s') === $this->dt_hora_fim;
	}

	public function validateQtdePass(): bool
	{
		// Verificar se a quantidade de passageiros é um número válido
		// e se não excede a capacidade do veículo
		return is_int($this->qtde_pass) && $this->qtde_pass > 0 && $this->qtde_pass <= $this->query->selectVeiculo($this->placa_veic_viag)->getCapacidade();
	}

	public function validateFormaPagto(): bool
	{
		// Verificar se a forma de pagamento é válida
		// A validação específica depende das formas de pagamento aceitas no seu sistema
		return in_array($this->forma_pagto, ['DINHEIRO', 'CARTAO', 'POSTERIORI']);
	}

	public function validateValorPagto(): bool
	{
		// Verificar se o valor do pagamento é um número válido
		return is_int($this->valor_pagto) && $this->valor_pagto > 0;
	}

	public function validateCancelamMot(): bool
	{
		// Verificar se o cancelamento pelo motorista é um valor S ou N
		return in_array($this->cancelam_mot, ['S', 'N']);
	}

	public function validateCancelamPass(): bool
	{
		// Verificar se o cancelamento pelo passageiro é um valor S ou N
		return in_array($this->cancelam_pass, ['S', 'N']);
	}

	public function validate_settings( string &$message, array $data ): bool
	{
		// Verificar se todos os dados são válidos
		$validations = [
			'validateCpfPassViag' => 'Erro de validação: CPF do passageiro inválido ou não cadastrado.',
			'validateCpfMotViag' => 'Erro de validação: CPF do motorista inválido ou não cadastrado.',
			'validatePlacaVeicViag' => 'Erro de validação: Placa do veículo inválida ou não cadastrada.',
			'validateLocalOrigViag' => 'Erro de validação: Local de origem inválido.',
			'validateLocalDestViag' => 'Erro de validação: Local de destino inválido.',
			'validateDtHoraInicio' => 'Erro de validação: Data e hora de início inválidas.',
			'validateDtHoraFim' => 'Erro de validação: Data e hora de fim inválidas.',
			'validateQtdePass' => 'Erro de validação: Quantidade de passageiros inválida ou excede a capacidade do veículo.',
			'validateFormaPagto' => 'Erro de validação: Forma de pagamento inválida.',
			'validateValorPagto' => 'Erro de validação: Valor do pagamento inválido.',
			'validateCancelamMot' => 'Erro de validação: Valor inválido para cancelamento pelo motorista.',
			'validateCancelamPass' => 'Erro de validação: Valor inválido para cancelamento pelo passageiro.'
		];

		foreach ($validations as $validation => $error) {
			if (!$this->$validation()) {
				$message = $error;
				return false;
			}
		}

		return true;
	}

}
