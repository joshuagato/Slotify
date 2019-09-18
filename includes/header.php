<?php
include("includes/config.php");
include("includes/classes/Artist.php");
include("includes/classes/Album.php");
include("includes/classes/Song.php");
// session_destroy(); //LOGOUT

	if(isset($_SESSION['userLoggedIn'])) {
		$userLoggedIn =  $_SESSION['userLoggedIn'];
		echo "<script>userLoggedIn = '$userLoggedIn';</script>"; //Creating js version of php variable to
	}
	else {
		header("Location: register.php");
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Slotify</title>
	<meta charset="utf-8">	
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">

	<link rel="stylesheet" type="text/css" href="assets/css/style.css">

	<script src="assets/js/jquery-3.3.1.min.js"></script>
	<script src="assets/js/script.js"></script>
</head>
<body>

	<script>


		// var audioElement = new Audio();
		// audioElement.setTrack('assets/music/Adehye-mogya.mp3');
		// audioElement.audio.play();


	</script>

	<div id="mainContainer">
		
		<div id="topContainer">
			
			<!-- navBarContainer goes here -->
			<?php include("includes/navBarContainer.php"); ?>


			<div id="mainViewContainer">
				<button class="toggle-menu">
					<img src="assets/images/icons/menu.png" alt="Menu" title="Toggle Menu">
				</button>
				<div id="mainContent">
					