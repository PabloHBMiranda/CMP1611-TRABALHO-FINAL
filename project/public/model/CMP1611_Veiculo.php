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
     */
    public
    function __construct(
        string $placa = '',
        string $marca = '',
        string $modelo = '',
        int    $ano = 0,
        int    $capacidade = 0,
        string $cor = '',
        string $tipo_combus = '',
        int    $potencia_motor = 0
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

    public function getQuery(): CMP1611_Query
    {
        return $this->query;
    }

    public function setQuery(CMP1611_Query $query): void
    {
        $this->query = $query;
    }

    public function checkPlateExistence(string $placa = ''): bool
    {
        if (empty($placa)) {
            $placa = $this->getPlaca();
        }

        return $this->query->checkIfIdExists('veiculo', 'placa', $placa);
    }

    public function insertVehicle(array $vehicleData): bool
    {
        return $this->query->insert('veiculo', $vehicleData);
    }

    public function selectVehicle(string $placa = '')
    {

        if (empty($placa)) {
            $placa = $this->getPlaca();
        }

        return $this->query->select_from_id('veiculo', 'placa', $placa);
    }

    public static function validate_settings(&$message = '', $settings): bool
    {
        if (strlen($settings['placa']) != 7) {
            if (strlen($settings['placa']) < 7) {
                $message = 'Placa com menos de 7 caracteres';
            } else {
                $message = 'Placa com mais de 7 caracteres';
            }
            return false;
        }

        if (empty($settings['marca'])) {
            $message = 'Marca do carro não informada';
            return false;
        }

        if (empty($settings['modelo'])) {
            $message = 'Modelo do carro não informado';
            return false;
        }

        if (empty($settings['ano_fabric'])) {
            $message = 'Ano de Fabricação não informado';
            return false;
        } else if ($settings['ano_fabric'] < 1960) {
            $message = 'Ano de Fabricação inválido';
            return false;
        } else if ($settings['ano_fabric'] > 2024) {
            $message = 'Ano de Fabricação inválido';
            return false;
        }

        if (empty($settings['capacidade_pass'])) {
            $message = 'Capacidade de Passageiros não informada';
            return false;
        } else if ($settings['capacidade_pass'] < 5 || $settings['capacidade_pass'] > 8) {
            $message = 'Capacidade de Passageiros inválida';
            return false;
        }

        if (empty($settings['tipo_combust'])) {
            $message = 'Tipo de combustivel não informado';
            return false;
        } else if (!in_array($settings['tipo_combust'], ['G', 'A', 'D', 'F'])) {
            $message = 'Tipo de combustível inválido. Por favor, insira um tipo de combustível válido (G, A, D ou F).';
            return false;
        }

        if (empty($settings['potencia_motor'])) {
            $message = 'Potência do motor inválida';
            return false;
        } else if ($settings['capacidade_pass'] < 0) {
            $message = 'Capacidade inválida';
            return false;
        }

        return true;
    }

}