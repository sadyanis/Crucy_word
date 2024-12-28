<nav>
<h2 class="logo"><a href="mainmenu.php">CrussyWord</a></h2>
        <ul>
        
        
            <li><a href="mainmenu.php">Home</a></li>
            <li><a href="#">Contact</a></li>
            <li><a href="#">Regles de Jeux</a></li>
            <li><a href="#">Apropos</a></li>
        </ul>
        <div class="sing" >
            <ul>
            <?php 
            
            if(isset($_SESSION['user'])){
                ?>
                <li><a href="#"> <?php echo $_SESSION['user']; ?> </a></li>
                <li><a href="logout.php">Deconnexion</a></li>

                <?php } else{ ?>

            <li><a href="./LOGIN/login.html">Sing in</a></li>
            <li><a href="./LOGIN/signup.php">Sing up</a></li>
            <?php } ?>
            </ul>
        </div>
    </nav>