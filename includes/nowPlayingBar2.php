<?php 
	$songQuery = mysqli_query($con, "SELECT id FROM songs ORDER BY RAND() LIMIT 10");
	$resultArray = array();

	while($row = mysqli_fetch_array($songQuery)){
		array_push($resultArray, $row['id']);
	}

	$jsonArray = json_encode($resultArray);
?>

<script type="text/javascript">
		// ondomcontentloaded OR ondomcontentready
	// window.onload = function(){
	// document.ondomcontentloaded = function(){
	document.addEventListener('DOMContentLoaded', function(event){

		playButton = document.querySelector('.controlButton.play');
		pauseButton = document.querySelector('.controlButton.pause');

		// currentPlaylist = <?php //echo $jsonArray; ?>;
		var newPlaylist = <?php echo $jsonArray; ?>;
		audioElement = new Audio();
		setTrack(newPlaylist[0], newPlaylist, false);
		updateVolumeProgressBar(audioElement.audio);

		


		// Block Start => 
		// Function and event listeners to prevent default behaviour of the 'nowPlayingBarContainer'
		var eventContainer = document.querySelector('#nowPlayingBarContainer');

		eventContainer.addEventListener('mousedown', preventBehaviour);
		eventContainer.addEventListener('touchstart', preventBehaviour);
		eventContainer.addEventListener('mousemove', preventBehaviour);
		eventContainer.addEventListener('touchmove', preventBehaviour);

		function preventBehaviour(event){
			event.preventDefault();
		}
		// <= Block End


		document.querySelector('.playbackBar .progressBar').addEventListener('mousedown', function(){
			mouseDown = true;
		});

		document.querySelector('.playbackBar .progressBar').addEventListener('mousemove', function(e){
			if(mouseDown == true){
				//Set time of song, depending on the position of mouse
				timeFromOffset(e, this);
				//here, 'this' refers to the object '.playbackBar .progressBar' that called this event function
				// console.log(this);
			}
		});

		document.querySelector('.playbackBar .progressBar').addEventListener('mouseup', function(e){
			timeFromOffset(e, this);
			// console.log(this);
		});

		// var pgBarWidth = document.querySelector('.playbackBar .progressBar').innerWidth;

		document.addEventListener('mouseup', function(){
			mouseDown = false;
		});

		// var myWid = document.querySelector('.playbackBar .progressBar');
		// console.log(myWid.clientWidth);
		// console.log(window.innerWidth);








		document.querySelector('.volumeBar .progressBar').addEventListener('mousedown', function(){
			mouseDown = true;
		});


		document.querySelector('.volumeBar .progressBar').addEventListener('mousemove', function(e){
			if(mouseDown == true){
				var percentage = e.offsetX / this.clientWidth;

				if (percentage >= 0 && percentage <= 1) {

					audioElement.audio.volume = percentage;
					// console.log(percentage);
				}
			}
		});


		document.querySelector('.volumeBar .progressBar').addEventListener('mouseup', function(e){
			if(mouseDown == true){
				var percentage = e.offsetX / this.clientWidth;

				if (percentage >= 0 && percentage <= 1) {
					
					audioElement.audio.volume = percentage;
				}
			}
		});

	});
	// };
	// };

	// console.log(currentPlaylist);


	// =>Start: Function to offset the play position of the music play progress bar
	function timeFromOffset(mouse, progressBar){
		var percentage = mouse.offsetX / progressBar.clientWidth * 100;
		var seconds = audioElement.audio.duration * (percentage / 100);
		audioElement.setTime(seconds);
		// console.log(this.innerWidth + "xxx");
		// console.log(document);
		// console.log(window);
		// console.log(this);
	}
	// <= End of Function


	// =>Start: Function to handle skipping to the next song
	// function nextSong(){
	// 	if(currentIndex == currentPlaylist.length - 1){
	// 		currentIndex = 0;
	// 	}
	// 	else{
	// 		currentIndex++;
	// 	}

	// 	var trackToPlay = currentPlaylist[currentIndex];
	// 	setTrack(trackToPlay, currentPlaylist, true);

	// 	// console.log(trackToPlay);
	// 	// console.log(currentPlaylist);
	// }
	// <= End of Function


	function setTrack(trackId, newPlaylist, play){
		// audioElement.setTrack('assets/music/bensound-acousticbreeze.mp3');
		// $.post('includes/handlers/ajax/getSongJson.php', {songId: trackId}, function(data){
		// 	console.log(data);
		// });

		if(newPlaylist != currentPlaylist){
			currentPlaylist = newPlaylist;
			shufflePlaylist = currentPlaylist.slice();
			shuffleArray(shufflePlaylist);
		}

		if(shuffle == true){
			currentIndex = shufflePlaylist.indexOf(trackId);
		}

		else{
			currentIndex = currentPlaylist.indexOf(trackId);
		}

		pauseSong();

		var httpRequest = new XMLHttpRequest();
		// var httpRequest2 = new XMLHttpRequest();
		// var httpRequest3 = new XMLHttpRequest();

		var url = 'includes/handlers/ajax/getSongJson.php';
		var method = 'POST';

		httpRequest.open(method, url);
		httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		httpRequest.send(encodeURI('songId=' + trackId));
		httpRequest.onreadystatechange = function(){
			if (httpRequest.readyState === XMLHttpRequest.DONE && httpRequest.status === 200) {
				// console.log(httpRequest.responseText);

				// currentIndex = currentPlaylist.indexOf(trackId);
				
				var track = JSON.parse(httpRequest.responseText);
				// console.log(track);
				document.querySelector('.trackName span').innerHTML = track.title;

				// httpRequest2.open('POST', 'includes/handlers/ajax/getArtistJson.php');
				// httpRequest2.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
				// httpRequest2.send(encodeURI('artistId=' + track.artist));
				// httpRequest2.onreadystatechange = function(){
				// 	if (httpRequest2.readyState === XMLHttpRequest.DONE && httpRequest2.status === 200) {
				// 		// console.log(httpRequest2.responseText);

				// 		var artist = JSON.parse(httpRequest2.responseText);
				// 		document.querySelector('.artistName span').innerHTML = artist.name;
				// 		// console.log(artist.name);
				// 	}
				// }

				// httpRequest3.open('POST', 'includes/handlers/ajax/getAlbumJson.php');
				// httpRequest3.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
				// httpRequest3.send(encodeURI('albumId=' + track.album));
				// httpRequest3.onreadystatechange = function(){
				// 	if (httpRequest3.readyState === XMLHttpRequest.DONE && httpRequest3.status === 200) {
				// 		// console.log(httpRequest3.responseText);

				// 		var album = JSON.parse(httpRequest3.responseText);
				// 		document.querySelector('.albumLink img').setAttribute('src', album.artworkPath);
				// 		// console.log(album.artworkPath);
				// 	}
				// }

				
				var requestVar = 'httpRequest'; var url = 'includes/handlers/ajax/getArtistJson.php';
				var xid = 'artistId='; 	var yid = track.artist; var selector = '.trackInfo .artistName span';
				var jsonVar = 'artist'; var jsMethod = 'innerHTML';

				myHttpRequest(requestVar, url, xid, yid, selector, jsonVar, jsMethod);





				var requestVar = 'httpRequest'; var url = 'includes/handlers/ajax/getAlbumJson.php';
				var xid = 'albumId='; 	var yid = track.album; var selector = '.content .albumLink img';
				var jsonVar = 'album'; 	var jsMethod = 'setAttribute';

				myHttpRequest(requestVar, url, xid, yid, selector, jsonVar, jsMethod);

				// console.log('\n');
				// console.log(httpRequest.responseText);
				// console.log(track);
				// console.log(track.path);


				audioElement.setTrack(track);
				// audioElement.play();
				// playSong();

				if(play == true){
					// playButton.style.display = 'none';
					// pauseButton.style.display = 'inline-block';
					// audioElement.play();
					playSong();
				}

				// console.log('\n');
				// console.log(httpRequest.responseText);
				// console.log(data);
			}
		}

		// if(play == true) {
		// 	playButton.style.display = 'none';
		// 	pauseButton.style.display = 'inline-block';
		// 	audioElement.play();
		// 	console.log('Playing!');
		// }
	}



	function playSong(){

		if(audioElement.audio.currentTime == 0){
			var requestVar = 'httpRequest'; var url = 'includes/handlers/ajax/updatePlays.php';
			var xid = 'songId='; var yid = audioElement.currentlyPlaying.id;

			myHttpUpdate(requestVar, url, xid, yid);
		}
		
		// console.log(playButton);
		playButton.style.display = 'none';
		pauseButton.style.display = 'inline-block';
		audioElement.play();
	}



	function pauseSong(){
		// console.log(pauseButton);
		playButton.style.display = 'inline-block';
		pauseButton.style.display = 'none';
		audioElement.pause();
	}



	function nextSong(){
		if(repeat == true){
			audioElement.setTime(0);
			playSong();
			return;
		}

		if(currentIndex == currentPlaylist.length - 1){
			currentIndex = 0;
			// return;
		}
		else{
			currentIndex++;
			// return;
		}

		var trackToPlay = shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex];
		setTrack(trackToPlay, currentPlaylist, true);
		// audioElement.play();

		// console.log(trackToPlay);
		// console.log(currentPlaylist);
	}



	function prevSong(){
		if (audioElement.audio.currentTime >= 3 || currentIndex == 0 || repeat == true){
			audioElement.setTime(0);
			// return;
		}

		else{
			currentIndex = currentIndex - 1;
			setTrack(currentPlaylist[currentIndex], currentPlaylist, true);
			// return;
		}
	}



	function setRepeat(){
		repeat = !repeat;
		var imageName = repeat ? "repeat-active.png" : "repeat.png";
		document.querySelector('.controlButton.repeat img').setAttribute('src', 'assets/images/icons/' + imageName);
	}



	function setMute(){
		audioElement.audio.muted = !audioElement.audio.muted;
		var imageName = audioElement.audio.muted ? "volume-mute.png" : "volume.png";
		document.querySelector('.controlButton.volume img').setAttribute('src', 'assets/images/icons/' + imageName);
	}



	function setShuffle(){
		shuffle = !shuffle;
		var imageName = shuffle ? "shuffle-active.png" : "shuffle.png";
		document.querySelector('.controlButton.shuffle img').setAttribute('src', 'assets/images/icons/' + imageName);

		if (shuffle == true){
			// Randomize playlist
			shuffleArray(shufflePlaylist);
			currentIndex = shufflePlaylist.indexOf(audioElement.currentlyPlaying.id);
		}

		else{
			// Shuffle has been turned off
			// Go back to regular playlist
			currentIndex = currentlyPlaying.indexOf(audioElement.currentlyPlaying.id);
		}
	}

	function shuffleArray(a){
		var j, x, i;
		for(i = a.length; i; i--){
			j = Math.floor(Math.random() * i);
			x = a[i - 1];
			a[i - 1] = a[j];
			a[j] = x;
		}
	}

</script>

<div id="nowPlayingBarContainer">
	<div id="nowPlayingBar">

		<div id="nowPlayingLeft">
			<div class="content">
				<span class="albumLink">
					<img role="link" tabindex="0" src="" class="albumArtWork">
				</span>

				<div class="trackInfo">

					<span class="trackName">
						<span role="link" tabindex="0"></span>
					</span>

					<span class="artistName">
						<span role="link" tabindex="0"></span>
					</span>
				</div>

			</div>
		</div>


		<div id="nowPlayingCenter">

			<div class="content playerControls">

				<div class="buttons">

					<button class="controlButton shuffle" title="Shuffle button" onclick="setShuffle()">
						<img src="assets/images/icons/shuffle.png" alt="Shuffle">
					</button>

					<button class="controlButton previous" title="Previous button" onclick="prevSong()">
						<img src="assets/images/icons/previous.png" alt="Previous">
					</button>

					<button class="controlButton play" title="Play button" onclick="playSong()">
						<img src="assets/images/icons/play.png" alt="Play">
					</button>

					<button class="controlButton pause" title="Pause button" style="display: none;" onclick="pauseSong()">
						<img src="assets/images/icons/pause.png" alt="Pause">
					</button>

					<button class="controlButton next" title="Next button" onclick="nextSong()">
						<img src="assets/images/icons/next.png" alt="Next">
					</button>

					<button class="controlButton repeat" title="Repeat button" onclick="setRepeat()">
						<img src="assets/images/icons/repeat.png" alt="Repeat">
					</button>
				</div> <!-- End buttons -->


				<div class="playbackBar">
					<span class="progressTime current">0.00</span>
						<div class="progressBar">
							<div class="progressBarBg">
								<div class="progress"></div>
							</div>
						</div>
					<span class="progressTime remaining">0.00</span>
				</div>
			</div>
		</div>


		<div id="nowPlayingRight">
			<div class="volumeBar">
				
				<button class="controlButton volume" title="Volume button" onclick="setMute()">
					<img src="assets/images/icons/volume.png" alt="Volume">
				</button>

				<div class="progressBar">
					<div class="progressBarBg">
						<div class="progress"></div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>