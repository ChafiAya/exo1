<?php
include_once './BaseRepository.php';

class EditionRepository extends BaseRepository {
    public function __construct() {
        parent::__construct('Editions'); // table
    }
}

$editionRepo = new EditionRepository();

// Test adding editions
$editionRepo->ajouter(['id_edition' => 1, 'nom' => 'Edition 1']);
$editionRepo->ajouter(['id_edition' => 2, 'nom' => 'Edition 2']);


// Test retrieving an edition
$edition = $editionRepo->recuperer('id_edition', 1);
echo "ID: " . $edition['id_edition'] . ", Name: " . $edition['nom'] . "\n";

// Test updating an edition
$editionRepo->modifier('id_edition', 1, ['nom' => 'Updated Edition 1']);



// Test deleting an edition
$editionRepo->supprimer('id_edition', 2);


// Test the lister method
$editions = $editionRepo->lister(); // Call to lister() method
foreach ($editions as $edition) {
    echo "ID: " . $edition['id_edition'] . ", Name: " . $edition['nom'] . "\n"; // Output the ID and name
}




?>
