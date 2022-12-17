<html>
    <head>
        <title>Order Date</title>
    </head>
    <body>
        <center>
        <h1>Calculate Your Expected Date Delivery</h1>
        <form action="index.php" method="post">
            <label>Date:</label>
            <input type="date" name="date" required><hr>
            <label>Time:</label>
            <input type="time" name="time" required><hr>
            <input type="submit" name="btnsubmit">
        </form>
    </center>
    </body>
</html>

<?php

require 'config.php';
$time=$_POST['time'];
$date=$_POST['date'];
$timestamp = strtotime($date);
$day=date('l',$timestamp);
$curr_month=date("m",$timestamp);
$curr_date=date("d",$timestamp);
$curr_year=date("y",$timestamp);
//$date - Y-m-d format
function getShippingDate($date,$day,$time,$cutOffTime,$holidays,$timestamp,$curr_date,$curr_month,$curr_year) {
	$hour=substr($time,0,2);
	$hour=intval($hour);
	if (in_array($day,$holidays)){
		$ad=0;
		if ($day=="Friday"){
			$ad=$curr_date+6;
		}
		elseif ($day=="Saturday"){
			$ad=$curr_date+5;
		}
		elseif ($day=="Sunday"){
			$ad=$curr_date+4;
		}
		elseif ($day=="Monday"){
			$ad=$curr_date+3;
		}
		elseif ($day=="Tuesday"){
			$ad=$curr_date+2;
		}
		elseif ($day=="Wednesday"){
			$ad=$curr_date+1;
		}
		if ($ad>30){
			$ad=$ad-30;
			$curr_date=strval($ad);
			$am=intval($curr_month)+1;
			if ($am>12){
				$am=$am-12;
				$ay=intval($curr_year)+1;
				$curr_year=strval($ay);
				$curr_month=strval($am);
			}
		}
		else{
			$curr_date=strval($ad);
		}
		return $curr_date."/".$curr_month."/".$curr_year."(Thursday)";
	}
	
	else{
		if ($day=="Thursday" and $hour>=11){
			$curr_date=$curr_date+1;

			return $curr_date."/".$curr_month."/".$curr_year."(Friday)";
		}
		if ($day=="Friday" and $hour<=10){

			return $curr_date."/".$curr_month."/".$curr_year."(Friday)";
		}
		else{

			return $curr_date."/".$curr_month."/".$curr_year." (Thursday) ";

		}	
	}
}
$exp_day="";
$exp_day=getShippingDate($date,$day,$time,$cutOffTime,$holidays,$timestamp,$curr_date,$curr_month,$curr_year);
?>