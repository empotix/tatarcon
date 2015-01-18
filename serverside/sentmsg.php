<?php
header("Content-type: application/json");
require("connect.php");
$data = json_decode(file_get_contents('php://input'), true);
$from = $data['id'];
$to = $data['to'];
$msg = $data['msg'];
	if($from == null || $to == null){
		return false;
	}
$from = secureInput($from, $con);
$to = secureInput($to, $con);
$msg = secureInput($msg, $con);
$time = time();

$query = mysqli_query($con, "SELECT * FROM chat WHERE (usr1='$to' OR usr1='$from') AND (usr2='$from' OR usr2='$to')");
	if($query){
	$result = mysqli_num_rows($query);
		if($result != 0){
				$row = mysqli_fetch_array($query);
				$chatid = $row['id'];
	$query = mysqli_query($con, "INSERT INTO messages (kabara, creator, time, chat) VALUES('$msg', '$from', '$time', '$chatid')");
				echo json_encode(mysqli_error($con));
			}else{
				$query = mysqli_query($con, "INSERT INTO chat (usr1, usr2) VALUES('$from', '$to')");
			}
	}
?>