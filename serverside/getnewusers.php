<?php
header("Content-type: application/json");
require("connect.php");
$data = json_decode(file_get_contents('php://input'), true);
$user = $data['id'];
	if($user == null){
		return false;
	}
$user = secureInput($user, $con);
$query = sql2json("SELECT * FROM users WHERE id > $user ORDER BY id DESC", $con);
echo $query;
?>