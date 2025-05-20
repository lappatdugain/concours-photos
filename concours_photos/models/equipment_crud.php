<?php

/**
 * equipment CRUD find all equipment by family name
 * return id, name, nb = number of solutions for this equipement
 * @param PDO $connex
 * @param int $id
 * @return array
 */
function find_equipments_by_family_id(PDO $connex, int $id):array {
    $req = "SELECT e.id, e.name, COUNT(s.id) AS nb FROM equipment e
    LEFT JOIN solution s ON e.id = s.id_equ
    WHERE e.id_fam = :id
    GROUP BY e.id, e.name";
    
    $prep = $connex->prepare($req);
    $prep->bindValue(':id', $id);
    $prep->execute();
    $equipments = $prep->fetchAll(PDO::FETCH_ASSOC);
    $prep->closeCursor();
    return $equipments;
}


/**
 * @param PDO $connex
 * @param int $id
 * @return array
 */
function find_equipment(PDO $connex, int $id):array {
    $req = "SELECT id, name FROM equipment WHERE id = :id";
    
    $prep = $connex->prepare($req);
    $prep->bindValue(':id', $id);
    $prep->execute();
    $equipment = $prep->fetch(PDO::FETCH_ASSOC);
    $prep->closeCursor();
    return $equipment;
}

function create_equipment(PDO $connex, string $name, int $fam) {
    
    $req = "INSERT INTO equipment (name, id_fam) VALUES (:name, :id_fam)";
    $prep = $connex->prepare($req);
    
    $prep->bindValue(':name', $name);
    $prep->bindValue(':id_fam', $fam);
    
    $prep->execute();
    
}

