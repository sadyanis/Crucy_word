<?php
header('Content-Type: application/json');
session_start(); 
if(!isset($_SESSION["user"])){
    header("Location: ./LOGIN/login.html");
}
$gridData = isset($_SESSION['gridData']) ? json_decode($_SESSION['gridData'], true) : null;
$gridDimension =  $gridData['dimension']['dimension']-1;
$correctGrid = array_fill(0, $gridDimension, array_fill(0, $gridDimension, '')); // Tableau vide

// Remplir $correctGrid avec les cases
foreach ($gridData['cases'] as $case) {
    $row = (int)$case['row']; // Ligne de la case
    $col = (int)$case['line']; // Colonne de la case
    $content = $case['contenu']; // Contenu de la case

    // Placer le contenu dans la grille
    $correctGrid[$row][$col] = $content;
}

echo json_encode(['data' => $correctGrid]);
