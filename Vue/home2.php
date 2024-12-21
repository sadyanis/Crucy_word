<?php 

require_once __DIR__ . '/../controllers/AuthController.php';
 $AuthController = new AuthController();
 if(!$AuthController->isLogged()){
     header("Location: ./LOGIN/login.html");
 }
 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gridName = isset($_POST['grid_name']) ? htmlspecialchars($_POST['grid_name'], ENT_QUOTES, 'UTF-8') : null;
    $gridDimension = isset($_POST['grid_dimension']) ? (int)$_POST['grid_dimension'] : 10;
 }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./Style/style2.css">
    <script src="./Script/script.js?sdasdasd"defer></script>
   
    <title>Home</title>
</head>
<body>
<?php require_once(__DIR__.'/menu.php') ?>
<div class="container">
    <div class="subcont">
    <!-- Zone des indices : lettres pour les lignes et numéros pour les colonnes -->
    <div class="indices" data-dimension="<?php echo htmlspecialchars(((int)$gridDimension+1)); ?>">
        <div class="ligne_indices">
            <div class="case"></div> <!-- Coin supérieur gauche -->
            <?php for ($i = 1; $i <= $gridDimension; $i++) { ?>
                <div class="case2"><?php echo $i; ?></div> <!-- Numéros de colonnes -->
            <?php } ?>
        </div>

        <?php for ($i = 0; $i < $gridDimension; $i++) { ?>
            <div class="ligne_indices">
                <div class="case2"><?php echo chr(65 + $i); ?></div> <!-- Lettres des lignes -->
                <?php for ($j = 1; $j <= $gridDimension; $j++) { ?>
                    <div class="case grille_item" id="case_<?php echo $i . "_" . $j-1; ?>" data-x="<?php echo $i?>" data-y="<?php echo $j-1?>"></div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
    
    <div>
    <button class="save" id="sauvegarder">Save</button>
    <button class="save" >Clear</button>
    </div>
    </div>
    <aside class="side_index">
        <h2 class="title">Indices</h2>
        <div>
            <h3>Horizontal</h3>
            <div class="indications">
                  <ol class="liste_indice" id="horizontal_indice"></ol>  
            </div>
            <input id="hor_indice" type="text" placeholder="Ajouter un indice...">
            <div>
                <button class="list_btn" id="add_hor">Ajouter</button>
                <button class="list_btn" id="delete_hor">Effacer</button>
            </div>
        </div>
        <div id="verticale" >
            <h3>Vertical</h3>
            <div class="indications">
                  <ol class="liste_indice" id="vertical_indice" type="A"></ol>  
            </div>
            <input id="ver_indice" type="text" placeholder="Ajouter un indice...">
            <div>
                <button class="list_btn" id="add_vert">Ajouter</button>
                <button class="list_btn" id="delete_ver">Effacer</button>
            </div>
        </div>
    </aside>
</div>

</body>

</html>