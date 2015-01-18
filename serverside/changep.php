<?php
header("Content-type: application/json");
require("connect.php");
$data = json_decode(file_get_contents('php://input'), true);
$user = $data['id'];
$dp = $data['dp'];

	if($user == null || $dp == null){
		return false;
	}
$user = secureInput($user, $con);
$dp = secureInput($dp, $con);
$query = mysqli_query($con, "UPDATE users SET dp='$dp' WHERE id='$user'");
	if(!$query){
		echo json_encode(array('stat' => false));
	}else{
		echo json_encode(array('stat' => true));
	}
?>