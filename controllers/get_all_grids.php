<?php
header('content-type: application/json');
require_once(__DIR__ . '/../model/gridModel.php');

$data = json_decode(file_get_contents('php://input'), true);
$filter = $data['filter'] ;
$model = new GridModel();
if($filter === true){
$grids = $model->getAllGridsByLevel();
}else{
$grids = $model->getAllGridNames();
}

echo json_encode($grids);
?>