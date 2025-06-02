CREATE TABLE user (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    admin BOOLEAN DEFAULT false
);

CREATE TABLE concours (
    id INT PRIMARY KEY AUTO_INCREMENT,
    regles TEXT NOT NULL,
    date_debut_depot DATE NOT NULL,
    date_fin_depot DATE NOT NULL,
    date_debut_vote1 DATE NOT NULL,
    date_fin_vote1 DATE NOT NULL,
    date_debut_vote2 DATE NOT NULL,
    date_fin_vote2 DATE NOT NULL,
    theme VARCHAR(30)
);

CREATE TABLE photo (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nom_photo VARCHAR(100) NOT NULL,
    id_utilisateur INT NOT NULL,
    description VARCHAR(300),
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id)
);

CREATE TABLE vote (
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_photo INT NOT NULL,
    id_utilisateur INT NOT NULL,
    tour INT NOT NULL,
    FOREIGN KEY (id_photo) REFERENCES photo(id),
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id)
);
