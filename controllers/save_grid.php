<?php
session_start();
header('Content-Type: application/json');
require_once(__DIR__ . "/../model/gridModel.php");

try {
    // Récupérer les données JSON
    $data = json_decode(file_get_contents('php://input'), true);

    // Vérifier si les données sont valides
    if (!$data || !isset($data['gridName'], $data['gridDimension'], $data['cases'], $data['horizontalHints'], $data['verticalHints'])) {
        throw new Exception('Invalid input data');
    }

    $userID = $_SESSION['user'] ?? null;
    if (!$userID) {
        throw new Exception('User not authenticated');
    }

    $grille_name = $data['gridName'];
    $cases = $data['cases'];
    $Dimension = $data['gridDimension'];
    $horizontalHints = $data['horizontalHints'];
    $verticalHints = $data['verticalHints'];

    // Connexion à la base de données
    $pdo = (new Database())->connect();

    // Insérer les informations de la grille
    $sql = "INSERT INTO grid (dimension, `date`, userID, gridName) VALUES (:dimension, NOW(), :userID, :gridName)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':dimension' => $Dimension,
        ':userID' => $userID,
        ':gridName' => $grille_name,
    ]);

    $grille_id = $pdo->lastInsertId();
    if (!$grille_id) {
        throw new Exception('Failed to insert grid');
    }

    // Insérer les cases
    $sql = "INSERT INTO cases (gridID, `row`, `line`, contenu) VALUES (:grille_id, :y, :x, :contenu)";
    $stmt = $pdo->prepare($sql);

    foreach ($cases as $case) {
        $stmt->execute([
            ':grille_id' => $grille_id,
            ':x' => $case['x'],
            ':y' => $case['y'],
            ':contenu' => $case['contenu'] ?? null,
        ]);
    }

    // Insérer les indices horizontaux
    $sql = "INSERT INTO HINTS (hint_id, grid_id, hint_orientation, hint_content) VALUES (:hint_id, :grille_id, :hint_orientation, :hint_content)";
    $stmt = $pdo->prepare($sql);

    foreach ($horizontalHints as $hint) {
        $stmt->execute([
            'hint_id' => $hint['id'],
            ':grille_id' => $grille_id,
            ':hint_orientation' => 'horizontal',
            ':hint_content' => $hint['contenu'],
        ]);
    }

    // Insérer les indices verticaux
    foreach ($verticalHints as $hint) {
        $stmt->execute([
            'hint_id' => $hint['id'],
            ':grille_id' => $grille_id,
            ':hint_orientation' => 'vertical',
            ':hint_content' => $hint['contenu'],
        ]);
    }

    // Réponse JSON de succès
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    // Réponse JSON en cas d'erreur
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>

