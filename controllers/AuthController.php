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
                echo "Bonjour";
                header("Location: login.html");
                exit();
            }else{
                return "Erreur lors de l'inscription";
            }
        }
    }

    public function Login(){
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $UserId = htmlspecialchars($_POST['UserName']);
            $password = htmlspecialchars($_POST['password']);
            $user = $this->UserModel->findUser($UserId, $password);
            if($user){
                session_start();
                $_SESSION['user'] = $user['UserID'];
                header("Location: ../Vue/home2.php");
                exit();
            }else{
                header("Location: ./LOGIN/login.html");
                
            }
        }
    }
    public function Logout(){
        session_start();
        session_unset();
        session_destroy();
        header("Location: ./LOGIN/login.html");
        exit();

    }

 }
?>