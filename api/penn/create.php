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

// Get form data
$data = array();
$data['name'] = $_POST['name'];
$data['type'] = $_POST['type'];
$data['color'] = $_POST['color'];
$data['firma_id'] = $_POST['firma_id'];

// Collect information from the uploaded file
$fileName  =  $_FILES['image']['name'];
$tempPath  =  $_FILES['image']['tmp_name'];
$fileSize  =  $_FILES['image']['size'];

// Check if images exists
if(empty($fileName))
{
	$errorMSG = json_encode(array("message" => "please select image", "status" => false));	
	echo $errorMSG;
}
else
{
    // set upload folder path 
	$upload_path = '../../images/'; 

	 // get image extension
	$fileExt = strtolower(pathinfo($fileName,PATHINFO_EXTENSION));
		
	// valid image extensions
	$valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); 
					
	// allow valid image file formats
	if(in_array($fileExt, $valid_extensions))
	{				
		//check file not exist our upload folder path
		if(!file_exists($upload_path . $fileName))
		{
			// check file size '5MB'
			if($fileSize < 5000000){
                // move file from system temporary path to our upload folder path 
				move_uploaded_file($tempPath, $upload_path . $fileName); 
			}
			else{		
				$errorMSG = json_encode(array("message" => "Sorry, your file is too large, please upload 5 MB size", "status" => false));	
				echo $errorMSG;
                die();
			}
		}
		else
		{		
			$errorMSG = json_encode(array("message" => "Sorry, file already exists check upload folder", "status" => false));	
			echo $errorMSG;
            die();
		}
	}
	else
	{		
		$errorMSG = json_encode(array("message" => "Sorry, only JPG, JPEG, PNG & GIF files are allowed", "status" => false));	
		echo $errorMSG;	
        die();	
	}
}
		
// if no error caused, continue ....
if(!isset($errorMSG))
{
        // Add data
        $penn->name = $data['name'];
        $penn->type = $data['type'];
        $penn->color = $data['color'];
        $penn->image = $fileName;
        $penn->firma_id = $data['firma_id'];
        
        // Create new penn
        if($penn->create()) {
            echo 'Penn successfully created';
        } else {
            echo 'Failed to create new Penn';
        }
		
}




