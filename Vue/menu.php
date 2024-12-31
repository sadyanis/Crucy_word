<nav>
<h2 class="logo"><a href="mainmenu.php">CrussyWord</a></h2>
<ul>
    <?php
    
    
    // Vérifie le rôle et affiche le lien correspondant
    if (isset($_SESSION['role'])) {
        if ($_SESSION['role'] === 'admin') {
            echo '<li><a href="admin.php">Home</a></li>';
        } elseif ($_SESSION['role'] === 'user') {
            echo '<li><a href="mainmenu.php">Home</a></li>';
        } else {
            echo '<li><a href="mainmenuVisitor.php">Home</a></li>';
        }
    } else {
        // Si $_SESSION['role'] n'est pas défini
        echo '<li><a href="mainmenuVisitor.php">Home</a></li>';
    }
    ?>
    
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