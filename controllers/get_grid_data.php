<?php 
header('content-type: application/json');
require_once(__DIR__ . '/../model/gridModel.php');
session_start();

$data = json_decode(file_get_contents('php://input'), true);

if(!$data || !isset($data['id'])){
    echo json_encode(['error' => 'Invalid input data']);
    exit;
}

$gridId = $data['id'];
$gridModel = new GridModel();
$gridData = $gridModel->getGridData($gridId);
$_SESSION['gridData'] = json_encode($gridData);
if(!$gridData){
    echo json_encode(['error' => 'Failed to retrieve grid data']);
    exit;
}
echo json_encode(['success' => true, 'data' => $gridData]);