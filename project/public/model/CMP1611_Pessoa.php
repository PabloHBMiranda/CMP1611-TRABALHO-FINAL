<?php

require_once 'CMP1611_Query.php';

class CMP1611_Pessoa
{
    protected int $cpf;
    protected string $nome;
    protected string $endereco;
    protected int $telefone;
    protected string $sexo;
    protected string $email;
    protected ?CMP1611_Query $query;

    public function
    __construct(
        int    $cpf = 0,
        string $nome = '',
        string $endereco = '',
        int    $telefone = 0,
        string $sexo = '',
        string $email = ''
    )
    {
        $this->query = CMP1611_Query::getInstance();
        $this->cpf = $cpf;
        $this->nome = $nome;
        $this->endereco = $endereco;
        $this->telefone = $telefone;
        $this->sexo = $sexo;
        $this->email = $email;
    }

    // getters e setters para os atributos acima

    public function getCpf(): int
    {
        return $this->cpf;
    }

    public function setCpfPessoa(int $cpf): void
    {
        $this->cpf = $cpf;
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

    public function insertPessoa()
    {

        $pessoaData = [
            'cpf_pessoa' => $this->cpf,
            'nome' => $this->nome,
            'email' => $this->email,
            'sexo' => $this->sexo,
            'endereco' => $this->endereco,
            'telefone' => $this->telefone,
        ];

        return $this->query->insert('pessoas', $pessoaData);
    }

    public function selectPessoa()
    {
        $cpf = $this->getCpf();

        return $this->query->select_from_id('pessoas', 'cpf_pessoa', $cpf);
    }

    public function checkCpfPessoaExistence(): bool
    {
        return $this->query->checkIfIdExists('pessoas', 'cpf_pessoa', $this->cpf);
    }

    public function validateCpfPessoa(): bool
    {
        // Verificar se o CPF é válido
        if (!preg_match("/^[0-9]{11}$/", $this->cpf)) {
            return false;
        }

        if ($this->checkCpfPessoaExistence()) {
            return false;
        }

        return true;
    }

    public function validateNome(): bool
    {
        return !empty($this->nome);
    }

    public function validateEndereco(): bool
    {
        return !empty($this->endereco);
    }

    public function validateTelefone(): bool
    {

        if (!preg_match("/^[0-9]{11}$/", $this->cpf)) {
            return false;
        }

        return true;
    }

    public function validateSexo(): bool
    {
        // Verificar se o sexo é válido
        return in_array($this->sexo, ['M', 'F']);
    }

    public function validateEmail(): bool
    {
        // Verificar se o email é válido
        return filter_var($this->email, FILTER_VALIDATE_EMAIL);
    }

    public function validate_settings_pessoa(string &$message): bool
    {
        // Verificar se todos os dados são válidos
        $validations = [
            'validateCpfPessoa' => 'Erro de validação: CPF da Pessoa inválido ou já cadastrado.',
            'validateNome' => 'Erro de validação: Nome inválido ou não cadastrado.',
            'validateEndereco' => 'Erro de validação: Endereço inválido ou não cadastrado.',
            'validateTelefone' => 'Erro de validação: Telefone inválido ou não cadastrado.',
            'validateSexo' => 'Erro de validação: Sexo inválido ou não cadastrado.',
            'validateEmail' => 'Erro de validação: Email inválido ou não cadastrado.',
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