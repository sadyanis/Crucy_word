<?php session_start();
if(!isset($_SESSION["user"])){
    header("Location: ./LOGIN/login.html");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./Style/style2.css">
    <script src="./Script/script.js"defer></script>
    <title>Home</title>
</head>
<body>
<?php require_once(__DIR__.'/menu.php') ?>
<div class="gridsettings">
    
    <aside class="side_index">
        <h2 class="title">Grilles</h2>
        <div>
            <h4>Veuillez sélectionner une grille :</h4>
            <div class="indications">
                  <ol class="liste_indice" id="horizontal_indice"></ol>  
            </div>
            <div>
                <button class="list_btn" id="add_hor">Créer une grille</button>
            </div>
        </div>
        
    </aside>
</div>

</body>

</html>