<?php

/**
 * family CRUD find all family items
 * @param PDO $connex
 * @return array
 */
function find_all_families(PDO $connex) {
    $req="SELECT id, name FROM family ORDER BY name";
    $res = $connex->query($req);
    $families = $res->fetchAll(PDO::FETCH_ASSOC);
    $res->closeCursor();
    return $families;
}
