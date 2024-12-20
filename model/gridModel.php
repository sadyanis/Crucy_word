<?php
require_once __DIR__ . '/../core/Database.php';

class GridModel{
    private $db;

    public function __construct(){
        $this->db = (new Database())->connect();
    }
    public function addGrid($gridID,$dimension,$date,$UserID,$gridName){
        try{
            $sql ="INSERT INTO grid VALUES(:gridID, :dimension, :date , :userID, :gridName )";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':gridID'=> $gridID,
                ':dimension'=> $dimension,
                ':date'=> $date,
                ':userID'=> $UserID,
                ':gridName'=> $gridName,
            ]);
            return true;
        }catch(PDOException $e){
        die(" ". $e->getMessage());
        }
    }
    // à vérifier
    public function getAllGridNames() {
        try {
            $sql = "SELECT gridName FROM grid";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_COLUMN); // Récupère uniquement la colonne `gridName`
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

    public function addCase($caseID, $gridID,$row,$line,$contenu){
        try{
            $sql ="INSERT INTO cases VALUES(:caseID, :gridID, :row , :line, :contenu )";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':caseID'=> $caseID,
                ':gridID'=> $gridID,
                ':row '=> $row,
                ':line'=> $line,
                ':contenu'=> $contenu,
            ]);
            return true;
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
}



?>