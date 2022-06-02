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

// Get id: example 'www.example.com/read?id=3'
$penn->id = isset($_GET['id']) ? $_GET['id'] : die(); 

// get single penn if it exists
if(!$penn->get_single()){
    echo 'Couldnt find any pen with id ' . $penn->id;
    die();
}

// Create array
$penn_arr = array(
    'id' => $penn->id,
    'name' => $penn->name,
    'type' => $penn->type,
    'color' => $penn->color,
    'firma_name' => $penn->firma_name,
);

// Convert string to json 
print_r(json_encode($penn_arr)); 