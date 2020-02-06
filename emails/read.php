<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here

// include database and object files
include_once '../config/database.php';
include_once '../objects/emails.php';
 include_once '../token/validatetoken.php';
// instantiate database and emails object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$emails = new Emails($db);
 
// read emails will be here

// query emails
$stmt = $emails->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    //emails array
    $emails_arr=array();
    $emails_arr["records"]=array();
 
    // retrieve our table contents
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $emails_item=array(
            
"id_email" => $id_email,
"emails" => $emails,
"name" => $name,
"contact_id" => $contact_id
        );
 
        array_push($emails_arr["records"], $emails_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show emails data in json format
	echo json_encode(array("status" => "success", "code" => 1,"message"=> "emails found","document"=> $emails_arr));
    
}else{
 // no emails found will be here

    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no emails found
	echo json_encode(array("status" => "error", "code" => 0,"message"=> "No emails found.","document"=> ""));
    
}
 


