<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/contacts.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare contacts object
$contacts = new Contacts($db);
 
// set ID property of record to read
$contacts->id = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of contacts to be edited
$contacts->readOne();
 
if($contacts->id!=null){
    // create array
    $contacts_arr = array(
        
"id" => $contacts->id,
"name" => $contacts->name,
"surname" => $contacts->surname
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "contacts found","document"=> $contacts_arr));
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user contacts does not exist
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "contacts does not exist.","document"=> ""));
}
?>
