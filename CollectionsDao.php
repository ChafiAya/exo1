<?php
include_once './Collections.php';
include_once './Connexion.php';

class CollectionsDao {

    public function ajouterCollections($Collections) {
        $conn = new Connexion();
        try {
            $sth = $conn->getConn()->prepare("INSERT INTO Collections (Nomcollection) VALUES (:Nomcollection)");
            $sth->execute(array (
               
                'Nomcollection' => $Collections->getNomcollection(),
            ));
            return 'Record added successfully.';
        } catch (PDOException $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    public function listerCollectionss() {
        $conn = new Connexion();
        try {
            $sth = $conn->getConn()->prepare("SELECT * FROM Collections");
            $sth->execute();
            $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
            $tab = array();
            foreach ($rows as $row) {
                $Collections = new Collections();
                $Collections->setIdcollection($row['Idcollection']);
                $Collections->setNomcollection($row['Nomcollection']);
                array_push($tab, $Collections);
            }

            return $tab;
        } catch (PDOException $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    public function recupererCollections($value, $property) {
        $conn = new Connexion();
        try {
            $sql = "SELECT * FROM Collections WHERE $property = :value";
            $stmt = $conn->getConn()->prepare($sql);
            $stmt->execute([':value' => $value]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($data) {
                $edition = new Collections();
                $edition->setIdcollection($data['Idcollection']);
                $edition->setNomcollection($data['Nomcollection']);
                return $edition;
            }
            return null;
        } catch (PDOException $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    public function modifierCollections($edition) {
        $conn = new Connexion();
        try {
          
            $sth = $conn->getConn()->prepare("UPDATE Collections SET Nomcollection = :Nomcollection WHERE Idcollection = :uniqueValue");
            $sth->execute(array (
                ':Nomcollection' => $edition->getNomcollection(),  
                ':uniqueValue' => $edition->getIdcollection() 
            ));
            return 'Record updated successfully.';
        } catch (PDOException $e) {
            return 'Error: ' . $e->getMessage();
        }
    }
    


    public function supprimerCollections($value, $property) {
        $conn = new Connexion();
        try {
            $sql = "DELETE FROM Collections WHERE $property = :value";
            $stmt = $conn->getConn()->prepare($sql);
            $stmt->execute([':value' => $value]);
            return 'Record deleted successfully.';
        } catch (PDOException $e) {
            return 'Error: ' . $e->getMessage();
        }
    }
}
