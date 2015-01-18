<?php
header("Content-type: application/json");
require("connect.php");
$data = json_decode(file_get_contents('php://input'), true);
$name = $data['name'];
	if($name == null){
		return false;
	}
$name = secureInput($name, $con);
$query = mysqli_query($con, "INSERT INTO users (user) VALUES('$name')");
	if(!$query){
		echo json_encode(array('status' => false));
	}else{
		$query = mysqli_query($con, "SELECT * FROM users WHERE user='$name'");
		$row = mysqli_fetch_array($query);
		$id = $row['id'];
		echo json_encode(array('status' => true, 'id' => $id));
	}
?>