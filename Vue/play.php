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
<div class="container">
    <div class="subcont">
    <!-- Zone des indices : lettres pour les lignes et numéros pour les colonnes -->
    <div class="indices">
        <div class="ligne_indices">
            <div class="case"></div> <!-- Coin supérieur gauche -->
            <?php for ($i = 1; $i <= 10; $i++) { ?>
                <div class="case2"><?php echo $i; ?></div> <!-- Numéros de colonnes -->
            <?php } ?>
        </div>

        <?php for ($i = 0; $i < 10; $i++) { ?>
            <div class="ligne_indices">
                <div class="case2"><?php echo chr(65 + $i); ?></div> <!-- Lettres des lignes -->
                <?php for ($j = 1; $j <= 10; $j++) { ?>
                    <div class="case grille_item" id="case_<?php echo $i . "_" . $j-1; ?>" data-x="<?php echo $i?>" data-y="<?php echo $j-1?>"></div>
                <?php } ?>
            </div>
        <?php } ?>
        
    </div>
    <button class="save" id="sauvegarder">Submit</button>
    
    </div>
    <aside class="side_index">
        <h2 class="title">Indices</h2>
        <div>
            <h3>Horizontal</h3>
            <div class="indications">
                  <ol class="liste_indice" id="horizontal_indice"></ol>  
            </div>
            
            <div>
                
            </div>
        </div>
        <div id="verticale">
            <h3>Vertical</h3>
            <div class="indications">
                  <ol class="liste_indice" id="vertical_indice" type="A"></ol>  
            </div>
            
            <div>
                
            </div>
        </div>
    </aside>
</div>

</body>

</html>