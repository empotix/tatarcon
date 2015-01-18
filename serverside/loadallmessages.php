<?php

function get_time_ago($time_stamp){
    $time_difference = strtotime('now') - $time_stamp;

    if ($time_difference >= 60 * 60 * 24 * 365.242199)
    {
        /*
         * 60 seconds/minute * 60 minutes/hour * 24 hours/day * 365.242199 days/year
         * This means that the time difference is 1 year or more
         */
        return get_time_ago_string($time_stamp, 60 * 60 * 24 * 365.242199, 'year');
    }
    elseif ($time_difference >= 60 * 60 * 24 * 30.4368499)
    {
        /*
         * 60 seconds/minute * 60 minutes/hour * 24 hours/day * 30.4368499 days/month
         * This means that the time difference is 1 month or more
         */
        return get_time_ago_string($time_stamp, 60 * 60 * 24 * 30.4368499, 'month');
    }
    elseif ($time_difference >= 60 * 60 * 24 * 7)
    {
        /*
         * 60 seconds/minute * 60 minutes/hour * 24 hours/day * 7 days/week
         * This means that the time difference is 1 week or more
         */
        return get_time_ago_string($time_stamp, 60 * 60 * 24 * 7, 'week');
    }
    elseif ($time_difference >= 60 * 60 * 24)
    {
        /*
         * 60 seconds/minute * 60 minutes/hour * 24 hours/day
         * This means that the time difference is 1 day or more
         */
        return get_time_ago_string($time_stamp, 60 * 60 * 24, 'day');
    }
    elseif ($time_difference >= 60 * 60)
    {
        /*
         * 60 seconds/minute * 60 minutes/hour
         * This means that the time difference is 1 hour or more
         */
        return get_time_ago_string($time_stamp, 60 * 60, 'hour');
    }
    else
    {
        /*
         * 60 seconds/minute
         * This means that the time difference is a matter of minutes
         */
        return get_time_ago_string($time_stamp, 60, 'minute');
    }
}

function get_time_ago_string($time_stamp, $divisor, $time_unit)
{
    $time_difference = strtotime("now") - $time_stamp;
    $time_units      = floor($time_difference / $divisor);

    settype($time_units, 'string');

    if ($time_units === '0')
    {
        return 'less than 1 ' . $time_unit . ' ago';
    }
    elseif ($time_units === '1')
    {
        return '1 ' . $time_unit . ' ago';
    }
    else
    {
        /*
         * More than "1" $time_unit. This is the "plural" message.
         */
        // TODO: This pluralizes the time unit, which is done by adding "s" at the end; this will not work for i18n!
        return $time_units . ' ' . $time_unit . 's ago';
    }
}


//header("Content-type: application/json");
require("connect.php");
$data = json_decode(file_get_contents('php://input'), true);
$with = $data['to'];
$id = $data['id'];
	if($with == null || $id == null){
		return false;
	}
$with = secureInput($with, $con);
$id = secureInput($id, $con);
	
	$query = mysqli_query($con, "SELECT * FROM chat WHERE usr1='$id' AND usr2='$with' OR usr1='$with' AND usr2='$id'");
	$row = mysqli_fetch_array($query);
	$chatid = $row['id'];

	$query = mysqli_query($con, "SELECT * FROM messages WHERE chat='$chatid'");
		while($row = mysqli_fetch_array($query)){
				$type = null;
				$typee = null;
				$kala = get_time_ago($row['time']);

				if($row['creator'] == $id){
					$type = "msg_sent";
					$typee = "base_sent";
				}else{
					$type = "base_receive";
					$typee = "msg_receive";
				}
			?>
			<div class="panel-body msg_container_base" style="display: block; padding-top: 23px;">

                    <div class="row msg_container <?php echo $typee; ?>">
                        <div class="col-md-10 col-xs-10">
                            <div class="messages <?php echo $type; ?>">
                                <p><?php echo $row['kabara']; ?></p>
                                <time><?php echo $kala; ?></time>
                            </div>
                       </div>   
                    </div>

                </div>
                

			<?php
		}

?>