<?php
session_start();
header('Content-Type: application/json');

require_once(__DIR__ . '/../model/gridModel.php');

// Récupération des données d'entrée
$data = json_decode(file_get_contents('php://input'), true);

// Vérification des données d'entrée
if (!$data || !isset($data['id'])) {
    echo json_encode(['error' => 'Invalid input data']);
    exit;
}

$gridId = $data['id'];

// Initialisation du modèle
$gridModel = new GridModel();


// Vérification si une partie sauvegardée est demandée
if (isset($data['game'])) {
    $gameData = $gridModel->getGameData($gridId, $_SESSION['user'] ?? null);

    if (!$gameData) {
        echo json_encode(['error' => 'Failed to retrieve game data']);
        exit;
    }

    // Stockage des données dans la session
    $gridData = $gridModel->getGridData($gridId);
    $_SESSION['gridData'] = $gridData;
    $_SESSION['gameData'] = $gameData;
    $_SESSION['gridID'] = $gridId;
    // Réponse avec les données de la partie
    echo json_encode(['success' => true, 'data' => $gameData]);
    exit;
}

// Récupération des données de la grille
$gridData = $gridModel->getGridData($gridId);
    $_SESSION['gridData'] = $gridData;
    $_SESSION['gridID'] = $gridId;
if (!$gridData) {
    echo json_encode(['error' => 'Failed to retrieve grid data']);
    exit;
}

// Stockage des données dans la session


// Réponse avec les données de la grille
echo json_encode(['success' => true, 'data' => $gridData]);
