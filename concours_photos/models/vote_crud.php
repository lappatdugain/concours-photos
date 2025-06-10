<?php

/**
 * family CRUD find all family items
 * @param PDO $connex
 * @return array
 */

 function get_concours_dates(PDO $connex) {
    $req = "SELECT date_debut_depot, date_fin_depot, date_debut_vote1, date_fin_vote1, date_debut_vote2, date_fin_vote2  FROM concours;";
    $res = $connex->query($req);
    $dates = $res->fetchAll(PDO::FETCH_ASSOC);
    $res->closeCursor();
    return $dates;
}


function get_user_info(PDO $connex,$id){
    $req = "SELECT nom, prenom"
}

function add_vote( PDO $connex, $user_id, $photo_id, $tour) {
    $date=date('Y-m-d H:i:s')
    $con = connection();
    $req = "INSERT INTO vote (id_user, id_photo, tour, date_vote) VALUES (default, :user_id, :photo_id , :tour, :date )";
    
    $prep = $connex->prepare($req);
    $prep->bindValue(':id', $user_id);
    $prep->bindValue(':photo_id', $photo_id);
    $prep->bindValue(':tour', $tour);
    $prep->bindValue(':date', $date);
    $prep->execute();
    $res->closeCursor();
}

