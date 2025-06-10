<?php

class UploadCRUD {
    private $db;

    public function __construct() {
        $this->db = connection();
    }

    // Créer une nouvelle photo
    public function create($id_utilisateur, $titre, $description, $fichier) {
        try {
            $sql = "INSERT INTO photos (id_utilisateur, titre, description, fichier, date_depot, est_visible) 
                    VALUES (?, ?, ?, ?, NOW(), 0)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$id_utilisateur, $titre, $description, $fichier]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Vérifier si un utilisateur a déjà déposé une photo
    public function hasUserUploaded($id_utilisateur) {
        $sql = "SELECT COUNT(*) FROM photos WHERE id_utilisateur = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_utilisateur]);
        return $stmt->fetchColumn() > 0;
    }

    // Récupérer une photo par son ID
    public function getById($id) {
        $sql = "SELECT * FROM photos WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Récupérer toutes les photos d'un utilisateur
    public function getByUserId($id_utilisateur) {
        $sql = "SELECT * FROM photos WHERE id_utilisateur = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_utilisateur]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Mettre à jour une photo
    public function update($id, $titre, $description) {
        try {
            $sql = "UPDATE photos SET titre = ?, description = ? WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$titre, $description, $id]);
        } catch (PDOException $e) {
            return false;
        }
    }

    // Supprimer une photo
    public function delete($id) {
        try {
            // Récupérer le nom du fichier avant de supprimer
            $photo = $this->getById($id);
            if ($photo) {
                $sql = "DELETE FROM photos WHERE id = ?";
                $stmt = $this->db->prepare($sql);
                if ($stmt->execute([$id])) {
                    // Supprimer le fichier physique
                    $file_path = "uploads/photos/" . $photo['fichier'];
                    if (file_exists($file_path)) {
                        unlink($file_path);
                    }
                    return true;
                }
            }
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }
} 