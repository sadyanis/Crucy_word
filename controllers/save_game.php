<?php
session_start();
header('Content-Type: application/json');
require_once(__DIR__ . "/../model/gridModel.php");

try {
    // Récupérer les données JSON
    $data = json_decode(file_get_contents('php://input'), true);

    // Vérifier si les données sont valides
    if (!$data || !isset($data['cases'])) {
        throw new Exception('Invalid input data');
    }

    $userID = $_SESSION['user'] ?? null;
    $gridId = $_SESSION['gridID'] ?? null;
    if (!$userID) {
        throw new Exception('User not authenticated');
    }

    $cases = $data['cases'];


    $gridModel = new GridModel();


    // inserer les cases
    $gridModel->insertGame($userID,$gridId,$cases);

    // Réponse JSON de succès
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    // Réponse JSON en cas d'erreur
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>