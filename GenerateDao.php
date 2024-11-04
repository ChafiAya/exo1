<?php

function generateDaoClass($classFile, $tableName = null, $customProperties = [], $customGetters = [], $customSetters = []) {
    // Check if the file exists
    if (!file_exists($classFile)) {
        throw new Exception("Class file does not exist: " . $classFile);
    }

    // Get the class name from the file
    $className = basename($classFile, '.php');
    include_once $classFile;

    // Use the provided table name or default to the class name
    if ($tableName === null) {
        $tableName = strtolower($className); // Default table name
    }

    // Start building the DAO class
    $daoClass = "<?php\n";
    $daoClass .= "include './{$className}.php';\n";
    $daoClass .= "include_once './Connexion.php';\n\n";
    
    $daoClass .= "class {$className}Dao {\n\n";
    
    // Method to add a new record
    $daoClass .= "    public function ajouter{$className}(\${$className}) {\n";
    $daoClass .= "        \$conn = new Connexion();\n";
    $daoClass .= "        try {\n";
    $daoClass .= "            \$sth = \$conn->getConn()->prepare(\"INSERT INTO $tableName (";
    
    // Use original property names for SQL columns
    $daoClass .= implode(", ", $customProperties) . ") VALUES (" . implode(", ", array_map(function($col) {
        return ":$col";
    }, $customProperties)) . ")\");\n";
    
    $daoClass .= "            \$sth->execute(array (\n";
    foreach ($customGetters as $getter) {
        $columnName = ucfirst(substr($getter, 3)); // Correctly capitalize the first letter
        $daoClass .= "                '$columnName' => \${$className}->{$getter}(),\n"; // Use original casing
    }
    $daoClass .= "            ));\n";
    $daoClass .= "            return 'Record added successfully.';\n"; // Success message
    $daoClass .= "        } catch (PDOException \$e) {\n";
    $daoClass .= "            return 'Error: ' . \$e->getMessage();\n"; // Error handling
    $daoClass .= "        }\n";
    $daoClass .= "    }\n\n";
    
    // Method to list all records
    $daoClass .= "    public function lister{$className}s() {\n";
    $daoClass .= "        \$conn = new Connexion();\n";
    $daoClass .= "        try {\n";
    $daoClass .= "            \$sth = \$conn->getConn()->prepare(\"SELECT * FROM $tableName\");\n";
    $daoClass .= "            \$sth->execute();\n";
    $daoClass .= "            \$rows = \$sth->fetchAll(PDO::FETCH_ASSOC);\n";
    $daoClass .= "            \$tab = array();\n";
    
    $daoClass .= "            foreach (\$rows as \$row) {\n";
    $daoClass .= "                \${$className} = new {$className}();\n";
    
    foreach ($customSetters as $setter) {
        $columnName = ucfirst(substr($setter, 3)); // Correctly capitalize the first letter
        $daoClass .= "                \${$className}->{$setter}(\$row['$columnName']);\n"; // Use original casing
    }

    $daoClass .= "                array_push(\$tab, \${$className});\n";
    $daoClass .= "            }\n\n";
    
    $daoClass .= "            return \$tab;\n";
    $daoClass .= "        } catch (PDOException \$e) {\n";
    $daoClass .= "            return 'Error: ' . \$e->getMessage();\n"; // Error handling
    $daoClass .= "        }\n";
    $daoClass .= "    }\n\n";
    
    // Method to retrieve a record by a unique property (not necessarily ID)
    $daoClass .= "    public function recuperer{$className}(\$value, \$property) {\n";
    $daoClass .= "        \$conn = new Connexion();\n";
    $daoClass .= "        try {\n";
    $daoClass .= "            \$sql = \"SELECT * FROM $tableName WHERE \$property = :value\";\n";
    $daoClass .= "            \$stmt = \$conn->getConn()->prepare(\$sql);\n";
    $daoClass .= "            \$stmt->execute([':value' => \$value]);\n";
    $daoClass .= "            \$data = \$stmt->fetch(PDO::FETCH_ASSOC);\n\n";
    
    $daoClass .= "            if (\$data) {\n";
    $daoClass .= "                \$edition = new {$className}();\n";
    foreach ($customSetters as $setter) {
        $columnName = ucfirst(substr($setter, 3)); // Correctly capitalize the first letter
        $daoClass .= "                \$edition->{$setter}(\$data['$columnName']);\n"; // Use original casing
    }
    $daoClass .= "                return \$edition;\n";
    $daoClass .= "            }\n";
    $daoClass .= "            return null;\n";
    $daoClass .= "        } catch (PDOException \$e) {\n";
    $daoClass .= "            return 'Error: ' . \$e->getMessage();\n"; // Error handling
    $daoClass .= "        }\n";
    $daoClass .= "    }\n\n";
    
    // Method to update a record
    $daoClass .= "    public function modifier{$className}(\$edition) {\n";
    $daoClass .= "        \$conn = new Connexion();\n";
    $daoClass .= "        try {\n";
    $daoClass .= "            \$sth = \$conn->getConn()->prepare(\"UPDATE $tableName SET ";
    
    // Add column updates based on custom setters
    $setClauses = array_map(function($setter) {
        return ucfirst(substr($setter, 3)) . " = :" . ucfirst(substr($setter, 3)); // Correctly capitalize the first letter
    }, $customSetters);
    
    $daoClass .= implode(", ", $setClauses) . " WHERE " . ucfirst(substr($customSetters[0], 3)) . " = :uniqueValue\");\n";
    $daoClass .= "            \$sth->execute(array (\n";
    
    foreach ($customSetters as $setter) {
        $columnName = ucfirst(substr($setter, 3)); // Correctly capitalize the first letter
        $daoClass .= "                ':$columnName' => \$edition->{$setter}(),\n"; // Using custom getters
    }
    $daoClass .= "                ':uniqueValue' => \$edition->{$customGetters[0]}()\n"; 
    $daoClass .= "            ));\n";
    $daoClass .= "            return 'Record updated successfully.';\n"; // Success message
    $daoClass .= "        } catch (PDOException \$e) {\n";
    $daoClass .= "            return 'Error: ' . \$e->getMessage();\n"; // Error handling
    $daoClass .= "        }\n";
    $daoClass .= "    }\n\n";
    
    // Method to delete a record
    $daoClass .= "    public function supprimer{$className}(\$value, \$property) {\n";
    $daoClass .= "        \$conn = new Connexion();\n";
    $daoClass .= "        try {\n";
    $daoClass .= "            \$sql = \"DELETE FROM $tableName WHERE \$property = :value\";\n";
    $daoClass .= "            \$stmt = \$conn->getConn()->prepare(\$sql);\n";
    $daoClass .= "            \$stmt->execute([':value' => \$value]);\n";
    $daoClass .= "            return 'Record deleted successfully.';\n"; // Success message
    $daoClass .= "        } catch (PDOException \$e) {\n";
    $daoClass .= "            return 'Error: ' . \$e->getMessage();\n"; // Error handling
    $daoClass .= "        }\n";
    $daoClass .= "    }\n";
    
    $daoClass .= "}\n";
    
    // Return the generated class code
    return $daoClass;
}


$classFile = 'Collections.php'; 


$customProperties = ['Idcollection', 'Nomcollection'];  
$customGetters = ['getIdcollection', 'getNomcollection'];
$customSetters = ['setIdcollection', 'setNomcollection'];  

try {
    $daoClassCode = generateDaoClass($classFile, 'Collections', $customProperties, $customGetters, $customSetters);
    file_put_contents('./' . basename($classFile, '.php') . 'Dao.php', $daoClassCode);
    echo "DAO class for " . basename($classFile, '.php') . " has been generated and saved as " . basename($classFile, '.php') . "Dao.php.\n";
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
