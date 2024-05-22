<?php

require_once 'CMP1611_Query.php';
require_once 'CMP1611_Pessoa.php';

class CMP1611_Motorista extends CMP1611_Pessoa
{
    private int $cpf_mot;
    private string $cnh;
    private int $conta_mot;
    private int $banco_mot;
    private int $agencia_mot;

    /**
     * @param int $cpf_mot
     * @param string $cnh
     * @param int $conta_mot
     * @param int $banco_mot
     * @param int $agencia_mot
     * @param int $telefone_mot
     * @param string $nome_mot
     * @param string $endereco_mot
     * @param string $email
     * @param string $sexo
     */
    public
    function __construct(
        int    $cpf_mot = 0,
        string $cnh = '',
        int    $conta_mot = 0,
        int    $banco_mot = 0,
        int    $agencia_mot = 0,
        int    $telefone_mot = 0,
        string $nome_mot = '',
        string $endereco_mot = '',
        string $email = '',
        string $sexo = ''
    )
    {
        parent::__construct($cpf_mot, $nome_mot, $endereco_mot, $telefone_mot, $email, $sexo);

        $this->cpf_mot = $cpf_mot;
        $this->cnh = $cnh;
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

    public function getCpfMot(): int
    {
        return $this->cpf_mot;
    }

    public function setCpfMot(int $cpf_mot): void
    {
        $this->cpf_mot = $cpf_mot;
    }

    public function getCnh(): string
    {
        return $this->cnh;
    }

    public function setCnh(string $cnh): void
    {
        $this->cnh = $cnh;
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

    public function checkMotoristaExistence(string $cpf_mot): bool
    {

        if (empty($cpf_mot)) {
            $cpf_mot = $this->getCpfMot();
        }

        return $this->query->checkIfIdExists('motoristas', 'cpf_motorista', $cpf_mot);
    }

    public function insertMotorista(array $motoristaData)
    {
        return $this->query->insert('motoristas', $motoristaData);
    }

    public function selectMotorista(string $cpf_mot)
    {
        if (empty($cpf_mot)) {
            $cpf_mot = $this->getCpfMot();
        }

        $pessoaData = $this->selectPessoa($cpf_mot);
        unset($pessoaData['cpf_pessoa']);

        return array_merge($this->query->select_from_id('motoristas', 'cpf_motorista', $cpf_mot), $pessoaData);
    }

    public static function validate_settings(&$message = '', $settings, $settings_pessoa): bool
    {
        if (empty($settings['cpf_motorista'])) {
            $message = 'CPF não informado';
            return false;
        } else if (!preg_match("/^\d{11}$/", $settings['cpf_motorista'])) {
            $message = 'CPF inválido. Deve conter 11 dígitos numéricos';
            return false;
        }

        if (empty($settings['cnh'])) {
            $message = 'CNH não informada';
            return false;
        } else if (!preg_match("/^\d{11}$/", $settings['cnh'])) {
            $message = 'CNH inválida. Deve conter 11 dígitos numéricos';
            return false;
        }

        if (empty($settings['banco_mot'])) {
            $message = 'Banco não informado';
            return false;
        } else if (!is_numeric($settings['banco_mot'])) {
            $message = 'Um valor númerico deve ser informado.';
            return false;
        }

        if (empty($settings['agencia_mot'])) {
            $message = 'Agência não informada';
            return false;
        } else if (!preg_match("/^\d+$/", $settings['agencia_mot'])) {
            $message = 'Agência inválida. Deve conter apenas dígitos numéricos';
            return false;
        }

        if (empty($settings['conta_mot'])) {
            $message = 'Conta não informada';
            return false;
        } else if (!preg_match("/^\d+$/", $settings['conta_mot'])) {
            $message = 'Conta inválida. Deve conter apenas dígitos numéricos';
            return false;
        }

        if (!CMP1611_Pessoa::validatePessoaData($message, $settings_pessoa)) {
            return false;
        }

        return true;
    }
}