<?php

require_once 'CMP1611_Query.php';
require_once 'CMP1611_Pessoa.php';

class CMP1611_Proprietario extends CMP1611_Pessoa
{
    private int $cpf_prop;
    private string $cnh_prop;
    private int $conta_prop;
    private int $banco_prop;
    private int $agencia_prop;

     /**
      * @param int $cpf
      * @param string $cnh
      * @param int $conta_prop
      * @param int $banco_prop
      * @param int $agencia_prop
      * @param int $telefone_prop
      * @param string $nome_prop
      * @param string $endereco_prop
      * @param string $email
      * @param string $sexo
      */

    public function __construct(
        string $cnh = '',
        int    $conta_prop = 0,
        int    $banco_prop = 0,
        int    $agencia_prop = 0,
        int $cpf = 0,
        int    $telefone_prop = 0,
        string $nome_prop = '',
        string $endereco_prop = '',
        string $email = '',
        string $sexo = ''
    )
    {
        parent::__construct($cpf, $nome_prop, $endereco_prop, $telefone_prop, $email, $sexo);

        $this->cnh = $cnh;
        $this->conta_prop = $conta_prop;
        $this->banco_prop = $banco_prop;
        $this->agencia_prop = $agencia_prop;
    }

    public function getCpfProp(): int
    {
        return $this->cpf_prop;
    }

    public function setCpfProp(int $cpf_prop): void
    {
        $this->cpf_prop = $cpf_prop;
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

    public function checkProprietarioExistence( string $cnh_prop): bool
    {
        if(empty($cnh_prop)){
            $cnh_prop = $this->getCnhProp();
        }

        return $this->query->checkIfIdExists('proprietarios', 'cnh_prop', $cnh_prop);
    }

    public function insertProprietario(array $proprietarioData)
    {
        return $this->query->insert('proprietarios', $proprietarioData);
    }

    public function selectProprietario(string $cpf_proprietario)
    {
        if (empty($cpf_proprietario)) {
            $cpf_proprietario = $this->getCpfProp();
        }

        $pessoaData = $this->selectPessoa($cpf_proprietario);
        unset($pessoaData['cpf_pessoa']);

        return array_merge($this->query->select_from_id('proprietarios', 'cpf_prop', $cpf_proprietario), $pessoaData);
    }

    public function validate_settings(&$message, $settings, $settings_pessoa): bool
    {
        if (empty($settings['cpf_prop'])) {
            $message = 'CPF não informado';
            return false;
        } else if (!preg_match("/^\d{11}$/", $settings['cpf_prop'])) {
            $message = 'CPF inválido. Deve conter 11 dígitos numéricos';
            return false;
        }

        if (empty($settings['cnh_prop'])) {
            $message = 'CNH não informada';
            return false;
        } else if (!preg_match("/^\d{11}$/", $settings['cnh_prop'])) {
            $message = 'CNH inválida. Deve conter 11 dígitos numéricos';
            return false;
        }

        if (empty($settings['banco_prop'])) {
            $message = 'Banco não informado';
            return false;
        } else if (!is_numeric($settings['banco_prop'])) {
            $message = 'Um valor númerico deve ser informado.';
            return false;
        }

        if (empty($settings['agencia_prop'])) {
            $message = 'Agência não informada';
            return false;
        } else if (!preg_match("/^\d+$/", $settings['agencia_prop'])) {
            $message = 'Agência inválida. Deve conter apenas dígitos numéricos';
            return false;
        }

        if (empty($settings['conta_prop'])) {
            $message = 'Conta não informada';
            return false;
        } else if (!preg_match("/^\d+$/", $settings['conta_prop'])) {
            $message = 'Conta inválida. Deve conter apenas dígitos numéricos';
            return false;
        }

        if (!CMP1611_Pessoa::validatePessoaData($message, $settings_pessoa)) {
            return false;
        }

        if($this->checkPessoaExistence($settings_pessoa['cpf_pessoa'])){
            $message = 'Pessoa já cadastrada';
            return false;
        }

        if($this->checkProprietarioExistence($settings['cnh_prop'])){
            $message = 'Proprietário já cadastrada';
            return false;
        }

        return true;
    }
}