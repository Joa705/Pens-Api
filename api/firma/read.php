<?php
include_once '../../config/Database.php';
include_once '../../models/Firma.php';
include_once '../../config/Header.php';

// Headers
header('Content-Type: application/json');

// New instanse of authorization 
$auth = new Auth();

// Check if request is using simple authorization header
$auth->check_user();

// Verify that the users credentials are correct
$auth->verify_user();

// Create DB instance and connection
$database = new Database();
$db = $database->connect();

// Instance of Firma
$firma = new Firma($db);

// Get all entries in firma 
$query = $firma->read_all();

// Check there exist any
if($query->rowcount() > 0) {
    
    // array
    $array = array();
    $array['data'] = array();

    // Fetch each row
    while($row = $query->fetch(PDO::FETCH_ASSOC)) {
        // extract data
        extract($row);

        // Create array with extracted elemnts
        $item = array(
            'id' => $id,
            'name' => $name,
            'website' => $website,
            'addresse' => $addresse,
            'tlf' => $tlf,
        );

        // push item to array 
        array_push($array['data'], $item);
    
    }
    // Convert from array to json format
    echo json_encode($array);
}