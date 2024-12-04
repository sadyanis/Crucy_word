<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/style2.css">
    <script src="./Script/script.js"defer></script>
    <title>Home</title>
</head>
<body>
<?php require_once(__DIR__.'/menu.php') ?>
<div class="container">
    <!-- Zone des indices : lettres pour les lignes et numéros pour les colonnes -->
    <div class="indices">
        <div class="ligne_indices">
            <div class="case"></div> <!-- Coin supérieur gauche -->
            <?php for ($i = 1; $i <= 10; $i++) { ?>
                <div class="case"><?php echo $i; ?></div> <!-- Numéros de colonnes -->
            <?php } ?>
        </div>

        <?php for ($i = 0; $i < 10; $i++) { ?>
            <div class="ligne_indices">
                <div class="case"><?php echo chr(65 + $i); ?></div> <!-- Lettres des lignes -->
                <?php for ($j = 1; $j <= 10; $j++) { ?>
                    <div class="case grille_item" id="case_<?php echo $i . "_" . $j-1; ?>" data-x="<?php echo $i?>" data-y="<?php echo $j-1?>"></div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>
</body>

</html>