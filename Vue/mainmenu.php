<?php session_start();
if(isset($_SESSION["role"])){
$role = $_SESSION["role"];
if($role == "visitor"){
    header("Location: ./mainmenuVisitor.php");
}
if($role == "admin"){
    header("Location: ./Admin.php");
}
}
if(isset($_SESSION['gameData'])){
    unset($_SESSION['gameData']);
}
if(isset($_SESSION['gridID'])){
    unset($_SESSION['gridID']);
}

// if(!isset($_SESSION["user"])){
//     header("Location: ./LOGIN/login.html");
// }


require_once __DIR__ . '/../model/gridModel.php';
$model = new GridModel();
$gridNames = $model->getAllGridNames();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./Style/style2.css?asdsadsad">
    <title>Home</title>
</head>
<body>
<?php require_once(__DIR__.'/menu.php') ?>
<div class="gridsettings">
    
    <aside class="side_index" id="sideIndex2">
        <h2 class="title">Grilles</h2>
        <div>
            <h4>Veuillez sélectionner une grille :</h4>
            <div class="indications">

                  <ol class="liste_grids" id="vertical_indices">
                    <?php 
                     if (!empty($gridNames)) {
                        foreach ($gridNames as $gridName) {
                            echo "<li data-grid-id=\"" . htmlspecialchars($gridName['gridID']) . "\">" . htmlspecialchars($gridName['gridName']) ."<span class=\"level\" >".htmlspecialchars($gridName['level']) . "</span> </li>";
                        }
                    } else {
                        echo "<li>Aucune grille trouvée.</li>";
                    } 
                    ?>
                  </ol>  
            </div>
            <div class="controls">
                
                <button class="list_btn" id="add_grid_btnn">Créer une grille</button>
                
                <label class="checkbox-label">
                    <input type="checkbox" id="filter-my-grids" />
                     Trier par difficulté
                </label>
            </div>

        </div>
        
    </aside>

    <aside class="side_index" id="sideIndex">
        <h2 class="title">Parties</h2>
        <div>
            <h4>Veuillez sélectionner une partie :</h4>
            <div class="indications">

                  <ol class="liste_grids" id="liste_games">
                    <li> Aucune partie </li>
                  </ol>  
            </div>
            <div class="controls">
                

            </div>

        </div>
        
    </aside>

</div>

<div id="modale" class="modal hidden">
    <div class="modal-content">
        <h3 class="title">Créer une nouvelle grille</h3>
        <form id="create-grid-form" action="home2.php" method="POST">
            <label for="grid_name">Nom de la grille :</label>
            <input type="text" id="grid_name" name="grid_name" required>

            <label for="grid_dimension">Dimension :</label>
            <input type="number" id="grid_dimension" name="grid_dimension" min="2" max="21" required>
                    
            <label for="grid_dimension">Difficulté :</label>
            <select name = "level" id="level" required>
                <option value="1">Débutant</option>
                <option value="2">Intermédiaire</option>
                <option value="3">Expert</option>
            </select>
            <div class="modal-buttons">
                <button type="submit" class="submit-btn">Créer</button>
                <button type="button" id="close_modale" class="cancel-btn">Annuler</button>
            </div>
        </form>
    </div>
</div>


<script src="./Script/mainmenuUser.js" defer></script>
</body>
</html>