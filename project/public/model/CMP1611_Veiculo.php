<?php

require_once 'CMP1611_Query.php';

class CMP1611_Veiculo
{

    private string $placa;
    private string $marca;
    private string $modelo;
    private int $ano;
    private int $capacidade;
    private string $cor;
    private string $tipo_combus;
    private int $potencia_motor;
    private int $cpf_proprietario;
    private CMP1611_Query $query;

    /**
     * @param string $placa
     * @param string $marca
     * @param string $modelo
     * @param int $ano
     * @param int $capacidade
     * @param string $cor
     * @param string $tipo_combus
     * @param int $potencia_motor
     * @param int $cpf_proprietario
     */
    public
    function __construct(
        string $placa,
        string $marca,
        string $modelo,
        int    $ano,
        int    $capacidade,
        string $cor,
        string $tipo_combus,
        int    $potencia_motor,
        int    $cpf_proprietario
    )
    {
        $this->placa = $placa;
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->ano = $ano;
        $this->capacidade = $capacidade;
        $this->cor = $cor;
        $this->tipo_combus = $tipo_combus;
        $this->potencia_motor = $potencia_motor;
        $this->cpf_proprietario = $cpf_proprietario;

        $this->query = CMP1611_Query::getInstance();
    }


    public function getPlaca(): string
    {
        return $this->placa;
    }

    public function setPlaca(string $placa): void
    {
        $this->placa = $placa;
    }

    public function getMarca(): string
    {
        return $this->marca;
    }

    public function setMarca(string $marca): void
    {
        $this->marca = $marca;
    }

    public function getModelo(): string
    {
        return $this->modelo;
    }

    public function setModelo(string $modelo): void
    {
        $this->modelo = $modelo;
    }

    public function getAno(): int
    {
        return $this->ano;
    }

    public function setAno(int $ano): void
    {
        $this->ano = $ano;
    }

    public function getCapacidade(): int
    {
        return $this->capacidade;
    }

    public function setCapacidade(int $capacidade): void
    {
        $this->capacidade = $capacidade;
    }

    public function getCor(): string
    {
        return $this->cor;
    }

    public function setCor(string $cor): void
    {
        $this->cor = $cor;
    }

    public function getTipoCombus(): string
    {
        return $this->tipo_combus;
    }

    public function setTipoCombus(string $tipo_combus): void
    {
        $this->tipo_combus = $tipo_combus;
    }

    public function getPotenciaMotor(): int
    {
        return $this->potencia_motor;
    }

    public function setPotenciaMotor(int $potencia_motor): void
    {
        $this->potencia_motor = $potencia_motor;
    }

    public function getCpfProprietario(): int
    {
        return $this->cpf_proprietario;
    }

    public function setCpfProprietario(int $cpf_proprietario): void
    {
        $this->cpf_proprietario = $cpf_proprietario;
    }

    public function getQuery(): CMP1611_Query
    {
        return $this->query;
    }

    public function setQuery(CMP1611_Query $query): void
    {
        $this->query = $query;
    }

    public function checkPlateExistence(): bool
    {
        $placa = $this->placa;

        return $this->query->checkIfIdExists('veiculo', 'placa', $placa);
    }

    public function insertVehicle(): bool
    {
        $vehicleData = [
            'placa' => $this->placa,
            'marca' => $this->marca,
            'modelo' => $this->modelo,
            'ano' => $this->ano,
            'capacidade' => $this->capacidade,
            'cor' => $this->cor,
            'tipo_combus' => $this->tipo_combus,
            'potencia_motor' => $this->potencia_motor,
            'veiculo_proprietarios__fk' => $this->cpf_proprietario
        ];

        return $this->query->insert('veiculo', $vehicleData);
    }

    public function selectVehicle()
    {

        $placa = $this->placa;


        return $this->query->select_from_id('veiculo', 'placa', $placa);
    }

    public function checkPropietarioVeiculo(): bool
    {
        $cpf_proprietario = $this->cpf_proprietario;

        return $this->query->checkIfIdExists('veiculo', 'veiculo_proprietarios__fk', $cpf_proprietario);
    }

    public function validatePlaca(): bool
    {
        // Verificar se a placa é válida
        if (!preg_match("/^[A-Z]{3}-[0-9]{4}$/", $this->placa)) {
            return false;
        }

        if ($this->checkPlateExistence()) {
            return false;
        }

        return true;

    }

    public function validateMarca(): bool
    {
        // Verificar se a marca é válida
        return !empty($this->marca);
    }

    public function validateModelo(): bool
    {
        // Verificar se o modelo é válido
        return !empty($this->modelo);
    }

    public function validateAno(): bool
    {
        // Verificar se o ano é válido
        return preg_match("/^[0-9]{4}$/", $this->ano);
    }

    public function validateCapacidade(): bool
    {
        // Verificar se a capacidade é válida
        return $this->capacidade > 0;
    }

    public function validateCor(): bool
    {
        // Verificar se a cor é válida
        return !empty($this->cor);
    }

    public function validateTipoCombus(): bool
    {
        // Verificar se o tipo de combustível é válido
        return in_array($this->tipo_combus, ['G', 'A', 'D', 'F']);
    }

    public function validatePotenciaMotor(): bool
    {
        // Verificar se a potência do motor é válida
        return $this->potencia_motor > 0;
    }

    public function validateCpfProprietario(): bool
    {
        // Verificar se o CPF do proprietário é válido
        if (!preg_match("/^[0-9]{11}$/", $this->cpf_proprietario)) {
            return false;
        }

        if ($this->checkPropietarioVeiculo()) {
            return false;
        }

        return true;
    }

    public function validate_settings(string &$message): bool
    {
        // Verificar se todos os dados são válidos
        $validations = [
            'validatePlaca' => 'Erro de validação: Placa inválida.',
            'validateMarca' => 'Erro de validação: Marca inválida.',
            'validateModelo' => 'Erro de validação: Modelo inválido.',
            'validateAno' => 'Erro de validação: Ano inválido.',
            'validateCapacidade' => 'Erro de validação: Capacidade inválida.',
            'validateCor' => 'Erro de validação: Cor inválida.',
            'validateTipoCombus' => 'Erro de validação: Tipo de combustível inválido.',
            'validatePotenciaMotor' => 'Erro de validação: Potência do motor inválida.',
            'validateCpfProprietario' => 'Erro de validação: CPF do proprietário inválido.',
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