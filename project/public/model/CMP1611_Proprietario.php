<?php

require_once 'CMP1611_Query.php';
require_once 'CMP1611_Pessoa.php';

class CMP1611_Proprietario extends CMP1611_Pessoa
{
    private int $cpf_proprietario;

    public function __construct(
        int    $cpf_proprietario = 0,
        string $nome_proprietario = '',
        string $endereco_proprietario = '',
        int    $telefone_proprietario = 0,
        string $email = '',
        string $sexo = ''
    )
    {
        parent::__construct($cpf_proprietario, $nome_proprietario, $endereco_proprietario, $telefone_proprietario, $email, $sexo);

        $this->cpf_proprietario = $cpf_proprietario;
    }

    public function getCpfProprietario(): int
    {
        return $this->cpf_proprietario;
    }

    public function setCpfProprietario(int $cpf_proprietario): void
    {
        $this->cpf_proprietario = $cpf_proprietario;
    }

    public function checkProprietarioExistence(string $cpf_proprietario): bool
    {
        if (empty($cpf_proprietario)) {
            $cpf_proprietario = $this->getCpfProprietario();
        }

        return $this->query->checkIfIdExists('proprietarios', 'cpf_proprietario', $cpf_proprietario);
    }

    public function insertProprietario(array $proprietarioData)
    {
        return $this->query->insert('proprietarios', $proprietarioData);
    }

    public function selectProprietario(string $cpf_proprietario)
    {
        if (empty($cpf_proprietario)) {
            $cpf_proprietario = $this->getCpfProprietario();
        }

        $pessoaData = $this->selectPessoa($cpf_proprietario);
        unset($pessoaData['cpf_pessoa']);

        return array_merge($this->query->select_from_id('proprietarios', 'cpf_proprietario', $cpf_proprietario), $pessoaData);
    }
}