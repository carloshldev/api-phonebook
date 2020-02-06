<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/phones.php';
 include_once '../token/validatetoken.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare phones object
$phones = new Phones($db);
 
// get id of phones to be edited
$data = json_decode(file_get_contents("php://input"));
 
// set ID property of phones to be edited
$phones->id_phone = $data->id_phone;

if(
!empty($data->phones)
&&!empty($data->contact_id)
){
// set phones property values

$phones->phones = $data->phones;
$phones->contact_id = $data->contact_id;
 
// update the phones
if($phones->update()){
 
    // set response code - 200 ok
    http_response_code(200);
 
    // tell the user
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "Updated Successfully","document"=> ""));
}
 
// if unable to update the phones, tell the user
else{
 
    // set response code - 503 service unavailable
    http_response_code(503);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to update phones","document"=> ""));
    
}
}
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to update phones. Data is incomplete.","document"=> ""));
}
?>
