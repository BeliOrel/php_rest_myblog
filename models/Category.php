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

      // Create category
      public function create(){
        // create query
        $query = 'INSERT INTO '.$this->table.'
          SET
            name = :name';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data (sanitize data)
        $this->name = htmlspecialchars(strip_tags($this->name));

        // Bind data
        $stmt->bindParam(':name', $this->name);

        // Execute query
        if($stmt->execute()){
          return true;
        }
        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);
        return false;
      }

      // Delete category
      public function delete(){
        // create query
        $query = 'DELETE FROM '.$this->table.' WHERE id = :id';

        // prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data -> the only thing we need to know is ID
        $this->id = htmlspecialchars(strip_tags($this->id));
        // Bind ID
        $stmt->bindParam(':id', $this->id);

        // Execute query
        if($stmt->execute()){
          return true;
        }
        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);
        return false;
      }

      // Update category
      public function update(){
        // create query
        $query = 'UPDATE '.$this->table.'
          SET
            name = :name
          WHERE
            id = :id';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data (sanitize data)
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind data
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':id', $this->id);

        // Execute query
        if($stmt->execute()){
          return true;
        }
        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);
        return false;
      }
    }
?>
