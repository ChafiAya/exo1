DROP TABLE IF EXISTS Editions;
DROP TABLE IF EXISTS Collections;

CREATE TABLE Editions (
    Id INT PRIMARY KEY,
    Nom VARCHAR(255) NOT NULL
);


CREATE TABLE Collections (
    Idcollection INT AUTO_INCREMENT,  
    Nomcollection VARCHAR(50),
    PRIMARY KEY (Idcollection)
);

CREATE TABLE Auteur (
    idauteur INT PRIMARY KEY,
    nomauteur VARCHAR(255) NOT NULL,
    nationalite VARCHAR(255) NOT NULL,
    pays VARCHAR(255) NOT NULL,
    nbrlivre INT NOT NULL,
    profession VARCHAR(255) NOT NULL
);

create table Livre (
    idlivre int PRIMARY KEY AUTO_INCREMENT,
    isbn varchar(255) not null ,
    titre  varchar(255) not null ,
    quantitéStock int not null ,
    nbrlivremprunté  int not null ,
);

create table emprunteur (
    idemprunteur int PRIMARY KEY ,
    isbn varchar(255) not null , 
    adresseuniversité varchar(255) not null , 
    dateemprunt Date ,
    dateretourprévue Date ,
    profession varchar(255) not null
)
