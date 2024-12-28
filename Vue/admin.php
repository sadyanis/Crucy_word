<?php
session_start();
if (isset($_SESSION["role"]) && $_SESSION["role"]== "admin") {
    $role = $_SESSION["role"];
} else {
    header("Location: ./LOGIN/login.html");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./Style/style2.css?asdsadsad">
    <script src="./Script/admin.js" defer></script>
    <title>Document</title>
</head>
<body>
 <?php require_once(__DIR__.'/menu.php') ?>
    <div class="container"> 
        <aside class="side_index" >
         <h2 class="title">Grilles</h2>
         <div>
            <h4>Veuillez sélectionner une grille :</h4>
            <div class="indications">

                  <ol class="liste_grids" id="liste_grille" >
                    
                  </ol>  
            </div>
            <div class="controls">

                <label class="checkbox-label">
                    <input type="checkbox" id="filter-grids" />
                     Trier par difficulté
                </label>
            </div>

        </div>
        
    </aside>

    <aside class="side_index" >
        <h2 class="title">utilisateur</h2>
        <div>
            <h4>Liste des Utilisateurs :</h4>
            <div class="indications">

                  <ol class="liste_grids" id="liste_user" >
                   
                  </ol>  
            </div>
            <div class="controls">
                
                <button class="list_btn" id="createUser">Créer un utilisateur</button>
                
            </div>

        </div>
        
    </aside>
    </div>

</body>
</html>
<script></script>