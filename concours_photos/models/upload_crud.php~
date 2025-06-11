<?php

class UploadCRUD {
    private $db;

    public function __construct() {
        $this->db = connection();
    }

    // Créer une nouvelle photo
    public function create($id_user, $nom_photo, $description) {
        try {
            $sql = "INSERT INTO photo (id_user, nom_photo, description, date_depot) 
                    VALUES (?, ?, ?, NOW())";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$id_user, $nom_photo, $description]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Vérifier si un utilisateur a déjà déposé une photo
    public function hasUserUploaded($id_user) {
        $sql = "SELECT COUNT(*) FROM photo WHERE id_user = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_user]);
        return $stmt->fetchColumn() > 0;
    }

    // Récupérer une photo par son ID
    public function getById($id) {
        $sql = "SELECT * FROM photo WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Récupérer toutes les photos d'un utilisateur
    public function getByUserId($id_user) {
        $sql = "SELECT * FROM photo WHERE id_user = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_user]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mettre à jour une photo
    public function update($id, $nom_photo, $description) {
        try {
            $sql = "UPDATE photo SET nom_photo = ?, description = ? WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$nom_photo, $description, $id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Supprimer une photo
    public function delete($id) {
        try {
            $sql = "DELETE FROM photo WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            return false;
        }
    }
} 