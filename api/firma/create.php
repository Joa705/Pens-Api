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

// Verify that the request method is correct
$request = new Request('Post');
$request->veryify_method();

// Create DB instance and connection
$database = new Database();
$db = $database->connect();

// Instance of Firma
$firma = new Firma($db);

// Get users data
$data = array();
$data['name'] = $_POST['name'];
$data['website'] = $_POST['website'];
$data['addresse'] = $_POST['addresse'];
$data['tlf'] = $_POST['tlf'];

// add data
$firma->name = $data['name'];
$firma->website = $data['website'];
$firma->addresse = $data['addresse'];
$firma->tlf = $data['tlf'];

// create new firma
if($firma->create()){
    echo json_encode(array('status' => 'new firma created'));
}