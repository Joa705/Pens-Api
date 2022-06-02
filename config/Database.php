<?php

    class Database {
        // DB Params
        private $host = 'localhost';
        private $dbName = 'penner';
        private $username = 'root';
        private $password = '';
        private $conn; 



        public function connect() {
            $this->conn = null;

            try {
                // Establish connection to database using PDO 
                $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbName, $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            } 
            // Catch PDO errors
            catch(PDOException $error){
                echo 'Connection Error' . $error->getMessage();
            } 

            return $this->conn;
        }

    }