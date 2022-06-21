<?php
    class Penn {
        // DB stuff
        private $conn;
        private $table = 'penn';

        // Penn Properties
        public $id;
        public $name;
        public $type;
        public $color;
        public $image;

        // Firma Properties
        public $firma_id;
        public $firma_name;
        public $firma_addresse;
        public $firma_tlf;
        
        // Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }

        // Get all penns
        public function get_all() {
            // query
            $query = 'SELECT
                    c.name as firma_name,
                    p.id,
                    p.name,
                    p.type,
                    p.color,
                    p.image
                FROM
                    ' . $this->table . ' p
                LEFT JOIN
                    firma c ON p.firma_id = c.id
                ORDER BY
                    p.id ASC';
            
            // Perparing statement 
            $stmt = $this->conn->prepare($query);

            // Execute query
            $stmt->execute();

            return $stmt;
        }

        // Get a single penn
        public function get_single() {
            // query
            $query = 'SELECT
                    c.name as firma_name,
                    p.id,
                    p.name,
                    p.type,
                    p.color
                FROM
                    ' . $this->table . ' p
                LEFT JOIN
                    firma c ON p.firma_id = c.id
                WHERE
                    p.id = '. $this->id . '
                LIMIT 0,1';   
            
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Bind id to '?'
            // $stmt->bindParam(1, $this->id);

            // Execute query
            $stmt->execute();

            // Fetch output from database
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Check if empty 
            if(!$row){return false;}

            // Set properties
            $this->name = $row['name'];
            $this->type = $row['type'];
            $this->color = $row['color'];
            $this->firma_name = $row['firma_name'];

            return true;
        }

        // Create new penn 
        public function create() {
            // query
            $query = 'INSERT INTO ' . $this->table . '
                SET 
                    name = :name,
                    type = :type,
                    color = :color,
                    image = :image,
                    firma_id = :firma_id';
            
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data 
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->type = htmlspecialchars(strip_tags($this->type));
            $this->color = htmlspecialchars(strip_tags($this->color));
            $this->firma_id = htmlspecialchars(strip_tags($this->firma_id));

            // Bind data to params 
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':type', $this->type);
            $stmt->bindParam(':color', $this->color);
            $stmt->bindParam(':image', $this->image);
            $stmt->bindParam(':firma_id', $this->firma_id);

            // Execute query
            if($stmt->execute()) {return true;}
            
            // Print error if execution goes wrong
            echo 'Error: ' . $stmt->error;
        }

        // Update a signle penn entry
        public function update() {
            // query
            $query = 'UPDATE ' . $this->table . '
                SET 
                    name = :name,
                    type = :type,
                    color = :color,
                    firma_id = :firma_id
                WHERE
                    id = :id';
            
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data 
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->type = htmlspecialchars(strip_tags($this->type));
            $this->color = htmlspecialchars(strip_tags($this->color));
            $this->firma_id = htmlspecialchars(strip_tags($this->firma_id));
            

            // Bind data to params 
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':type', $this->type);
            $stmt->bindParam(':color', $this->color);
            $stmt->bindParam(':firma_id', $this->firma_id);
            $stmt->bindParam(':id', $this->id);

            // Execute query
            if($stmt->execute()) {return true;}
            
            // Print error if execution goes wrong
            echo 'Error: ' . $stmt->error;
        }

        // Delete penn entry
        public function delete() {
            // query
            $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Bind data
            $stmt->bindParam(':id', $this->id);

            // Execute query
            if($stmt->execute()) {return true;}
            
            // Print error if execution goes wrong
            echo 'Error: ' . $stmt->error;
        }
        
        // query all penns with a spesific firma 
        public function read_by_firma() {
            // query
            $query = 'SELECT
                    c.name as firma_name,
                    p.id,
                    p.name,
                    p.type,
                    p.color,
                    p.image
                FROM
                    ' . $this->table . ' p
                LEFT JOIN
                    firma c ON p.firma_id = c.id
                WHERE
                    c.name LIKE "' . $this->firma_name . '"
                ';  
            
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Execute query
            $stmt->execute();

            return $stmt;
        }

        // Read all penns by name
        public function read_by_name() {
            // query
            $query =  'SELECT
                c.name as firma_name,
                p.id,
                p.name,
                p.type,
                p.image,
                p.color
            FROM
                ' . $this->table . ' p
            LEFT JOIN
                firma c ON p.firma_id = c.id
            WHERE p.name LIKE "' . $this->name . '"
            ';  

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Execute query
            $stmt->execute();

            return $stmt;
        }   

        // Read all penns by color
        public function read_by_color() {
        
            // query
            $query =  'SELECT
                c.name as firma_name,
                p.id,
                p.name,
                p.type,
                p.image,
                p.color
            FROM
                ' . $this->table . ' p
            LEFT JOIN
                firma c ON p.firma_id = c.id
            WHERE p.color LIKE "' . $this->color . '"
            ';  

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Execute query
            $stmt->execute();

            return $stmt;
        }
    }