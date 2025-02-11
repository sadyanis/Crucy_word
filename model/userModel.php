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
            return "Erreur d'inscription : " . $e->getMessage();
        }

}

    // Trouver un utilisateur par son nom d'utilisateur
    public function findUser($username,$password) {
        try{
        $sql = "SELECT * FROM user WHERE UserID = :username" ;
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':username' => $username]);
        $user =  $stmt->fetch(PDO::FETCH_ASSOC);

        if($user && password_verify($password,$user['password'])){
            return $user;
        }
        return false;
    }catch(PDOException $e){
        die('Erreur'.$e->getMessage());
    }
}

    public function getUsers (){
      try{
        $sql =  "SELECT UserID from user where role != 'admin'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $users;
      }catch(PDOException $e){
        die("Erreur Lors du creation des users: ". $e->getMessage());
       }  
    }

    public function deleteUser($userID){
        try{
            $sql = "DELETE FROM user WHERE UserID = :userID";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':userID' => $userID]);
            return true;
        }catch(PDOException $e){
            die("Erreur lors de la suppression de l'utilisateur: ".$e->getMessage());
        }
    }
}
