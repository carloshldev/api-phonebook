<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/phones.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare phones object
$phones = new Phones($db);
 
// set ID property of record to read
$phones->id_phone = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of phones to be edited
$phones->readOne();
 
if($phones->id_phone!=null){
    // create array
    $phones_arr = array(
        
"id_phone" => $phones->id_phone,
"phones" => $phones->phones,
"name" => $phones->name,
"contact_id" => $phones->contact_id
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "phones found","document"=> $phones_arr));
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user phones does not exist
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "phones does not exist.","document"=> ""));
}
?>
