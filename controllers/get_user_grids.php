<?php
header('content-type: application/json');
require_once(__DIR__ . '/../model/gridModel.php');
session_start();
$userID = $_SESSION["user"];
$model = new GridModel();
$userGrids = $model->getUserGrids($userID);
foreach($userGrids as &$grid){
    $grid['isOwner'] = true;
}
echo json_encode($userGrids);

?>