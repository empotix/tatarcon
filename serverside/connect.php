<?php
$mysql_server = "localhost";
$mysql_user = "root";
$mysql_password = "";
$mysql_db = "tatarcom";
$con = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_db);
if ($con->connect_errno) {
	printf("Connection failed: %s \n", $con->connect_error);
	exit();
}
//$mysqli->set_charset("utf8");
		
function secureInput($input, $con){
	$input = mysqli_real_escape_string($con, $input);
	$input = strip_tags($input);
	$input = stripslashes($input);
	$input = htmlentities($input);

		return $input;
}

function sql2json($query, $con) {
    $data_sql = mysqli_query($con, $query) or die("'';//" . mysql_error());
    $json_str = "";
    $total = mysqli_num_rows($data_sql);
    $json_str .= "[\n";
	$row_count = 0;
        while($data = mysqli_fetch_assoc($data_sql)) {
            if(count($data) > 1) $json_str .= "{\n";
			$count = 0;
            foreach($data as $key => $value) {
                if(count($data) > 1) $json_str .= "\"$key\":\"$value\"";
                else $json_str .= "\"$value\"";
                $count++;
                if($count < count($data)) $json_str .= ",\n";
            }         
            $row_count++;
            if(count($data) > 1) $json_str .= "}\n";
            if($row_count < $total) $json_str .= ",\n";
        }
    $json_str .= "]\n";
    	$json_str = str_replace("\n","",$json_str); //Comment this out when you are debugging the script
    	return $json_str;
}

?>