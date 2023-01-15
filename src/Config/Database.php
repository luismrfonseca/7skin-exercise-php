<?php

class Database {
    private static $db;
    private $connection;
    
    //DB Params
    private $host = 'localhost';
    private $dbname = 'database001';
    private $username = 'root';
    private $password = '';

    public function __construct()
    {
        $this->host = $_ENV['DBHOST'];
        $this->dbname = $_ENV['DBNAME'];
        $this->username = $_ENV['DBUSERNAME'];
        $this->password = $_ENV['DBPASSWORD'];

        try {
            $this->connection = new mysqli($this->host,$this->username,$this->password,$this->dbname);
        } catch (PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }
    }

    public function __destruct() {
      $this->connection->close();
    }

    public static function getConnection() {
      if (self::$db == null) {
        self::$db = new Database();
      }
      return self::$db->connection;
    }
}