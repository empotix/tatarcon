<?php
header("Content-type: application/json");
require("connect.php");
$query = sql2json("SELECT * FROM users ORDER BY id DESC", $con);
echo $query;
?>