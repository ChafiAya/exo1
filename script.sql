DROP TABLE IF EXISTS Editions;
DROP TABLE IF EXISTS Collections;

CREATE TABLE Editions (
    Id INT PRIMARY KEY,
    Nom VARCHAR(255) NOT NULL
);


CREATE TABLE Collections (
    id_collection INT AUTO_INCREMENT,  
    nom VARCHAR(50),
    PRIMARY KEY (id_collection)
);
