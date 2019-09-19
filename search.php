<?php 
	include("includes/includedFiles.php");

	if(isset($_GET['term'])) {
		$term = urldecode($_GET['term']); //urldecode is able to transform %20 into a white space
	}
	else {
		$term = "";
	}
?>

<div class="searchContainer">
	<h4>Search for an artist, album or song</h4>
	<input type="search" class="searchInput" value="<?php echo $term; ?>" onfocus="this.value = this.value" placeholder="Start typing...">
</div>


<script>

	$(".searchInput").focus();

	$(function() {

		$(".searchInput").keyup(function() {
			clearTimeout(timer);

			timer = setTimeout(function() {
				var value = $(".searchInput").val();
				openPage("search.php?term=" + value);
			}, 2000);
		});
	});

</script>


<?php if($term == "") exit(); ?>

<!-- Search through the list of songs -->
<div class="trackListContainer borderBottom">
	<h2>SONGS</h2>
	<ul class="tracklist">
		<?php

			$songsQuery = mysqli_query($con, "SELECT id FROM songs WHERE title LIKE '$term%' LIMIT 10");
			if(mysqli_num_rows($songsQuery) == 0) {
				echo "<span class='noResults'> No songs found matching " . $term . "</span>";
			}

			$songIdArray = array();

			$i = 1;
			while($row = mysqli_fetch_array($songsQuery)) {

				if ($i > 15) {
					break;
				}

				array_push($songIdArray, $row['id']);

				$albumSong = new Song($con, $row['id']);
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

<!-- Search through the list of artists -->
<div class="artistContainer borderBottom">
	
	<h2>ARTISTS</h2>

	<?php
		$artistQuery = mysqli_query($con, "SELECT id FROM artists WHERE name LIKE '$term%' LIMIT 10");

		if(mysqli_num_rows($artistQuery) == 0){
			echo "<span class='noResults'> No artists found matching " . $term . "</span>";
		}

		while($row = mysqli_fetch_array($artistQuery)){
			$artistFound = new Artist($con, $row['id']);

			echo "<div class='searchResultRow'>
					<div class='artistName'>

						<span role='link' tabindex='0' onclick='openPage(\"artist.php?id=" . $artistFound->getId() . "\")'>
						"
							. $artistFound->getName() .
						"
						</span>

					</div>
				</div>";
		}
	?>
</div>


<!-- Search through the list of albums -->
<div class="gridViewContainer borderBottom">
	<h2>ALBUMS</h2>
		<?php
			$albumQuery  = mysqli_query($con, "SELECT * FROM albums WHERE title LIKE '$term%' LIMIT 10");

			if(mysqli_num_rows($artistQuery) == 0){
				echo "<span class='noResults'> No albums found matching " . $term . "</span>";
			}

			while($row = mysqli_fetch_array($albumQuery)){

				echo "<div class='gridViewItem'>
						<span role='link' tabindex='0' onclick='openPage(\"album.php?id=" . $row['id'] . "\")'> 
							<img src='" . $row['artworkPath'] . "'>

							<div class='gridViewInfo'>"

								. $row['title'] .

							"</div>
						</span>
					</div>";
			}
		?>
</div>

<nav class="optionsMenu">
	<input type="hidden" class="songId"> <!-- (this).prev('songId') will not refer to the one at the top, but rather that which is the immediate previous sibling of the this referred to element -->
	<?php echo Playlist::getPlaylistsDropdown($con, $userLoggedIn->getUsername()); ?>
</nav>
