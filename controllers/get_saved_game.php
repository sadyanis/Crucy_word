<?php
header('Content-Type: application/json');
session_start(); 
if (isset($_SESSION['gameData']) ){
    echo json_encode(['success' => true, 'data' => $_SESSION['gameData']]);
    exit;
}else{
    echo json_encode(['saved' => 'False']);
    exit;
}