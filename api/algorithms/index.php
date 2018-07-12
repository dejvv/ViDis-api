<?php
	// final output in json format
	function format_data($result){
		$output_array = array();
		$output_array['data'] = array();
		while($row = $result->fetch(PDO::FETCH_ASSOC)){
			$email = $row["e-mail"];
			$edit_date = $row["edit-date"];
			$edited_by = $row["edited-by"];
			
			extract($row);
			$algorithm = array(
				'id' => $id,
				'author' => $email,
				'name' => $name,
				'description' => $description,
				'intended' => $visual,
				'type' => $algorithm_type,
				'graph_data' => $data,
				'created' => $created,
				'modified' => $edit_date,
				'modified_by' => $edited_by
			);

			array_push($output_array['data'], $algorithm);
		}
		return $output_array;
	}

	// Headers
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');

	// database connection
	require_once "../config/DBconnect.php";
	require_once '../models/Algorithms.php';

	// Database
	$database = new DBconnect();
	$db = $database::connect();

	// Algorithm object
	$algorithms = new Algorithms($db);

	if(empty($_GET)){
		// get result
		$result = $algorithms->getAllAlgorithms();	

		// check if there actually is any result
		$num = $result === 0 ? $result : $result->rowCount();

		if($num == 0){
			echo json_encode(
				array('message' => 'No Algorithms Found')
			);
			return false;
		}

		$output_array = format_data($result);
		echo json_encode($output_array);
		return true;
	} else if(isset($_GET["id"]) && is_numeric($_GET["id"])){
		// get result
		$result = $algorithms->getAlgorithm($_GET["id"]);	

		// check if there actually is any result
		$num = $result === 0 ? $result : $result->rowCount();

		if($num == 0){
			echo json_encode(
				array('message' => 'Algorithm With Id ' . $_GET["id"] . " Does Not Exists")
			);
			return false;
		}

		$output_array = format_data($result);
		echo json_encode($output_array);
		return true;
	} else {
		echo json_encode(
				array('message' => 'Wrong Parameters')
			);
		return false;
	}

	