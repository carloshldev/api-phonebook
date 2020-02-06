<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here

// include database and object files
include_once '../config/database.php';
include_once '../objects/phones.php';
 include_once '../token/validatetoken.php';
// instantiate database and phones object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$phones = new Phones($db);
 
// read phones will be here

// query phones
$stmt = $phones->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    //phones array
    $phones_arr=array();
    $phones_arr["records"]=array();
 
    // retrieve our table contents
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $phones_item=array(
            
"id_phone" => $id_phone,
"phones" => $phones,
"name" => $name,
"contact_id" => $contact_id
        );
 
        array_push($phones_arr["records"], $phones_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show phones data in json format
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "phones found","document"=> $phones_arr));
    
}else{
 // no phones found will be here

    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no phones found
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No phones found.","document"=> ""));
    
}
 


