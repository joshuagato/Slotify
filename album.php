<!-- The Header  -->
<?php include("includes/header.php");
	if(isset($_GET['id'])){
		$albumId = $_GET['id'];
	}
	else{
		header("Location: index.php");
	}

	//$artistId = $album['artist']; //We dont really need this line again, we created the
	//variable so that the single quotes in there will not interferee with our  sql
	//statements in the sqli function

	$album = new Album($con, $albumId);
	$artist = $album->getArtist();
?>

	<div class="entityInfo">

		<div class="leftSection">
			<img src="<?php echo $album->getArtworkPath(); ?>">
		</div>

		<div class="rightSection">
			<h2><?php echo $album->getTitle(); ?></h2>
			<p>By <?php echo $artist->getName(); ?></p>
			<p><?php echo $album->getNumberOfSongs(); ?> Song(s)</p>
		</div>

	</div>


<!-- The Footer -->
<?php include("includes/footer.php"); ?>