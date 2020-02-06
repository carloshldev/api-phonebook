<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here

// include database and object files
include_once '../config/database.php';
include_once '../objects/contacts.php';
 include_once '../token/validatetoken.php';
// instantiate database and contacts object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$contacts = new Contacts($db);
 
// read contacts will be here

// query contacts
$stmt = $contacts->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    //contacts array
    $contacts_arr=array();
    $contacts_arr["records"]=array();
 
    // retrieve our table contents
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $contacts_item=array(
            
"id" => $id,
"name" => $name,
"surname" => $surname
        );
 
        array_push($contacts_arr["records"], $contacts_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show contacts data in json format
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "contacts found","document"=> $contacts_arr));
    
}else{
 // no contacts found will be here

    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no contacts found
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No contacts found.","document"=> ""));
    
}
 


