<?php
include_once '../../config/Database.php';
include_once '../../models/Penn.php';
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

// Create instance of Penn model
$penn = new Penn($db);

// Check if query string exists
if(!isset($_GET['firma'])){
    echo json_encode(array('message' => 'No query inputed'));
    die();
}

// Get query: example 'www.example.com/read?firma_id=3'
$firma_name_temp = isset($_GET['firma']) ? $_GET['firma'] : die(); 
$penn->firma_name = '%' . $firma_name_temp . '%';

// query all pens with for a spesific firma
$query = $penn->read_by_firma();

// Check if there is any Penns
$num = $query->rowCount();
if ($num > 0){
    // array
    $penn_arr = array();
    $penn_arr['data'] = array();

    // PDO::FETCH_ASSOC: returns an array indexed by column name as returned in your result set
    while($row = $query->fetch(PDO::FETCH_ASSOC)){
        // Extract arrray
        extract($row);

        // Create new array with the extracted elements
        $penn_item = array(
            'id' => $id,
            'name' => $name,
            'type' => $type,
            'color' => $color,
            'image' => $image,
            'firma_name' => $firma_name 
        );

        //Push item to pennArr['data']
        array_push($penn_arr['data'], $penn_item);
    }

    // Convert from php array to json format
    echo json_encode($penn_arr);
} else {
    // If empty
    echo json_encode(array('message' => 'No Result Found'));
}