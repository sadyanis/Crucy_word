<?php
header('Content-Type: application/json');
require_once(__DIR__."/../model/gridModel.php");

try {
    // Connexion à la base de données
    $pdo = (new Database())->connect();

    // Récupérer les données JSON
    $data = json_decode(file_get_contents('php://input'), true);
    $grille_id = $data['grille_id'];
    $cases = $data['cases'];

    // Préparer l'insertion
    $sql = "INSERT INTO cases (gridID, `row`, `line`, contenu) VALUES (:grille_id, :y,:x, :contenu)";
    $stmt = $pdo->prepare($sql);

    foreach ($cases as $case) {
        //$type = empty($case['contenu']) ? 'vide' : 'lettre';
        $stmt->execute([
            ':grille_id' => $grille_id,
            ':x' => $case['x'],
            ':y' => $case['y'],
            //':type' => $type,
            ':contenu' => $case['contenu']
        ]);
    }

    // Réponse JSON de succès
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    // Réponse JSON en cas d'erreur
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
