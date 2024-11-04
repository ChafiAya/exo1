<?php

include_once './Edition.php';
include_once './EditionDao.php';

// Function to test adding an edition
function testAjouterEdition() {
    $editionDao = new EditionDao();
    $edition = new Edition();
    $edition->setId(1); 
    $edition->setNom("Edition1");
    $result = $editionDao->ajouterEdition($edition);
    echo "Add Edition: " . $result . "\n";

    $edition2 = new Edition();
    $edition2->setId(2); 
    $edition2->setNom("Edition2");
    $result2 = $editionDao->ajouterEdition($edition2);
    echo "Add Edition2: " . $result2 . "\n";

}

// Function to test listing editions
function testListerEditions() {
    $editionDao = new EditionDao();
    $result = $editionDao->listerEditions();

    if (is_array($result)) {
        echo "List Editions:\n";
        foreach ($result as $edition) {
            echo "ID: " . $edition->getId() . ", Name: " . $edition->getNom() . "\n";
        }
    } else {
        echo "List Editions: " . $result . "\n";
    }
}

// Function to test retrieving an edition
function testRecupererEdition() {
    $editionDao = new EditionDao();
    $result = $editionDao->recupererEdition(1, 'id'); 

    if ($result) {
        echo "Retrieve Edition: ID: " . $result->getId() . ", Name: " . $result->getNom() . "\n";
    } else {
        echo "Retrieve Edition: No edition found.\n";
    }
}

// Function to test modifying an edition
function testModifierEdition() {
    $editionDao = new EditionDao();
    $edition = new Edition();
    $edition->setId(1); 
    $edition->setNom("Updated Edition Name");
    $result = $editionDao->modifierEdition($edition);
    echo "Update Edition: " . $result . "\n";
}

// Function to test deleting an edition
function testSupprimerEdition() {
    $editionDao = new EditionDao();
    $result = $editionDao->supprimerEdition(1, 'id'); 
    echo "Delete Edition: " . $result . "\n";
}


//testAjouterEdition();
//testListerEditions();
//testRecupererEdition();
//testModifierEdition();
//testListerEditions(); 
//testSupprimerEdition();
//testListerEditions(); 

?>
