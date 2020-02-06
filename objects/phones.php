<?php
class Phones{
 
    // database connection and table name
    private $conn;
    private $table_name = "phones";
	private $pageNo = 1;
	private  $no_of_records_per_page=30;
    // object properties
	
public $id_phone;
public $phones;
public $contact_id;
public $name;
    
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
	
	// read phones
	function read(){
		if(isset($_GET["pageNo"])){
		$this->pageNo=$_GET["pageNo"];
		}
		$offset = ($this->pageNo-1) * $this->no_of_records_per_page; 
		// select all query
		$query = "SELECT  x.name, t.* FROM ". $this->table_name ." t  join contacts x on t.contact_id = x.id  LIMIT ".$offset." , ". $this->no_of_records_per_page."";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// execute query
		$stmt->execute();
	 
		return $stmt;
	}
	
	// create phones
	function create(){
	 
		// query to insert record
		$query ="INSERT INTO ".$this->table_name." SET phones=:phones,contact_id=:contact_id";

		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		
$this->phones=htmlspecialchars(strip_tags($this->phones));
$this->contact_id=htmlspecialchars(strip_tags($this->contact_id));
	 
		// bind values
		
$stmt->bindParam(":phones", $this->phones);
$stmt->bindParam(":contact_id", $this->contact_id);
	 
		// execute query
		if($stmt->execute()){
			return true;
		}
	 
		return false;
		 
	}
	
	// used when filling up the update phones form
	function readOne(){
	 
		// query to read single record
		$query = "SELECT  x.name, t.* FROM ". $this->table_name ." t  join contacts x on t.contact_id = x.id  WHERE t.id_phone = ? LIMIT 0,1";
	 
		// prepare query statement
		$stmt = $this->conn->prepare( $query );
	 
		// bind id of product to be updated
		$stmt->bindParam(1, $this->id_phone);
	 
		// execute query
		$stmt->execute();
	 
		// get retrieved row
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
	 
		// set values to object properties
		
$this->id_phone = $row['id_phone'];
$this->phones = $row['phones'];
$this->contact_id = $row['contact_id'];
$this->name = $row['name'];
	}
	
	// update the phones
	function update(){
	 
		// update query
		$query ="UPDATE ".$this->table_name." SET phones=:phones,contact_id=:contact_id WHERE id_phone = :id_phone";
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		
$this->phones=htmlspecialchars(strip_tags($this->phones));
$this->contact_id=htmlspecialchars(strip_tags($this->contact_id));
$this->id_phone=htmlspecialchars(strip_tags($this->id_phone));
	 
		// bind new values
		
$stmt->bindParam(":phones", $this->phones);
$stmt->bindParam(":contact_id", $this->contact_id);
$stmt->bindParam(":id_phone", $this->id_phone);
	 
		// execute the query
		if($stmt->execute()){
			return true;
		}
	 
		return false;
	}
	
	// delete the phones
	function delete(){
	 
		// delete query
		$query = "DELETE FROM " . $this->table_name . " WHERE id_phone = ? ";
	 
		// prepare query
		$stmt = $this->conn->prepare($query);
	 
		// sanitize
		$this->id=htmlspecialchars(strip_tags($this->id_phone));
	 
		// bind id of record to delete
		$stmt->bindParam(1, $this->id_phone);
	 
		// execute query
		if($stmt->execute()){
			return true;
		}
	 
		return false;
		 
	}
}


?>
