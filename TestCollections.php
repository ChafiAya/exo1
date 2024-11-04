<?php

include_once './Collections.php';
include_once './CollectionsDao.php';

// Function to test adding an edition
function Ajouter() {
    $Dao = new CollectionsDao ();
    $a = new  Collections ();
    $a->setNomcollection("Collection1");
    $result = $Dao->ajouterCollections($a);
    echo "Add collection: " . $result . "\n";

    $a2 = new Collections ();
    $a2->setNomcollection("Collection2");
    $result2 = $Dao->ajouterCollections($a2);
    echo "Add collection2: " . $result2 . "\n";

}

// Function to test listing editions
function Lister() {
    $Dao = new CollectionsDao ();
    $result = $Dao->listerCollectionss();

    if (is_array($result)) {
        echo "List Collections:\n";
        foreach ($result as $collection) {
            echo "idcollection: " . $collection->getIdcollection() . ", Nomcollection: " . $collection->getNomcollection() . "\n";
        }
    } else {
        echo "List Collections: " . $result . "\n";
    }
}

// Function to test retrieving an edition
function Recuperer(){
    $Dao = new CollectionsDao ();
    $result = $Dao->recupererCollections(1, 'Idcollection'); 

    if ($result) {
        echo "Retrieve collection: idcollection: " . $result->getIdcollection() . ", Nomcollection: " . $result->getNomcollection(). "\n";
    } else {
        echo "Retrieve collection No collection found.\n";
    }
}

// Function to test modifying an edition
function Modifier() {
    $Dao = new CollectionsDao();
    $c = new Collections();
    $c->setIdcollection(2);
    $c->setNomcollection("Updated collection2");
    $result = $Dao->modifierCollections($c);
    echo "Update collection: " . $result . "\n";

}

// Function to test deleting an edition
function Supprimer() {
    $Dao = new CollectionsDao();
    $result = $Dao->supprimerCollections(1,'Idcollection'); 
    echo "Delete collection: " . $result . "\n";
}


//Ajouter();
//Lister();
//Recuperer();
//Modifier() 
//Lister();
//Supprimer()
//Lister();

?>
