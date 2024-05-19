<?php


class CMP1611_Query{

    protected $conn;

    private $db_settings;
    public function __construct(){
        // Abre a conexão com a DB externa
        $this->db_settings          = DB_SETTINGS;
        $this->db_settings['drive'] = ! empty( $this->db_settings['drive'] ) ? $this->db_settings['drive'] : 'mysql';
        $pdo_port                   = ! empty( $this->db_settings['port'] ) ? ';port=' . $this->db_settings['port'] : '';

        $this->conn = new PDO( "{$this->db_settings['drive']}:host={$this->db_settings['host']}{$pdo_port};dbname={$this->db_settings['db_name']}", $this->db_settings['user'], $this->db_settings['pass'] );
        $this->conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }
}
