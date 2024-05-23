<?php

require_once 'CMP1611_Query.php';
require_once 'CMP1611_Pessoa.php';

class CMP1611_Motorista extends CMP1611_Pessoa
{
    private string $cnh_mot;
    private int $conta_mot;
    private int $banco_mot;
    private int $agencia_mot;

    /**
     * @param int $cpf
     * @param string $cnh_mot
     * @param int $conta_mot
     * @param int $banco_mot
     * @param int $agencia_mot
     * @param int $telefone_mot
     * @param string $nome_mot
     * @param string $endereco_mot
     * @param string $email_mot
     * @param string $sexo_mot
     */
    public
    function __construct(
        int    $cpf = 0,
        string $cnh_mot = '',
        int    $banco_mot = 0,
        int    $conta_mot = 0,
        int    $agencia_mot = 0,
        string $nome_mot = '',
        string $endereco_mot = '',
        int    $telefone_mot = 0,
        string $email_mot = '',
        string $sexo_mot = ''
    )
    {
        parent::__construct($cpf, $nome_mot, $endereco_mot, $telefone_mot, $sexo_mot, $email_mot);

        $this->cnh_mot = $cnh_mot;
        $this->conta_mot = $conta_mot;
        $this->banco_mot = $banco_mot;
        $this->agencia_mot = $agencia_mot;
    }


    public function getQuery(): CMP1611_Query
    {
        return $this->query;
    }

    public function setQuery(CMP1611_Query $query): void
    {
        $this->query = $query;
    }

    public function getCnhMot(): string
    {
        return $this->cnh_mot;
    }

    public function setCnhMot(string $cnh_mot): void
    {
        $this->cnh_mot = $cnh_mot;
    }

    public function getContaMot(): int
    {
        return $this->conta_mot;
    }

    public function setContaMot(int $conta_mot): void
    {
        $this->conta_mot = $conta_mot;
    }

    public function getBancoMot(): int
    {
        return $this->banco_mot;
    }

    public function setBancoMot(int $banco_mot): void
    {
        $this->banco_mot = $banco_mot;
    }

    public function getAgenciaMot(): int
    {
        return $this->agencia_mot;
    }

    public function setAgenciaMot(int $agencia_mot): void
    {
        $this->agencia_mot = $agencia_mot;
    }

    //Verifica se o CPF do Motorista existe
    public function checkCpfMotoristaExistence(): bool
    {
        $cpf_mot = $this->cpf;

        return $this->query->checkIfIdExists('motoristas', 'cpf_motorista', $cpf_mot);
    }

    //Verifica se a CNH existe
    public function checkCnhExistence(): bool
    {
        $cnh_mot = $this->cnh_mot;

        return $this->query->checkIfIdExists('motoristas', 'cnh', $cnh_mot);
    }

    public function insertMotorista(): ?bool
    {

        $motoristaData = [
            'cpf_motorista' => $this->cpf,
            'cnh' => $this->cnh_mot,
            'banco_mot' => $this->banco_mot,
            'agencia_mot' => $this->agencia_mot,
            'conta_mot' => $this->conta_mot
        ];

        if ($this->insertPessoa()) {
            if ($this->query->insert('motoristas', $motoristaData)) {
                return true;
            }
        }
        return false;
    }

    public function validateCpfMotorista(): bool
    {
        // Verificar se o CPF é válido
        if (!preg_match("/^[0-9]{11}$/", $this->cpf)) {
            return false;
        }

        if ($this->checkCpfMotoristaExistence()) {
            return false;
        }

        return true;
    }

    public function validateCnh(): bool
    {
        // Verificar se o CPF é válido
        if (!preg_match("/^\d{11}$/", $this->cnh_mot)) {
            return false;
        }

        if ($this->checkCnhExistence()) {
            return false;
        }

        return true;
    }

    public function validateBancoMot(): bool
    {
        return !empty($this->banco_mot);
    }

    public function validateAgenciaMot(): bool
    {
        return !empty($this->agencia_mot);
    }

    public function validateContaMot(): bool
    {
        return !empty($this->conta_mot);
    }

    public function validate_settings(string &$message): bool
    {
        // Verificar se todos os dados são válidos
        $validations = [
            'validateCpfMotorista' => 'Erro de validação: CPF do Motorista inválido ou já cadastrado.',
            'validateCnh' => 'Erro de validação: CNH do Motorista inválida ou já cadastrada.',
            'validateBancoMot' => 'Erro de validação: Banco inválido ou não cadastrado.',
            'validateAgenciaMot' => 'Erro de validação: Agência inválida ou não cadastrada.',
            'validateContaMot' => 'Erro de validação: Conta inválida ou não cadastrada.',
        ];

        foreach ($validations as $validation => $error) {
            if (!$this->$validation()) {
                $message = $error;
                return false;
            }
        }

        $this->validate_settings_pessoa($message);

        return true;
    }
}