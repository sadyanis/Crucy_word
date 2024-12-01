<?php

require_once __DIR__ . '/../core/Database.php';

class User {
    private $db;

    public function __construct() {
        $this->db = (new Database())->connect();
    }

    // Insérer un nouvel utilisateur
    public function createUser($userId,$name,$passwd,$email,$role) {
        try{
        
            $sql = "INSERT INTO user VALUES(:userID, :name, :passwd, :email, :role)";
            $stmt = $this->db->prepare($sql);
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

    // Trouver un utilisateur par son nom d'utilisateur
    public function findByUsername($username) {
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
