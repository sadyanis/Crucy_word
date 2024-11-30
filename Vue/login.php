<?php
$user = 'yanis';
$passwd= 'yanis2001';


if(isset($_POST['UserName']) && isset( $_POST['password'])) {
    if((htmlspecialchars($_POST['UserName'])==$user) && (htmlspecialchars($_POST['password'])==$passwd)){
        header("Location: ./home2.php");
    }else{
        header("Location:./LOGIN/login.html");
    }

}



?>
