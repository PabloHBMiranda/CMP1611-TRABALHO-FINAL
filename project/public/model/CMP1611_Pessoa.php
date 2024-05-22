<?php

require_once 'CMP1611_Query.php';

class CMP1611_Pessoa
{
    protected int $cpf_pessoa;
    protected string $nome;
    protected string $endereco;
    protected int $telefone;
    protected string $sexo;
    protected string $email;
    protected ?CMP1611_Query $query;

    public function
    __construct(
        int    $cpf_pessoa = 0,
        string $nome = '',
        string $endereco = '',
        int    $telefone = 0,
        string $sexo = '',
        string $email = ''
    ) {
        $this->query = CMP1611_Query::getInstance();
        $this->cpf_pessoa = $cpf_pessoa;
        $this->nome = $nome;
        $this->endereco = $endereco;
        $this->telefone = $telefone;
        $this->sexo = $sexo;
        $this->email = $email;
    }

    // getters e setters para os atributos acima

    public function getCpfPessoa(): int
    {
        return $this->cpf_pessoa;
    }

    public function setCpfPessoa(int $cpf_pessoa): void
    {
        $this->cpf_pessoa = $cpf_pessoa;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    public function getEndereco(): string
    {
        return $this->endereco;
    }

    public function setEndereco(string $endereco): void
    {
        $this->endereco = $endereco;
    }

    public function getTelefone(): int
    {
        return $this->telefone;
    }

    public function setTelefone(int $telefone): void
    {
        $this->telefone = $telefone;
    }

    public function getSexo(): string
    {
        return $this->sexo;
    }

    public function setSexo(string $sexo): void
    {
        $this->sexo = $sexo;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }


    public function insertPessoa(array $pessoaData)
    {
        return $this->query->insert('pessoas', $pessoaData);
    }

    public function selectPessoa(string $cpf_pessoa)
    {
        if (empty($cpf_pessoa)) {
            $cpf_pessoa = $this->getCpfPessoa();
        }

        return $this->query->select_from_id('pessoas', 'cpf_pessoa', $cpf_pessoa);
    }

    public function checkPessoaExistence(string $cpf_pessoa = ''): bool
    {
        if (empty($cpf_pessoa)) {
            $cpf_pessoa = $this->getCpfPessoa();
        }

        return $this->query->checkIfIdExists('pessoas', 'cpf_pessoa', $cpf_pessoa);
    }

    public static function validatePessoaData(&$message = '', $pessoaData): bool
    {
        if (empty($pessoaData['cpf_pessoa'])) {
            $message = 'CPF não informado';
            return false;
        } else if (!preg_match("/^\d{11}$/", $pessoaData['cpf_pessoa'])) {
            $message = 'CPF inválido. Deve conter 11 dígitos numéricos';
            return false;
        }

        if (empty($pessoaData['nome'])) {
            $message = 'Nome não informado';
            return false;
        }

        if (empty($pessoaData['endereco'])) {
            $message = 'Endereço não informado';
            return false;
        }

        if (empty($pessoaData['telefone'])) {
            $message = 'Telefone não informado';
            return false;
        } else if (!preg_match("/^\d+$/", $pessoaData['telefone'])) {
            $message = 'Telefone inválido. Deve conter apenas dígitos numéricos';
            return false;
        }

        if (empty($pessoaData['sexo'])) {
            $message = 'Sexo não informado';
            return false;
        } else if (!in_array($pessoaData['sexo'], ['M', 'F'])) {
            $message = 'Sexo inválido. Deve ser M (Masculino) ou F (Feminino)';
            return false;
        }

        if (empty($pessoaData['email'])) {
            $message = 'Email não informado';
            return false;
        } else if (!filter_var($pessoaData['email'], FILTER_VALIDATE_EMAIL)) {
            $message = 'Email inválido';
            return false;
        }

        return true;
    }
}