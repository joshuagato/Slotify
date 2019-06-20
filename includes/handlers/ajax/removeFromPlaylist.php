<?php
	include("../../config.php");

	if(isset($_POST['playlistId']) && isset($_POST['playlistId'])) {
		$playlistId = $_POST['playlistId'];
		$songId = $_POST['songId'];

		$query = mysqli_query($con, "DELETE FROM playlistSongs WHERE playlistId='$playlistId' AND songId='$songId'");
	}
	else{
		echo "PlaylistId was not passed into removeFromPlaylist.php";
	}

?>