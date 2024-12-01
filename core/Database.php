<?php
class Database{
    private $host = 'db';
    private $dbname = 'crossword';
    private $username = 'root';
    private $password = '336699';

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

    public function createUser($userId,$name,$passwd,$email,$role) {
        try{
            $pdo = $this->connect();
            $sql = "INSERT INTO user VALUES(:userID, :name, :passwd, :email, :role)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':userID'=> $userId,
                ':name'=> $name,
                ':passwd'=> password_hash($passwd, PASSWORD_BCRYPT),
                ':email'=> $email,
                ':role'=> $role,
            ]);
            return true;

        }catch(PDOException $e){
            die("Erreur d'incription:".$e->getMessage());
        }

}
}
?>