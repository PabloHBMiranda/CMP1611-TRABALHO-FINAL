<?php

require_once 'CMP1611_Query.php';
require_once 'CMP1611_Pessoa.php';

class CMP1611_Passageiro extends CMP1611_Pessoa {
	private int $cpf_passag;
	private string $cartao_cred;
	private string $bandeira_cartao;
	private string $cidade_orig;

	/**
	 * @param int $cpf
	 * @param string $cartao_cred
	 * @param string $bandeira_cartao
	 * @param string $cidade_orig
	 * @param string $nome_passag
	 * @param string $endereco_passag
	 * @param int $telefone_passag
	 * @param string $email
	 * @param string $sexo
	 */
	public function __construct(
		int $cpf = 0,
		string $cartao_cred = '',
		string $bandeira_cartao = '',
		string $cidade_orig = '',
		string $nome_passag = '',
		string $endereco_passag = '',
		int $telefone_passag = 0,
		string $email = '',
		string $sexo = ''
	) {
		parent::__construct( $cpf, $nome_passag, $endereco_passag, $telefone_passag,  $sexo, $email );

		$this->cpf_passag      = $cpf;
		$this->cartao_cred     = $cartao_cred;
		$this->bandeira_cartao = $bandeira_cartao;
		$this->cidade_orig     = $cidade_orig;
	}

	public function getQuery(): CMP1611_Query {
		return $this->query;
	}

	public function setQuery( CMP1611_Query $query ): void {
		$this->query = $query;
	}

	public function getCpfPassag(): int {
		return $this->cpf_passag;
	}

	public function setCpfPassag( int $cpf_passag ): void {
		$this->cpf_passag = $cpf_passag;
	}

	public function getCartaoCred(): string {
		return $this->cartao_cred;
	}

	public function setCartaoCred(string $cartao_cred): void {
		$this->cartao_cred = $cartao_cred;
	}

	public function getBandeiraCartao(): string {
		return $this->bandeira_cartao;
	}

	public function setBandeiraCartao(string $bandeira_cartao): void {
		$this->bandeira_cartao = $bandeira_cartao;
	}

	public function getCidadeOrig(): string {
		return $this->cidade_orig;
	}

	public function setCidadeOrig(string $cidade_orig): void {
		$this->cidade_orig = $cidade_orig;
	}

	public function validateCpfPassag( ): bool {
		// Check if the CPF is not empty
		if(empty($this->cpf_passag)) {
			return false;
		}

		// Remove any non-numeric characters
		$cpf_passag = preg_replace('/[^0-9]/', '', $this->cpf_passag);

		// Check if the CPF has 11 digits
		if(strlen($cpf_passag) != 11) {
			return false;
		}

		// Calculate the first verification digit
		for ($t = 9; $t < 11; $t++) {
			for ($d = 0, $c = 0; $c < $t; $c++) {
				$d += $cpf_passag[$c] * (($t + 1) - $c);
			}
			$d = ((10 * $d) % 11) % 10;
			if ($cpf_passag[$c] != $d) {
				return false;
			}
		}

		return true;
	}

	public function validateCartaoCred(): bool {
		// Add your validation logic here
		// For example, check if the credit card number is not empty
		return !empty($this->cartao_cred);
	}

	public function validateBandeiraCartao(): bool {
		// Add your validation logic here
		// For example, check if the card flag is not empty
		return !empty($this->bandeira_cartao);
	}


	public function validateCidadeOrig(): bool {
		// Add your validation logic here
		// For example, check if the city of origin is not empty
		return !empty($this->cidade_orig);
	}

	public function checkPassageiroExistence( string $cpf_passag ): bool {
		if ( empty( $cpf_passag ) ) {
			$cpf_passag = $this->getCpfPassag();
		}

		return $this->query->checkIfIdExists( 'passageiros', 'cpf_passag', $cpf_passag );
	}

	public function insertPassageiro(): ?bool {
		$passageiroData = [
			'cpf_passag'      => $this->getCpfPassag(),
			'cartao_cred'     => $this->getCartaoCred(),
			'bandeira_cartao' => $this->getBandeiraCartao(),
			'cidade_orig'     => $this->getCidadeOrig(),
		];

		return $this->query->insert( 'passageiros', $passageiroData );
	}

	public function selectPassageiro( string $cpf_passag ) {
		if ( empty( $cpf_passag ) ) {
			$cpf_passag = $this->getCpfPessoa();
		}

		$pessoaData = $this->selectPessoa( $cpf_passag );
		unset( $pessoaData['cpf_pessoa'] );

		return array_merge( $this->query->select_from_id( 'passageiros', 'cpf_passag', $cpf_passag ), $pessoaData );
	}

	public function updatePassageiro( array $passageiroData ): ?bool {
		return $this->query->update( 'passageiros', 'cpf_passag', $passageiroData['cpf_passag'], $passageiroData );
	}

	public function validate_settings( string &$message ): bool {
		// Verificar se todos os dados são válidos
		$validations = [
			'validateCpfPassag'      => 'CPF do passageiro inválido',
			'validateCartaoCred'     => 'Número do cartão de crédito inválido',
			'validateBandeiraCartao' => 'Bandeira do cartão inválida',
			'validateCidadeOrig'     => 'Cidade de origem inválida',
		];

		foreach ( $validations as $validation => $error ) {
			if ( ! $this->$validation() ) {
				$message = $error;

				return false;
			}
		}

		$settings_pessoa = [
			'cpf_pessoa' => $this->getCpfPassag(),
			'nome'       => $this->getNome(),
			'endereco'   => $this->getEndereco(),
			'telefone'   => $this->getTelefone(),
			'email'      => $this->getEmail(),
			'sexo'       => $this->getSexo(),
		];

		if ( ! CMP1611_Pessoa::validatePessoaData( $message, $settings_pessoa ) ) {
			return false;
		}

		if ( $this->checkPessoaExistence( $this->cpf_pessoa ) ) {
			$message = 'Pessoa já cadastrado';

			return false;
		}

		if ( $this->checkPassageiroExistence( $this->cpf_passag ) ) {
			$message = 'Passageiro já cadastrado';

			return false;
		}

		return true;
	}
}
