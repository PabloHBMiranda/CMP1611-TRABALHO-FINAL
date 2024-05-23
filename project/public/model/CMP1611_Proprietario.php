<?php

require_once 'CMP1611_Query.php';
require_once 'CMP1611_Pessoa.php';

class CMP1611_Proprietario extends CMP1611_Pessoa
{
    private string $cnh_prop;
    private int $conta_prop;
    private int $banco_prop;
    private int $agencia_prop;

    /**
     * @param int $cpf
     * @param string $cnh_prop
     * @param int $banco_prop
     * @param int $conta_prop
     * @param int $agencia_prop
     * @param string $nome_prop
     * @param string $endereco_prop
     * @param int $telefone_prop
     * @param string $email_prop
     * @param string $sexo_prop
     */

    public function __construct(
        int    $cpf = 0,
        string $cnh_prop = '',
        int    $banco_prop = 0,
        int    $conta_prop = 0,
        int    $agencia_prop = 0,
        string $nome_prop = '',
        string $endereco_prop = '',
        int    $telefone_prop = 0,
        string $email_prop = '',
        string $sexo_prop = ''
    )
    {
        parent::__construct($cpf, $nome_prop, $endereco_prop, $telefone_prop, $email_prop, $sexo_prop);

        $this->cnh_prop = $cnh_prop;
        $this->banco_prop = $banco_prop;
        $this->conta_prop = $conta_prop;
        $this->agencia_prop = $agencia_prop;
    }


    public function getCnhProp(): string
    {
        return $this->cnh_prop;
    }

    public function setCnhProp(string $cnh_prop): void
    {
        $this->cnh_prop = $cnh_prop;
    }

    public function getContaProp(): int
    {
        return $this->conta_prop;
    }

    public function setContaProp(int $conta_prop): void
    {
        $this->conta_prop = $conta_prop;
    }

    public function getBancoProp(): int
    {
        return $this->banco_prop;
    }

    public function setBancoProp(int $banco_prop): void
    {
        $this->banco_prop = $banco_prop;
    }

    public function getAgenciaProp(): int
    {
        return $this->agencia_prop;
    }

    public function setAgenciaProp(int $agencia_prop): void
    {
        $this->agencia_prop = $agencia_prop;
    }

    public function checkCpfProprietarioExistence(): bool
    {
        $cpf_prop = $this->cpf;

        return $this->query->checkIfIdExists('proprietarios', 'cpf_prop', $cpf_prop);
    }

    public function checkCnhProprietarioExistence(): bool
    {

        $cnh_prop = $this->cnh_prop;

        return $this->query->checkIfIdExists('proprietarios', 'cnh_prop', $cnh_prop);
    }

    public function insertProprietario(): ?bool
    {
        $proprietarioData = [
            'cpf_prop' => $this->cpf,
            'cnh_prop' => $this->cnh_prop,
            'banco_prop' => $this->banco_prop,
            'agencia_prop' => $this->agencia_prop,
            'conta_prop' => $this->conta_prop
        ];

        if ($this->insertPessoa()) {
            if ($this->query->insert('proprietarios', $proprietarioData)) {
                return true;
            }
        }
        return false;
    }

    public function validateCpfProprietario(): bool
    {
        // Verificar se o CPF é válido
        if (!preg_match("/^[0-9]{11}$/", $this->cpf)) {
            return false;
        }

        // Verificar se o proprietário está cadastrado no sistema
        if ($this->checkCpfProprietarioExistence()) {
            return false;
        }

        return true;
    }

    public function validateCnhProp(): bool
    {
        // Verificar se a CNH é válida
        if (!preg_match("/^\d{11}$/", $this->cnh_prop)) {
            return false;
        }

        if ($this->checkCnhProprietarioExistence()) {
            return false;
        }

        return true;
    }

    public function validateBancoProp(): bool
    {
        // Verificar se o banco é válido
        return !empty($this->banco_prop);
    }

    public function validateAgenciaProp(): bool
    {
        // Verificar se a agência é válida
        return !empty($this->agencia_prop);
    }

    public function validateContaProp(): bool
    {
        // Verificar se a conta é válida
        return !empty($this->conta_prop);
    }

    public function validate_settings(string &$message): bool
    {
        // Verificar se todos os dados são válidos
        $validations = [
            'validateCpfProprietario' => 'Erro de validação: CPF do Proprietário inválido ou já cadastrado.',
            'validateCnhProp' => 'Erro de validação: CNH inválida ou já cadastrada.',
            'validateBancoProp' => 'Erro de validação: Banco inválido ou não cadastrado.',
            'validateAgenciaProp' => 'Erro de validação: Agência inválida ou não cadastrada.',
            'validateContaProp' => 'Erro de validação: Conta inválida ou não cadastrada.',
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