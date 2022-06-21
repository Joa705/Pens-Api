<?php

var_dump($_POST);
var_dump($_FILES);

// Get form data
$data = array();
$data['name'] = $_POST['name'];
$data['type'] = $_POST['type'];
$data['color'] = $_POST['color'];
$data['firma_id'] = $_POST['firma_id'];

$image = $_FILES['image'];



// Collect information from the uploaded file
$fileName = $_FILES['image']['name'];
$tempPath = $_FILES['image']['tmp_name'];
$fileSize = $_FILES['image']['size'];


echo($data['name']);
echo($data['type']);
echo($data['color']);
echo($data['firma_id']);
echo($fileName);
echo($tempPath);
echo($fileSize);



