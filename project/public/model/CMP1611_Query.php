<?php

require_once 'CMP1611_Veiculo.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/CMP1611-TRABALHO-FINAL/constants.php';


class CMP1611_Query{
    /**
     * @var null
     */
    private static ?self $instance = null;
    private ?PDO $conn;

    private string $host;
    private string $dbname;
    private string $user;

    private string $schema;
    private string $password;

    // Construtor privado para impedir a criação direta de instâncias
    private function __construct()
    {
        $this->loadEnv();

        $this->host = $_ENV['DB_HOST'];
        $this->dbname = $_ENV['DB_NAME'];
        $this->user = $_ENV['DB_USER'];
        $this->schema = $_ENV['DB_SCHEMA'];
        $this->password = $_ENV['DB_PASSWORD'];

        $this->conn = null;

        try {
            $dsn = "pgsql:host=" . $this->host . ";dbname=" . $this->dbname;
            $this->conn = new PDO($dsn, $this->user, $this->password);
            // Configurar PDO para lançar exceções em caso de erro
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection error: " . $e->getMessage();
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function insert($table, $data) {
        try {
            $columns = implode(', ', array_keys($data));
            $placeholders = ':' . implode(', :', array_keys($data));
            $sql = "INSERT INTO $this->schema.$table ($columns) VALUES ($placeholders)";
            $stmt = $this->conn->prepare($sql);
            foreach ($data as $key => &$value) {
                $stmt->bindParam(':' . $key, $value);
            }
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Insert error: " . $e->getMessage();
        }
    }

    public function delete($table, $id)
    {
        try {
            $sql = "DELETE FROM $table WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            echo "Delete error: " . $e->getMessage();
        }
    }

    public function list($table)
    {
        try {
            $sql = "SELECT * FROM $this->schema.$table";
            $stmt = $this->conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "List error: " . $e->getMessage();
        }
    }

    public function select_from_id($table, $id_name, $id){
        try {
            $sql = "SELECT * FROM $this->schema.$table WHERE $id_name = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Select ID error: " . $e->getMessage();
        }
    }

    public function update($table, $data, $id)
    {
        try {
            $fields = '';
            foreach ($data as $key => $value) {
                $fields .= "$key = :$key, ";
            }
            $fields = rtrim($fields, ', ');
            $sql = "UPDATE $this->schema.$table SET $fields WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            foreach ($data as $key => &$value) {
                $stmt->bindParam(':' . $key, $value);
            }
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            echo "Update error: " . $e->getMessage();
        }
    }

    // Método para verificar se o ID já existe na tabela
    public function checkIfIdExists($table, $id_name, $id) {
        $sql = "SELECT COUNT(*) FROM $this->schema.$table WHERE $id_name = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count > 0;
    }

	public function selectPassageiro( int $cpf_pass_viag ) {
		$sql = "SELECT * FROM $this->schema.passageiros WHERE cpf_passag = :cpf_passag";
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':cpf_passag', $cpf_pass_viag);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function selectVeiculo(string $placa_veic_viag) {
		$sql = "SELECT * FROM $this->schema.veiculo WHERE placa = :placav";
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':placav', $placa_veic_viag);
		$stmt->execute();
		$data = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($data) {
			$veiculo = new CMP1611_Veiculo();

			$veiculo->setPlaca($data['placa']);
			$veiculo->setMarca($data['marca']);
			$veiculo->setModelo($data['modelo']);
			$veiculo->setAno($data['ano_fabric']);
			$veiculo->setCapacidade($data['capacidade_pass']);
			$veiculo->setCor($data['cor']);
			$veiculo->setTipoCombus($data['tipo_combust']);
			$veiculo->setPotenciaMotor($data['potencia_motor']);

			return $veiculo;
		}
		return null;
	}

	public function selectMotorista( int $cpf_mot_viag ) {
		$sql = "SELECT * FROM $this->schema.motoristas WHERE cpf_motorista = :cpf_motorista";
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':cpf_motorista', $cpf_mot_viag);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

    /**
     * @throws Exception
     */
    public function loadEnv(): void
    {
        $envPath = ROOT_DIR . '/.env' ; // Substitua pelo caminho correto para o seu arquivo .env
        if (!file_exists($envPath)) {
            throw new Exception('O arquivo .env não existe na raiz do projeto [ ' . ROOT_DIR . ' ].');
        }
        $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (str_contains($line, '=')) {
                list($name, $value) = explode('=', $line, 2);
                $_ENV[$name] = $value;
            }
        }
    }
}
