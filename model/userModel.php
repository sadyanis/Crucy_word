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
        
            $sql = "INSERT INTO USERS VALUES(:user_id, :user_name, :user_password, :user_email, :user_role)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':user_id'=> $userId,
                ':user_name'=> $name,
                ':user_password'=> password_hash($passwd, PASSWORD_BCRYPT),
                ':user_email'=> $email,
                ':user_role'=> $role,
            ]);
            return true;

        }catch(PDOException $e){
            die("Erreur d'incription:".$e->getMessage());
        }

}

    // Trouver un utilisateur par son nom d'utilisateur
    public function findUser($username,$password) {
        try{
        $sql = "SELECT * FROM USERS WHERE user_id = :user_name" ;
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_name' => $username]);
        $user =  $stmt->fetch(PDO::FETCH_ASSOC);

        if($user && password_verify($password,$user['user_password'])){
            return $user;
        }
        return false;
    }catch(PDOException $e){
        die('Erreur'.$e->getMessage());
    }
}

    public function getUsers (){
      try{
        $sql =  "SELECT user_id from USERS";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $users;
      }catch(PDOException $e){
        die("Erreur Lors du creation des users: ". $e->getMessage());
       }  
    }
}
