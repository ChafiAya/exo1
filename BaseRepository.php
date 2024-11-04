<?php
include_once './Connexion.php';

class BaseRepository {
    protected $conn;
    protected $table;

    public function __construct($table) {
        $this->conn = (new Connexion())->getConn();
        $this->table = $table;
    }

    // Add a new record with any number of columns
    public function ajouter($data) {
        try {
            $columns = implode(", ", array_keys($data)); // Create a string of columns
            $placeholders = ":" . implode(", :", array_keys($data)); // Create placeholders

            $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
            $sth = $this->conn->prepare($sql);
            $sth->execute($data); // Execute with the actual data
            echo "Record added successfully.\n";
        } catch (PDOException $e) {
            echo "Error adding record: " . $e->getMessage() . "\n";
        }
    }

    // List all records
    public function lister() {
        try {
            $sql = "SELECT * FROM {$this->table}";
            $sth = $this->conn->prepare($sql);
            $sth->execute();
            return $sth->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error listing records: " . $e->getMessage() . "\n";
            return []; // Return an empty array in case of an error
        }
    }

    // Retrieve a record by any attribute
    public function recuperer($column, $value) {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE $column = :value";
            $sth = $this->conn->prepare($sql);
            $sth->execute([':value' => $value]);
            return $sth->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error retrieving record: " . $e->getMessage() . "\n";
            return null; // Return null in case of an error
        }
    }

    // Update a record by any attribute
    public function modifier($column, $value, $data) {
        try {
            $setClause = implode(", ", array_map(fn($col) => "$col = :$col", array_keys($data)));

            $data['value'] = $value;
            $sql = "UPDATE {$this->table} SET $setClause WHERE $column = :value";
            $sth = $this->conn->prepare($sql);
            $sth->execute($data);
            echo "Record updated successfully.\n";
        } catch (PDOException $e) {
            echo "Error updating record: " . $e->getMessage() . "\n";
        }
    }

    // Delete a record by any attribute
    public function supprimer($column, $value) {
        try {
            $sql = "DELETE FROM {$this->table} WHERE $column = :value";
            $sth = $this->conn->prepare($sql);
            $sth->execute([':value' => $value]);
            echo "Record deleted successfully.\n";
        } catch (PDOException $e) {
            echo "Error deleting record: " . $e->getMessage() . "\n";
        }
    }
}
?>
