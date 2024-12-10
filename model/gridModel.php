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
    public function getGrids($userID){
        try{
            $sql = "SELECT * FROM grid WHERE userID = :userID";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':userID'=> $userID,
            ]);
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
}



?>