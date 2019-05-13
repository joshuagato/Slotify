<?php
include("includes/config.php");
include("includes/classes/Artist.php");
include("includes/classes/Album.php");
include("includes/classes/Song.php");
//session_destroy(); //LOGOUT

	if(isset($_SESSION['userLoggedIn'])){
		$userLoggedIn =  $_SESSION['userLoggedIn'];
		echo "<script>userLoggedIn = '$userLoggedIn';</script>";
	}
	else{
		header("Location: register.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Slotify</title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<script type="text/javascript" src="assets/js/jquery-3.3.1.min.js"></script>
	<!-- <script src="assets/js/jquery-3.2.1.min.js" rel="script" type="text/javascript"></script> -->
	<script type="text/javascript" src="assets/js/script.js"></script>
</head>
<body>
	<script type="text/javascript">
		// window.onload = function(){

		// 	audioElement = new Audio();
		// 	audioElement.setTrack('assets/music/bensound-acousticbreeze.mp3');
		// 	audioElement.audio.play();

		// };


		// window.onload = function(){

			
		// 	audioElement = new Audio();
		// 	setTrack(currentPlaylist[0], currentPlaylist, false);

		// };

		// function setTrack(trackId, newPlaylist, play){
		// 	audioElement.setTrack("assets/music/bensound-acousticbreeze.mp3");
		// 	audioElement.audio.play();
		// 	console.log(this.currentPlaylist);
		// }

	</script>

	<div id="mainContainer">

		<div id="topContainer">

			<!-- navBarContainer goes here -->
			<?php include("includes/navBarContainer.php"); ?>

			<div id="mainViewContainer">

				<div id="mainContent">