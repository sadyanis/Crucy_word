<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/style.css">
    <script src="./Script/script.js"defer></script>
    <title>Home</title>
</head>
<body>
    <?php require_once(__DIR__.'/menu.php') ?>
        <aside class="Aside">

        </aside>
    <div class="container">    
        <div class="grille">
            
            <?php for($i=1;$i<=100;$i++){ ?>
            <div class="grille_item" id='<?php echo $i ?>'>  </div>

        <?php } ?>

        </div>    
    
    </div>
</body>
</html>