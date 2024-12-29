<?php session_start(); 
// if(!isset($_SESSION["user"])){
//     header("Location: ./LOGIN/login.html");
// }

$gridData = isset($_SESSION['gridData']) ? $_SESSION['gridData'] : null;
$gridDimension =  $gridData['dimension']['dimension']-1;


// Résultat
 // Vérification
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./Style/style2.css">
    <script src="./Script/script2.js?sdasdasd"defer></script>
    
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
        <button class="save" id="submit">Submit</button>
        <?php if(isset($_SESSION['role']) && $_SESSION['role'] !== 'visitor'){ ?>
        <button class="save" id="reset">save</button>
         <?php } ?>
    </div>
    
    </div>
    <aside class="side_index">
        <h2 class="title">Indices</h2>
        <div>
            <h3>Horizontal</h3>
            <div class="indications">
                  <ol class="liste_indice" id="horizontal_hint">
                  <?php  
                  foreach ($gridData['hints'] as $data) {
                        $orientation = $data['hint_orientation'];
                        $indice = $data['hint_content'];
                        if ($orientation == 'horizontal') {

                ?>
                    <li><?php echo $indice; }}?></li>

                  </ol>  
            </div>
            
            <div>
                
            </div>
        </div>
       
        <div id="verticale">
            <h3>Vertical</h3>
            <div class="indications">
                  <ol class="liste_indice" id="vertical_hints" type="A">
                    <?php 
                    $index = 0;
                    foreach ($gridData['hints'] as $data) {
                            $orientation = $data['hint_orientation'];
                            $indice = $data['hint_content'];
                            if ($orientation == 'vertical') { ?>
                        <li><?php echo   $indice; }}?></li>
                  </ol>  
            </div>
            <div>
            
            </div>
        </div>
    </aside>
</div>

</body>

</html>