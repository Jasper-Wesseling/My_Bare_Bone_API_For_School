<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header("Access-Control-Allow-Headers: X-Requested-With");

function SQL_request($sql) {
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
	
	$tempArray = array();
    while($row = mysqli_fetch_assoc($result))
    {
        $tempArray[] = $row;
    }

	return('{"bedrijf_info":'.json_encode($tempArray).'}');
};


$method = $_SERVER['REQUEST_METHOD'];
if ($method == 'GET') {
	// echo "THIS IS A GET REQUEST";
	echo(SQL_request("SELECT * FROM `bedrijf_info` WHERE `ID`"));
}
if ($method == 'POST') {
	SQL_request("SELECT * FROM `bedrijf_info` WHERE `ID`");
	$input = json_decode(file_get_contents('php://input'), true);
	echo($input["bedrijfsnaam"]);
}
if ($method == 'PUT') {
	SQL_request("SELECT * FROM `bedrijf_info` WHERE `ID`");
	echo "THIS IS A PUT REQUEST";
	echo(file_get_contents('php://input'));
}
if ($method == 'DELETE') {
	SQL_request("SELECT * FROM `bedrijf_info` WHERE `ID`");
	echo "THIS IS A DELETE REQUEST";
	echo(file_get_contents('php://input'));
}
