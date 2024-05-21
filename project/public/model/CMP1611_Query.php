<?php

class CMP1611_Query{
    /**
     * @var null
     */
    private static $instance;
    private $conn;

    private $host = 'localhost';
    private $dbname = 'cmp1611_pablo_vinicius_tales_renato';
    private $user = 'postgres';

    private $schema = 'cmp1611_trabalho_final';
    private $password = '123';

    // Construtor privado para impedir a criação direta de instâncias
    private function __construct()
    {
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

}
