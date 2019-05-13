<?php
	// if(isset($_SERVER['REQUEST_METHOD'] == 'POST')){
	if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
	// if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strcasecmp($_SERVER['HTTP_X_REQUESTED_WITH'], 'xmlhttprequest') == 0){
	// if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
		// echo "CAME FROM AJAX";
		include("includes/config.php");
		include("includes/classes/User.php");
		include("includes/classes/Artist.php");
		include("includes/classes/Album.php");
		include("includes/classes/Song.php");
		include("includes/classes/Playlist.php");

		if(isset($_GET['userLoggedIn'])){
			$userLoggedIn = new User($con, $_GET['userLoggedIn']);
		}

		else{
			echo "Username variable was not passed into page. Check the openPage JS function.";
			exit();
		}
	}

	else{
		// echo "CAME FROM BARCELONA";
		include("includes/header.php");
		include("includes/footer.php");

		$url = $_SERVER['REQUEST_URI'];
		echo "<script>openPage('$url')</script>";
		exit(); // This exit()here, prevents the grids to load twice
	}
?>