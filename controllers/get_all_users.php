<?php
header('Content-Type: application/json');

require_once(__DIR__ . '/../model/userModel.php'); 

try {
    $model = new User();
    $user = $model->getUsers();

    if ($user === false || $user === null) {
        throw new Exception("Impossible de récupérer les utilisateurs.");
    }
    // Succès
    http_response_code(200);
    echo json_encode($user);
} catch (Exception $e) {
    
    http_response_code(500); 
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage(),
    ]);
}



?>