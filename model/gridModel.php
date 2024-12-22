<?php
require_once __DIR__ . '/../core/Database.php';

class GridModel{
    private $db;

    public function __construct(){
        $this->db = (new Database())->connect();
    }


    public function insertGrid($dimension,$UserID,$gridName){
        try{
            $sql ="INSERT INTO grid (dimension, `date`, userID, gridName) VALUES(:dimension, NOW() , :userID, :gridName )";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                
                ':dimension'=> $dimension,
                ':userID'=> $UserID,
                ':gridName'=> $gridName,
            ]);
            return $this->db->lastInsertId();
        }catch(PDOException $e){
        die(" ". $e->getMessage());
        }
    }

    public function insertCases($gridId, $cases){
        try{
            $sql = "INSERT INTO cases (gridID, `row`, `line`, contenu) VALUES (:gridID, :x, :y, :contenu)";
            $stmt = $this->db->prepare($sql);
            foreach($cases as $case){
                $stmt->execute([
                    ':gridID' => $gridId,
                    ':x' => $case['x'],
                    ':y' => $case['y'],
                    ':contenu' => $case['contenu'] ?? null,
                ]);
            }
    }
    catch(PDOException $e){
        die(" ". $e->getMessage());
    }
}

    public function insertHints($gridID,$hints,$orientation){
        try{
            $sql = "INSERT INTO HINTS (hint_id, grid_id, hint_orientation, hint_content) VALUES (:hint_id, :grille_id, :hint_orientation, :hint_content)";
            $stmt = $this->db->prepare($sql);
             foreach($hints as $hint)  {
                $stmt->execute([
                    ':hint_id'=> $hint['id'],
                    ':grille_id'=> $gridID,
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
            $sql = "SELECT gridName,gridID FROM grid";
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
            $sql = "SELECT gridName FROM grid ";
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

    public function getGridData($gridID){
        try{
            $sql = "SELECT DISTINCT g.dimension, c.row, c.line , c.contenu, h.hint_orientation, h.hint_content FROM grid g 
             left join cases c on g.gridID = c.gridID
             left join HINTS h on g.gridID = h.grid_id
             WHERE g.gridID = :gridID";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':gridID' => $gridID
            ]);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            die("ERROR".$e->getMessage());
        }
    }
}



?>