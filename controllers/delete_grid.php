<?php
header('content-type: application/json');
require_once(__DIR__ . '/../model/gridModel.php');

$model = new GridModel();

try {
    // Récupérer les données JSON
    $data = json_decode(file_get_contents('php://input'), true);
    $gridID = $data['id'];
    $succes =  $model->deleteGrid($gridID);
    if($succes){
        echo json_encode(['success' => true , 'message' => 'Grid deleted successfully']);
    }else{
        echo json_encode(['success' => false , 'message' => 'Failed to delete grid']);
    }
} catch (Exception $e) {
    die("ERROR: " . $e->getMessage());
}



?>