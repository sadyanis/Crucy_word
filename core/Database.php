<?php
class Database{
    private $host = 'localhost';
    private $dbname = 'crossword_db';
    private $username = 'root';
    private $password = 'crossword_password';

    // public function __construct($host, $username, $password){
    //     $this->host = $host;
    //     $this->username = $username;
    //     $this->password = $password;
    // }

    public function connect() {
        try{
        $dsn = "mysql:host={$this->host};dbname={$this->dbname}";
        $pdo = new PDO($dsn,$this->username,$this->password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        return $pdo;
        }catch(PDOException $e){
            die("Erreur de connexion ". $e->getMessage());
    }
}
}
?>