<?php
require_once __DIR__ . '/../core/Database.php';

class GridModel{
    private $db;

    public function __construct(){
        $this->db = (new Database())->connect();
    }


    public function insertGrid($dimension,$UserID,$gridName){
        try{
            $sql ="INSERT INTO GRIDS (grid_dimension, `grid_date`, user_id, grid_name) VALUES(:grid_dimension, NOW() , :user_id, :grid_name )";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                
                ':grid_dimension'=> $dimension,
                ':user_id'=> $UserID,
                ':grid_name'=> $gridName,
            ]);
            return $this->db->lastInsertId();
        }catch(PDOException $e){
        die(" ". $e->getMessage());
        }
    }

    public function insertCases($gridId, $cases){
        try{
            $sql = "INSERT INTO CELLS (grid_id, cell_row, cell_column, cell_content) VALUES (:grid_id, :x, :y, :cell_content)";
            $stmt = $this->db->prepare($sql);
            foreach($cases as $case){
                $stmt->execute([
                    ':grid_id' => $gridId,
                    ':x' => $case['x'],
                    ':y' => $case['y'],
                    ':cell_content' => $case['contenu'] ?? null,
                ]);
            }
    }
    catch(PDOException $e){
        die(" ". $e->getMessage());
    }
}

    public function insertHints($gridID,$hints,$orientation){
        try{
            $sql = "INSERT INTO HINTS (hint_id, grid_id, hint_orientation, hint_content) VALUES (:hint_id, :grid_id, :hint_orientation, :hint_content)";
            $stmt = $this->db->prepare($sql);
             foreach($hints as $hint)  {
                $stmt->execute([
                    ':hint_id'=> $hint['id'],
                    ':grid_id'=> $gridID,
                    ':hint_orientation'=> $orientation,
                    ':hint_content'=> $hint['contenu'],
                ]);
             }
        } catch(PDOException $e){
            die(" ". $e->getMessage());
        }
    }

    // à vérifier
    public function getAllGridNames() {
        try {
            $sql = "SELECT grid_name, grid_id FROM GRIDS";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // 
        } catch (PDOException $e) {
            die("ERROR: " . $e->getMessage());
        }
    }
    

    // retourne toutes les grilles disponibles
    public function getAllGrids($userID){
        try{
            $sql = "SELECT grid_name FROM GRIDS ";
            $stmt = $this->db->prepare($sql);
            return $stmt->fetchAll();
        }catch(PDOException $e){
            die("ERROR".$e->getMessage());
        }
    }

     public function getGridFormData() {
        // Vérifier si les données du formulaire sont envoyées
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $gridName = filter_input(INPUT_POST, 'grid_name', FILTER_SANITIZE_STRING);
            $gridDimension = filter_input(INPUT_POST, 'grid_dimension', FILTER_VALIDATE_INT);
    
            // Retourner les données sous forme de tableau associatif
            return [
                'grid_name' => $gridName,
                'grid_dimension' => $gridDimension
            ];
        }
    
        // Retourner null si aucune donnée n'est envoyée
        return null;
    }

    public function getGridData($gridID) {
        try {
            // Récupérer les cases
            $sqlCases = "SELECT c.cell_row, c.cell_column, c.cell_content 
                         FROM CELLS c
                         WHERE c.grid_id = :grid_id";
            $stmtCases = $this->db->prepare($sqlCases);
            $stmtCases->execute([':grid_id' => $gridID]);
            $cases = $stmtCases->fetchAll(PDO::FETCH_ASSOC);
    
            // Récupérer les indices
            $sqlHints = "SELECT h.hint_orientation, h.hint_content 
                         FROM HINTS h
                         WHERE h.grid_id = :grid_id";
            $stmtHints = $this->db->prepare($sqlHints);
            $stmtHints->execute([':grid_id' => $gridID]);
            $hints = $stmtHints->fetchAll(PDO::FETCH_ASSOC);

            // Recuperer la dimension de la grille
            $sqlDimension = "SELECT grid_dimension FROM GRIDS WHERE grid_id = :grid_id";
            $stmtDimension = $this->db->prepare($sqlDimension);
            $stmtDimension->execute([':grid_id' => $gridID]);
            $dimension = $stmtDimension->fetch(PDO::FETCH_ASSOC);
    
            return [
                'grid_dimension' => $dimension,
                'CELLS' => $cases,
                'HINTS' => $hints,
            ];
        } catch (PDOException $e) {
            die("ERROR: " . $e->getMessage());
        }
    }
    
}



?>