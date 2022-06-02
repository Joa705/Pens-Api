<?php
include_once '../../config/Database.php';
include_once '../../models/Penn.php';
include_once '../../config/Header.php';

// Headers
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');

// New instanse of authorization 
$auth = new Auth();

// Check if request is using simple authorization header
$auth->check_user();

// Verify that the users credentials are correct
$auth->verify_user();

// New Request instance
$request = new Request('POST');

// Verify method
$request->veryify_method();

// Create DB instance and connection
$database = new Database();
$db = $database->connect();

// Create instance of Penn model
$penn = new Penn($db);

// Get raw data 
$data = json_decode(file_get_contents('php://input'));

// Add data
$penn->name = $data->name;
$penn->type = $data->type;
$penn->color = $data->color;
$penn->firma_id = $data->firma_id;

// Create new penn
if($penn->create()) {
    echo 'Penn successfully created';
} else {
    echo 'Failed to create new Penn';
}

