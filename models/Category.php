<?php
    class Category{
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
    }
?>
