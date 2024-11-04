<?php
// Include the Connexion class
include './Connexion.php'; // Make sure the path is correct

// Create a new instance of Connexion
$connexion = new Connexion();

// Get the connection
$dbConnection = $connexion->getConn();

// Optional: Test the connection
try {
    $stmt = $dbConnection->query("SELECT 1"); // Execute a simple query
    $result = $stmt->fetch(); // Fetch the result
    echo "Connection successful! Result: " . $result[0]; // Display result
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage()); // Handle query errors
}
?>
