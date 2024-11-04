<?php
include_once './Edition.php';
include_once './Connexion.php';

class EditionDao {

    public function ajouterEdition($Edition) {
        $conn = new Connexion();
        try {
            $sth = $conn->getConn()->prepare("INSERT INTO Editions (Id, Nom) VALUES (:Id, :Nom)");
            $sth->execute(array (
                'Id' => $Edition->getId(),
                'Nom' => $Edition->getNom(),
            ));
            return 'Record added successfully.';
        } catch (PDOException $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    public function listerEditions() {
        $conn = new Connexion();
        try {
            $sth = $conn->getConn()->prepare("SELECT * FROM Editions");
            $sth->execute();
            $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
            $tab = array();
            foreach ($rows as $row) {
                $Edition = new Edition();
                $Edition->setId($row['Id']);
                $Edition->setNom($row['Nom']);
                array_push($tab, $Edition);
            }

            return $tab;
        } catch (PDOException $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    public function recupererEdition($value, $property) {
        $conn = new Connexion();
        try {
            $sql = "SELECT * FROM Editions WHERE $property = :value";
            $stmt = $conn->getConn()->prepare($sql);
            $stmt->execute([':value' => $value]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($data) {
                $edition = new Edition();
                $edition->setId($data['Id']);
                $edition->setNom($data['Nom']);
                return $edition;
            }
            return null;
        } catch (PDOException $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

  
    public function modifierEdition($edition) {
        $conn = new Connexion();
        try {
            $sth = $conn->getConn()->prepare("UPDATE Editions SET Nom = :Nom WHERE Id = :uniqueValue");
            $sth->execute(array (
                ':Nom' => $edition->getNom(),  // Use getNom() to retrieve the name
                ':uniqueValue' => $edition->getId() // Use getId() to retrieve the unique ID
            ));
            return 'Record updated successfully.';
        } catch (PDOException $e) {
            return 'Error: ' . $e->getMessage();
        }
    }
    

    public function supprimerEdition($value, $property) {
        $conn = new Connexion();
        try {
            $sql = "DELETE FROM Editions WHERE $property = :value";
            $stmt = $conn->getConn()->prepare($sql);
            $stmt->execute([':value' => $value]);
            return 'Record deleted successfully.';
        } catch (PDOException $e) {
            return 'Error: ' . $e->getMessage();
        }
    }
}
