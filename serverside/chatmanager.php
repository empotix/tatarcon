<?php
header("Content-type: application/json");
require("connect.php");
$data = json_decode(file_get_contents('php://input'), true);
$from = $data['id'];
$to = $data['to'];
	if($from == null || $to == null){
		return false;
	}
$from = secureInput($from, $con);
$to = secureInput($to, $con);

$query = mysqli_query($con, "SELECT * FROM chat WHERE (usr1='$to' OR usr1='$from') AND (usr2='$from' OR usr2='$to')");
	if($query){
	$result = mysqli_num_rows($query);
		if($result != 0){
				$row = mysqli_fetch_array($query);
				$chatid = $row['id'];

				echo json_encode(array('known' => 'true', 'chat' => $chatid));
			}else{
			
				echo json_encode(array('known' => 'false', 'chat' => $chatid));
			}
	}
?>