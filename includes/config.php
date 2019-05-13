 <?php
 	ob_start(); //object buffering
 	session_start();

 	$timezone = date_default_timezone_set("Africa/Accra");

 	$con = mysqli_connect("localhost", "root", "", "slotify");

 	if(mysqli_connect_errno()){
 		echo "Failed to connect: " . mysqli_connect_errno();
 	}

?>