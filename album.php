<!-- The Header  -->
<?php 
// include("includes/header.php");
include("includes/includedFiles.php");
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
			<p role="link" tabindex="0" onclick="openPage('artist.php?id=$artistId')">By <?php echo $artist->getName(); ?></p>
			<p><?php echo $album->getNumberOfSongs(); ?> Song(s)</p>
		</div>

	</div>

	<div class="trackListContainer">
		<ul class="tracklist">
			<?php
			
				$songIdArray = $album->getSongIds();

				$i = 1;
				foreach($songIdArray as $songId){
					$albumSong = new Song($con, $songId);
					$albumArtist = $albumSong->getArtist();

					echo "<li class='tracklistRow'>
							<div class='trackCount'>
								<img class='play' src='assets/images/icons/play-white.png' onclick='setTrack(\"" . $albumSong->getId() . "\", tempPlaylist, true) '>
								<span class='trackNumber'>$i</span>
							</div>
							<div class='trackInfo'>
								<span class='trackName'>" . $albumSong->getTitle() . "</span>
								<span class='artistName'>" . $albumArtist->getName() . "</span>
							</div>
							<div class='trackOptions'>
								<input type='hidden' class='songId' value='" . $albumSong->getId() . "'>
								<img class='optionsButton' src='assets/images/icons/more.png' onclick='showOptionsMenu(this)'>
							</div>
							<div class='trackDuration'>
								<span class='duration'>" . $albumSong->getDuration() . "</span>
							</div>
						</li>";
					$i++;
				}
			?>

			<script type="text/javascript">
				var tempSongIds = '<?php echo json_encode($songIdArray); ?>';
				tempPlaylist = JSON.parse(tempSongIds);
			</script>

		</ul>
	</div>


<!-- The Footer -->
<!-- <?php //include("includes/footer.php"); ?> -->

<!-- // when ever you use 'this', it refers to the element on which it is called -->


<nav class="optionsMenu">
	<input type="hidden" name="songId"> <!-- (this).prev('songId') will not refer to the one at the top, but rather that which is the immediate previous sibling of the this referred to element -->
	<?php echo Playlist::getPlaylistsDropdown($con, $userLoggedIn->getUsername()); ?>
	<div class="item">Item 2</div>
	<div class="item">Item 3</div>
</nav>
