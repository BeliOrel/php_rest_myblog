<?php
    class Category {
      // DB Stuff
      private $conn;
      private $table = 'categories';

      // properties
      public $id;
      public $name;
      public $created_at;

      // Constructor with DB
      public function __construct($db){
        $this->conn = $db;
      }

      // Get categories
      public function read(){
        // create query
        $query = 'SELECT id, name, created_at FROM '.$this->table.' ORDER BY created_at DESC';

        // prepare statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
      }

      // Get single category
      public function read_single(){
        // create query
        $query = 'SELECT id, name, created_at FROM '.$this->table.' WHERE id = :id LIMIT 0,1';

        // prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind ID
        $stmt->bindParam(':id', $this->id);

        // execute query
        $stmt->execute();

        // Fetch query
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set properties
        $this->name = $row['name'];
      }
    }
?>
