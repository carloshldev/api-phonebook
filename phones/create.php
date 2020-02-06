<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate phones object
include_once '../objects/phones.php';
 include_once '../token/validatetoken.php';
$database = new Database();
$db = $database->getConnection();
 
$phones = new Phones($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(
!empty($data->phones)
&&!empty($data->contact_id)
){
 
    // set phones property values
	 
$phones->phones = $data->phones;
$phones->contact_id = $data->contact_id;
 
    // create the phones
    if($phones->create()){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("status" => "success", "code" => 1,"message"=> "Created Successfully","document"=> ""));
    }
 
    // if unable to create the phones, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
		echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to create phones","document"=> ""));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "Unable to create phones. Data is incomplete.","document"=> ""));
}
?>
