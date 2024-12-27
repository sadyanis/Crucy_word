<?php
header('content-type: application/json');
require_once(__DIR__ . '/../model/gridModel.php');
session_start();
$userID = $_SESSION["user"];
$model = new GridModel();
$grids = $model->getAllGridNames();
foreach ($grids as &$grid) {
    $grid['isOwner'] = ($grid['userID'] === $userID); 
}
echo json_encode($grids);
?>