<?php

/**
 * family CRUD find all family items
 * @param PDO $connex
 * @return array
 */
function find_solutions_by_equipment_id(PDO $connex, $id) {
    $req="SELECT id, date, title, text FROM solution WHERE id_equ=:id_equ ORDER BY date DESC";
    $prep = $connex->prepare($req);
    $prep->bindValue(':id_equ', $id);
    $prep->execute();
    $solutions = $prep->fetchAll(PDO::FETCH_ASSOC);
    $prep->closeCursor();
    return $solutions;
}
