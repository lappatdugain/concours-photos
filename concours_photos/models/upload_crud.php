<?php
//error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
//ini_set('display_errors', 1);

function upload_photo($c, $id_user, $nom_photo, $description) {
    try {
        $req = "INSERT INTO photo (id_user, nom_photo, description, date_depot) VALUES (:id_user, :nom_photo, :description, NOW())";
        $prep = $c->prepare($req);
        $prep->bindValue(':id_user', $id_user);
        $prep->bindValue(':nom_photo', $nom_photo);
        $prep->bindValue(':description', $description);
        $prep->execute();
        $prep->closeCursor();
        return true;
    } catch (PDOException $e) {
        return false;
    }
}

function has_user_uploaded($c, $id_user) {
    $req = "SELECT COUNT(*) FROM photo WHERE id_user = :id_user";
    $prep = $c->prepare($req);
    $prep->bindValue(':id_user', $id_user);
    $prep->execute();
    $count = $prep->fetchColumn();
    $prep->closeCursor();
    return $count > 0;
}

function get_photo_by_id($c, $id) {
    $req = "SELECT * FROM photo WHERE id = :id";
    $prep = $c->prepare($req);
    $prep->bindValue(':id', $id);
    $prep->execute();
    $result = $prep->fetch(PDO::FETCH_ASSOC);
    $prep->closeCursor();
    return $result;
}

function get_photos_by_user($c, $id_user) {
    $req = "SELECT * FROM photo WHERE id_user = :id_user";
    $prep = $c->prepare($req);
    $prep->bindValue(':id_user', $id_user);
    $prep->execute();
    $result = $prep->fetchAll(PDO::FETCH_ASSOC);
    $prep->closeCursor();
    return $result;
}

function update_photo($c, $id, $nom_photo, $description) {
    try {
        $req = "UPDATE photo SET nom_photo = :nom_photo, description = :description WHERE id = :id";
        $prep = $c->prepare($req);
        $prep->bindValue(':id', $id);
        $prep->bindValue(':nom_photo', $nom_photo);
        $prep->bindValue(':description', $description);
        $prep->execute();
        $prep->closeCursor();
        return true;
    } catch (PDOException $e) {
        return false;
    }
}

function delete_photo($c, $id) {
    try {
        $req = "DELETE FROM photo WHERE id = :id";
        $prep = $c->prepare($req);
        $prep->bindValue(':id', $id);
        $prep->execute();
        $prep->closeCursor();
        return true;
    } catch (PDOException $e) {
        return false;
    }
}
?>