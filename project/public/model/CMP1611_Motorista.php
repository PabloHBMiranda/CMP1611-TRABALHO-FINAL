<?php

require_once 'CMP1611_Query.php';

class CMP1611_Motorista
{

    private CMP1611_Query $query;
    private int $cpf_mot;
    private string $cnh;
    private int $telefone_mot;
    private string $nome_mot;
    private string $endereco_mot;
    private int $conta_mot;
    private int $banco_mot;
    private int $agencia_mot;

    /**
     * @param int $cpf_mot
     * @param string $cnh
     * @param int $telefone_mot
     * @param string $nome_mot
     * @param string $endereco_mot
     * @param int $conta_mot
     * @param int $banco_mot
     * @param int $agencia_mot
     */
    public
    function __construct(
        int $cpf_mot,
        string $cnh,
        int $telefone_mot,
        string $nome_mot,
        string $endereco_mot,
        int $conta_mot,
        int $banco_mot,
        int $agencia_mot
    ) {
        $this->cpf_mot = $cpf_mot;
        $this->cnh = $cnh;
        $this->telefone_mot = $telefone_mot;
        $this->nome_mot = $nome_mot;
        $this->endereco_mot = $endereco_mot;
        $this->conta_mot = $conta_mot;
        $this->banco_mot = $banco_mot;
        $this->agencia_mot = $agencia_mot;

        $this->query = CMP1611_Query::getInstance();
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

    public function getTelefoneMot(): int
    {
        return $this->telefone_mot;
    }

    public function setTelefoneMot(int $telefone_mot): void
    {
        $this->telefone_mot = $telefone_mot;
    }

    public function getNomeMot(): string
    {
        return $this->nome_mot;
    }

    public function setNomeMot(string $nome_mot): void
    {
        $this->nome_mot = $nome_mot;
    }

    public function getEnderecoMot(): string
    {
        return $this->endereco_mot;
    }

    public function setEnderecoMot(string $endereco_mot): void
    {
        $this->endereco_mot = $endereco_mot;
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

    public static function validate_settings(){

    }
}