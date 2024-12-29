<?php
session_start();
header('content-type: application/json');
require_once(__DIR__ . '/../model/gridModel.php');
$userID = $_SESSION['user'];
$model = new GridModel();
$gamesData = $model->getGames($userID);
echo json_encode($gamesData);
?>