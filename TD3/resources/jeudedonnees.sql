DROP TABLE IF EXISTS trajet;
DROP TABLE IF EXISTS utilisateur;

CREATE TABLE utilisateur (
    login VARCHAR(64) PRIMARY KEY,
    nom VARCHAR(64) NOT NULL,
    prenom VARCHAR(64) NOT NULL
);

CREATE TABLE trajet (
    id INT AUTO_INCREMENT,
    depart VARCHAR(64) NOT NULL,
    arrivee VARCHAR(64) NOT NULL,
    date DATE NOT NULL,
    prix INT NOT NULL,
    conducteurLogin VARCHAR(64) NOT NULL,
    nonFumeur BOOLEAN NOT NULL,
    CONSTRAINT trajet_pk PRIMARY KEY (id),
    CONSTRAINT trajet_conducteur_fk FOREIGN KEY (conducteurLogin) REFERENCES utilisateur(login) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT trajet_prixNonNegatif CHECK (prix >= 0)
);

INSERT INTO utilisateur VALUES ('dupontp', 'Dupont', 'Pierre');
INSERT INTO utilisateur VALUES ('bigardj', 'Bigard', 'Jean-Marie');
INSERT INTO utilisateur VALUES ('nielx', 'Niel', 'Xavier');

INSERT INTO trajet (depart, arrivee, date, prix, conducteurLogin, nonFumeur)
VALUES ('Narbonne', 'Montpellier', '2024-08-01', 10, 'dupontp', true);
INSERT INTO trajet (depart, arrivee, date, prix, conducteurLogin, nonFumeur)
VALUES ('Paris', 'Toulouse', '2024-08-12', 450, 'bigardj', false);
INSERT INTO trajet (depart, arrivee, date, prix, conducteurLogin, nonFumeur)
VALUES ('Lille', 'Rennes', '2024-08-09', 80, 'nielx', true);