<?php
class Firma {
    // DB stuff
    private $conn;
    private $table = 'firma';
    
    // Firma Properties
    public $id;
    public $name;
    public $addresse;
    public $tlf;

    // Penn Properties
    public $penn_id;
    public $penn_name;
    public $penn_type;
    public $penn_color;

    // Constructor with DB
    public function __construct($db) {
        $this->conn = $db;
    }

    // Read all firmas
    public function read_all() {
        // query
        $query = 'SELECT
                f.id,
                f.name,
                f.addresse,
                f.tlf
            FROM 
                ' . $this->table . ' f
            ORDER BY
                f.id ASC';
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();
        
        return $stmt;
    }
}