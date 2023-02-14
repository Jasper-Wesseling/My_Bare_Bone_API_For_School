<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header("Access-Control-Allow-Headers: X-Requested-With");

$method = $_SERVER['REQUEST_METHOD'];

function SQL_request($sql) {
	global $method;
	$servername = "localhost";
	$databasename = "bedrijf";
	$username = "root";
	$password = "";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $databasename);

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 

	$result = $conn->query($sql);
	$conn->close();
	
	if ($method == 'GET') {
		$tempArray = array();
		while($row = mysqli_fetch_assoc($result))
		{
			$tempArray[] = $row;
		}
	
		return('{"bedrijf_info":'.json_encode($tempArray).'}');
	}
};


if ($method == 'GET') {
	// echo "THIS IS A GET REQUEST";
	echo(SQL_request("SELECT * FROM `bedrijf_info` WHERE `ID`"));
}

if ($method == 'POST') {
	$input = json_decode(file_get_contents('php://input'), true); 

	if ($input["bedrijfsnaam"] && $input["adres"] && $input["woonplaats"] && $input["Telnr"]) { 
		SQL_request("INSERT INTO `bedrijf_info` (`ID`, `bedrijfsnaam`, `adres`, `woonplaats`, `Telnr`, `DateAdded`) VALUES (NULL, '". $input["bedrijfsnaam"] ."', '". $input["adres"] ."', '". $input["woonplaats"] ."', '". $input["Telnr"] ."', current_timestamp());");
		echo('ok');
	} else {
		echo('no input/wrong input');
	}	
}

if ($method == 'PUT') { 
	$input = json_decode(file_get_contents('php://input'), true); 

	if ($input["bedrijfsnaam"] && $input["adres"] && $input["woonplaats"] && $input["Telnr"] && $input["id"]) { 
		SQL_request("UPDATE `bedrijf_info` SET `bedrijfsnaam` = '". $input["bedrijfsnaam"] ."', `adres` = '". $input["adres"] ."', `woonplaats` = '". $input["woonplaats"] ."', `Telnr` = '". $input["Telnr"] ."' WHERE `bedrijf_info`.`ID` = ". $input['id'] .";");
		echo('ok');
	} else {
		echo('no input/wrong input');
	}
}

if ($method == 'DELETE') {
	$input = json_decode(file_get_contents('php://input'), true); 

	if ($input["id"]) {
		SQL_request("DELETE FROM `bedrijf_info` WHERE `bedrijf_info`.`ID` = ". $input["id"] ."");
	} else {
		echo(' no ID given ');
	}
}
