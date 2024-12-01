<?php
require_once(__DIR__."/../model/userModel.php");

 class AuthController{
    private $UserModel;
    public function __construct(){
        $this->UserModel = new User();
    }

    public function Register(){
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $UserId = htmlspecialchars($_POST['UserName']);
            $name = htmlspecialchars($_POST['Name']);
            $password = htmlspecialchars($_POST['password']);
            $email = htmlspecialchars($_POST['email']);
            $role = 'user';
            if($this->UserModel->createUser($UserId, $name, $password, $email, $role)){
                header("Location: login.html");
                exit();
            }else{
                return "Erreur lors de l'inscription";
            }
        }
    }
 }
?>