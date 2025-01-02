<?php
require_once(__DIR__."/../model/userModel.php");
session_start();

 class AuthController{
    private $UserModel;
    public $error_message;
    public function __construct(){
        $this->UserModel = new User();
    }

    public function Register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $UserId = htmlspecialchars($_POST['UserName']);
            $name = htmlspecialchars($_POST['Name']);
            $password = htmlspecialchars($_POST['password']);
            $email = htmlspecialchars($_POST['email']);
            $role = 'user';
    
            if (!isset($_SESSION['role'])) {
                $_SESSION['role'] = $role;
            }
    
            $result = $this->UserModel->createUser($UserId, $name, $password, $email, $role);
    
            if ($result === true) {
                if ($_SESSION['role'] == 'admin') {
                    header("Location: ../admin.php");
                    exit();
                }
                header("Location: login.html");
                exit();
            } else {
                // si une erreur s'est produite stocker le message dans error_message
                $this->error_message = $result;
            }
        }
    }
    

    public function Login(){
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $UserId = htmlspecialchars($_POST['UserName']);
            $password = htmlspecialchars($_POST['password']);
            $user = $this->UserModel->findUser($UserId, $password);
            if($user){
                // régénère l'ID de session pour sécuriser la session après la connexion
                session_regenerate_id();
                if($user['role'] == 'admin'){
                    $_SESSION['user'] = $user['UserID'];
                    $_SESSION['role'] = "admin";
                    header("Location: ../Vue/admin.php");
                    exit();
                }
                

                $_SESSION['user'] = $user['UserID'];
                $_SESSION['role'] = "user";
                header("Location: ../Vue/mainmenu.php");
                exit();
            }else{
                header("Location: ./LOGIN/login.html");
                
            }
        }else{
            
            $_SESSION['role'] = 'visitor';
            header("Location: ../Vue/mainmenuVisitor.php");
        }
    }
    public function Logout(){
        
        session_unset();
        session_destroy();
        header("Location: ./LOGIN/login.html");
        exit();

    }
    public function isLogged(){
        if(isset($_SESSION['user']) || isset($_SESSION['role']) ){
            return true;
        }else{
            return false;
        }
    }   

 }
?>