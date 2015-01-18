<?php
header("Content-type: application/json");
require("connect.php");
$query = mysqli_query($con, "SELECT * FROM users ORDER BY id DESC LIMIT 1");
$row = mysqli_fetch_array($query);
$id = $row['id'];
echo json_encode(array('id' => $id));
?>