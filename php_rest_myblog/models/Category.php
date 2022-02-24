<?php
    class Category {
        // DB Stuff
        private $conn;
        private $table = 'categories';

        // Properties
        public $id;
        public $name;
        public $created_at;

        // Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }

        // Get Categories
        function read() {
            $query = 'SELECT 
                id, name, created_at
                FROM ' . $this->table . '
                ORDER BY id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Execute statement
            $stmt->execute();

            return $stmt;
        }

        function read_single() {
            $query = 'SELECT id, name, created_at
                FROM ' . $this->table . '
                WHERE id = :id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Bind ID
            $stmt->bindParam(':id', $this->id);

            // Execute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Set properties
            $this->name = $row['name'];
            $this->created_at = $row['created_at'];
        }

        // Create Category
        function create() {
            // Create query
            $query = 'INSERT INTO ' . $this->table . '
                SET name = :name';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->name = htmlspecialchars(strip_tags($this->name));

            // Bind data
            $stmt->bindParam(':name', $this->name);

            // Execute query
            if ($stmt->execute()) {
                return true;
            }

            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);
            return false;
        }

        // Update Category
        function update() {
            $query = 'UPDATE ' . $this->table . '
                SET name = :name
                WHERE id = :id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Bind data
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':id', $this->id);

            // Execute query
            if ($stmt->execute()) {
                return true;
            }

            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);
            return false;
        }

        function delete() {
            // Create query
            $query = 'DELETE FROM '. $this->table . '
            WHERE id = :id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Bind data
            $stmt->bindParam(':id', $this->id);

            // Execute query
            if ($stmt->execute()) {
                return true;
            }

            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }
?>