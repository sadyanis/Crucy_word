<?php include "../../controllers/AuthController.php" ;

$controler = new AuthController();
$controler->Register();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleLog.css?uyty">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <script src="./formvalidation.js"defer></script>
    <title> Login</title>
</head>
<body>
    
    <div class="container">

        <div class="formContainer">
            
            <div class="sliderSection">
               <img src="Images_log\pexels-brettjordan-6550632.jpg" alt="slideImage" id="img"> 
            </div>

            <div class="formsection">
               
              <h1>  Sign Up</h1>
                     <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post" class="form" id="form">
             <div class="inputRow ">
                 <div class="inputIcons">
                    <i class='bx bxs-user'></i>
                 </div>
                 <input type="text" name="Name" id="Name" placeholder="UserName" required pattern="[A-Za-z]{2,}"  title=" ne convient pas">
             </div>

             <div class="inputRow Up">
                <div class="inputIcons">
                   <i class='bx bxs-user'></i>
                </div>
                <input type="text" name="UserName" id="Identifiant" placeholder="UserID" required>
            </div>
            
             <div class="inputRow" id="passwd">
                 <div class="inputIcons">
                    <i class='bx bxs-lock-open'></i>
                 </div>
                 <input type="password" name="password" id="pwd" placeholder="User_Password" required>
             </div>

             <div class="inputRow Up" >
                <div class="inputIcons">
                   <i class='bx bxs-lock-open'></i>
                </div>
                <input type="password" name="Conf_password" id="conf_pwd" placeholder="Confirm_Password" required pattern=".{8,}" title="dois contenir au moin 8 caracteres">
            </div>

            <div class="inputRow Up" >
                <div class="inputIcons">
                   <i >@</i>
                </div>
                <input type="email" name="email" id="email" placeholder="exemple@mail.com" required
                pattern="^[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$" title="Veuillez entrer une adresse email valide" >
            </div>
            <div class="eroor" id="error-message">

            </div>
            <?php if (!empty($controler->error_message)): ?>
                <div class="error"><?= htmlspecialchars($controler->error_message); ?></div>
                 <?php $controler->error_message = ""; ?>
                <?php endif; ?>

               
                  
                  <div class="btnRow" id="singupDiv">
                      <input type="submit" value="S'inscrire" id="signupBtn"  class="btn"> 
                  </div>
                  
                </form>
                  
               
            </div>
            <a href="#" id="credits"> Created By Heizenberg  </a>
          </div>
      

    </div>
    
</body>
</html>