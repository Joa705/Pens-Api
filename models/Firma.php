<?php
class Firma {
    // DB stuff
    private $conn;
    private $table = 'firma';
    
    // Firma Properties
    public $id;
    public $name;
    public $addresse;
    public $website;
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
                f.website,
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

    // Add new firma
    public function create() {
        // query
        $query = 'INSERT INTO ' . $this->table . '
            SET
                name = :name,
                website = :website,
                addresse = :addresse,
                tlf = :tlf';
        
        // prepare staement
        $stmt = $this->conn->prepare($query);
        
        // Clean data 
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->website = htmlspecialchars(strip_tags($this->website));
        $this->addresse = htmlspecialchars(strip_tags($this->addresse));
        $this->tlf = htmlspecialchars(strip_tags($this->tlf));

        // Bind data to params 
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':website', $this->website);
        $stmt->bindParam(':addresse', $this->addresse);
        $stmt->bindParam(':tlf', $this->tlf);

        // Execute query
        if($stmt->execute()) {return true;}
        
        // Print error if execution goes wrong
        echo json_encode(array('Error' => $stmt->error));
    }
}