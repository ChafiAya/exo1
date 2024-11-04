<?php
// Database connection constants
define('DB_HOST', '127.0.0.1'); // Use 127.0.0.1
define('DB_NAME', 'review1'); // Database name
define('DB_PORT', '3306'); // MySQL port
define('DB_USER', 'root'); // Database username
define('DB_PSWD', ''); // Database password (leave empty if using XAMPP default)

class Connexion {
    private $conn;

    // Function to get the database connection
    public function getConn() {
        // Check if the connection is already established
        if ($this->conn == null) {
            try {
                // Define the connection string
                $connString = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT . ";charset=utf8";
                
                // Create a new PDO instance
                $this->conn = new PDO($connString, DB_USER, DB_PSWD);
                
                // Set the PDO error mode to exception
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
        }
        // Return the established connection
        return $this->conn;
    }
}
?>
