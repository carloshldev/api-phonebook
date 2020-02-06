<?php
class Emails{
 
    // database connection and table name
    private $conn;
    private $table_name = "emails";
	private $pageNo = 1;
	private  $no_of_records_per_page=30;
    // object properties
	
public $id_email;
public $emails;
public $contact_id;
public $name;
    
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
	
	// read emails
	function read(){
		if(isset($_GET["pageNo"])){
		$this->pageNo=$_GET["pageNo"];
		}
		$offset = ($this->pageNo-1) * $this->no_of_records_per_page; 
		// select all query
		$query = "SELECT  i.name, t.* FROM ". $this->table_name ." t  join contacts i on t.contact_id = i.id  LIMIT ".$offset." , ". $this->no_of_records_per_page."";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// execute query
		$stmt->execute();
	 
		return $stmt;
	}
	
	// create emails
	function create(){
	 
		// query to insert record
		$query ="INSERT INTO ".$this->table_name." SET emails=:emails,contact_id=:contact_id";

		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		
$this->emails=htmlspecialchars(strip_tags($this->emails));
$this->contact_id=htmlspecialchars(strip_tags($this->contact_id));
	 
		// bind values
		
$stmt->bindParam(":emails", $this->emails);
$stmt->bindParam(":contact_id", $this->contact_id);
	 
		// execute query
		if($stmt->execute()){
			return true;
		}
	 
		return false;
		 
	}
	
	// used when filling up the update emails form
	function readOne(){
	 
		// query to read single record
		$query = "SELECT  i.name, t.* FROM ". $this->table_name ." t  join contacts i on t.contact_id = i.id  WHERE t.id_email = ? LIMIT 0,1";
	 
		// prepare query statement
		$stmt = $this->conn->prepare( $query );
	 
		// bind id of product to be updated
		$stmt->bindParam(1, $this->id_email);
	 
		// execute query
		$stmt->execute();
	 
		// get retrieved row
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
	 
		// set values to object properties
		
$this->id_email = $row['id_email'];
$this->emails = $row['emails'];
$this->contact_id = $row['contact_id'];
$this->name = $row['name'];
	}
	
	// update the emails
	function update(){
	 
		// update query
		$query ="UPDATE ".$this->table_name." SET emails=:emails,contact_id=:contact_id WHERE id_email = :id_email";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		
$this->emails=htmlspecialchars(strip_tags($this->emails));
$this->contact_id=htmlspecialchars(strip_tags($this->contact_id));
$this->id_email=htmlspecialchars(strip_tags($this->id_email));
	 
		// bind new values
		
$stmt->bindParam(":emails", $this->emails);
$stmt->bindParam(":contact_id", $this->contact_id);
$stmt->bindParam(":id_email", $this->id_email);
	 
		// execute the query
		if($stmt->execute()){
			return true;
		}
	 
		return false;
	}
	
	// delete the emails
	function delete(){
	 
		// delete query
		$query = "DELETE FROM " . $this->table_name . " WHERE id_email = ? ";
	 
		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->id=htmlspecialchars(strip_tags($this->id_email));
	 
		// bind id of record to delete
		$stmt->bindParam(1, $this->id_email);
	 
		// execute query
		if($stmt->execute()){
			return true;
		}
	 
		return false;
		 
	}
}


?>
