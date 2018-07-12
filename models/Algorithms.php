<?php

class Algorithms {
	// connection
	private $conn;
	
	// constructor, connection with db
	public function __construct($db){
		$this->conn = $db;
	}

	// returns data of all algorithms
	public function getAllAlgorithms() {
		try {
			$query = "SELECT g.*, ge.`edit-date`, ge.`edited-by` FROM diagenkri.graph g LEFT JOIN ( SELECT * FROM `graph-edits` WHERE `edit-date` IN (SELECT max(`edit-date`) FROM `graph-edits` GROUP BY `graph-id`) ) AS ge ON g.id = ge.`graph-id`;";

			$statement1 = $this->conn->prepare($query);
	        $statement1->execute();
    	} catch(Exception $err){
    		return 0;
    	}
        return $statement1;
	}

	// returns data of algorithm with id as paramter
	public function getAlgorithm($id) {
		try {
			$query = "SELECT g.*, ge.`edit-date`, ge.`edited-by` FROM diagenkri.graph g LEFT JOIN ( SELECT * FROM `graph-edits` WHERE `edit-date` IN (SELECT max(`edit-date`) FROM `graph-edits` GROUP BY `graph-id`) ) AS ge ON g.id = ge.`graph-id` WHERE g.id = :id;";

			$statement1 = $this->conn->prepare($query);
			$statement1->bindParam(":id", $id);
	        $statement1->execute();
    	} catch(Exception $err){
    		return 0;
    	}
        return $statement1;
	}
}