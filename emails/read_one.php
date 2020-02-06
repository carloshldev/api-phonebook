<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/emails.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare emails object
$emails = new Emails($db);
 
// set ID property of record to read
$emails->id_email = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of emails to be edited
$emails->readOne();
 
if($emails->id_email!=null){
    // create array
    $emails_arr = array(
        
"id_email" => $emails->id_email,
"emails" => $emails->emails,
"name" => $emails->name,
"contact_id" => $emails->contact_id
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
   echo json_encode(array("status" => "success", "code" => 1,"message"=> "emails found","document"=> $emails_arr));
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user emails does not exist
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "emails does not exist.","document"=> ""));
}
?>
