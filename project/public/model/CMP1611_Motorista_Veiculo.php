<?php

require_once 'CMP1611_Query.php';
class CMP1611_Motorista_Veiculo
{

    private int $cpf_motorista_veiculo;

    private string $placa_veiculo_motorista;

    private CMP1611_Query $query;

    /**
     * @param int $cpf_motorista_veiculo
     * @param string $placa_veiculo_motorista
     */
    public function __construct(int $cpf_motorista_veiculo, string $placa_veiculo_motorista)
    {
        $this->cpf_motorista_veiculo = $cpf_motorista_veiculo;
        $this->placa_veiculo_motorista = $placa_veiculo_motorista;

        $this->query = CMP1611_Query::getInstance();
    }

    public function getCpfMotorista(): int
    {
        return $this->cpf_motorista_veiculo;
    }

    public function setCpfMotorista(int $cpf_motorista_veiculo): void
    {
        $this->cpf_motorista_veiculo = $cpf_motorista_veiculo;
    }

    public function getPlacaVeiculo(): string
    {
        return $this->placa_veiculo_motorista;
    }

    public function setPlacaVeiculo(string $placa_veiculo_motorista): void
    {
        $this->placa_veiculo_motorista = $placa_veiculo_motorista;
    }

    public function getQuery(): CMP1611_Query
    {
        return $this->query;
    }

    public function setQuery(CMP1611_Query $query): void
    {
        $this->query = $query;
    }

    public function validateCpfMotVeic(): bool
    {
        // Verificar se o CPF é válido
        if (!preg_match("/^[0-9]{11}$/", $this->cpf_motorista_veiculo)) {
            return false;
        }

        // Verificar se o motorista está cadastrado no sistema
        $motorista = $this->query->selectMotorista($this->cpf_motorista_veiculo);
        if ($motorista === null) {
            return false;
        }

        return true;
    }

    public function validateVeicCpfMot(): bool
    {
        // Verificar se o CPF é válido
        if (empty($this->placa_veiculo_motorista) || (strlen($this->placa_veiculo_motorista) > 7 || strlen($this->placa_veiculo_motorista) < 7)) {
            return false;
        }

        // Verificar se o motorista está cadastrado no sistema
        $motorista = $this->query->selectVeiculoPlaca($this->placa_veiculo_motorista);
        if ($motorista === null) {
            return false;
        }

        return true;
    }


    public function validate_settings(string &$message): bool
    {
        // Verificar se todos os dados são válidos
        $validations = [
            'validateCpfMotVeic' => 'Erro de validação: CPF do proprietário inválido ou não cadastrado.',
            'validateVeicCpfMot' => 'Erro de validação: Placa do veículo inválida ou não cadastrada.'
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